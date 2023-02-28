<?php
namespace Services;

use App\DateBase;

/**
 * Сервис проверки данных в соотвествии с правилами ограничений
 */
class Validators{

	// Параметры правил ограничений
	public const DEFAULT_VALIDATION_ERRORS = [
		'required' => 'Пожалуйста, введите %s',
		'email' => '%s не является действительным адресом электронной почты',
		'min' => 'В %s должно быть не менее символов %s',
		'max' => 'В %s должно быть от %d до %d символов',
		'between' => 'В %s должно быть от %d до %d символов',
		'same' => '%s должно совпадать с %s',
		'alphanumeric' => 'В %s должны быть только буквы и цифры',
		'secure' => '%s должен содержать от 8 до 64 символов и содержать по крайней мере одну цифру, одну заглавную букву, одну строчную букву и один специальный символ',
		'unique' => '%s уже существует',
	];

	/**
	 * Проверка переданных данных и параметров правил ограничений
	 *
	 * @param array $data			// передаваемые данные
	 * @param array $fields			// передаваемые параметры правил ограничений
	 * @param array $messages		// произвольное описания парраметров ограничений
	 *
	 * @return array
	 */
	public function validate(array $data, array $fields, array $messages = []) : array
	{
		// Создать стрелочную функцию для преобразования массива
		$split = fn($str, $separator) => array_map('trim', explode($separator, $str));

		// Получить описания сообщений
		$rule_messages = array_filter($messages, fn($message) => is_string($message));
		
		// Перезаписать сообщение по умолчанию
		$validation_errors = array_merge(Self::DEFAULT_VALIDATION_ERRORS, $rule_messages);

		$errors = [];

		// Итерация полученных правил ограничений
		foreach ($fields as $field => $option) {

			$rules = $split($option, '|');

			foreach ($rules as $rule) {
				
				// Получить параметры имени правила
				$params = [];
				
				// Если правило имеет параметры, например, min: 1
				if (strpos($rule, ':')) {
					
					[$rule_name, $param_str] = $split($rule, ':');
					$params = $split($param_str, ',');
					
				} else {
					$rule_name = trim($rule);
				}
				
				// Обратный вызов должен быть 'is_<правило>' например: is_required
				$fn = 'is_' . $rule_name;
				
				if (is_callable([Validators::class, $fn])) {
					
					$pass = $this->$fn($data, $field, ...$params);
					
					// получить сообщение об ошибке для определенного поля и правила, если оно существует
					// в противном случае получите сообщение об ошибке из $validation_errors
					if (!$pass) {
						$errors[$field] = sprintf(
							$messages[$field][$rule_name] ?? $validation_errors[$rule_name],
							$field, ...$params
						);
					}
				}
			}
		}
		
		return $errors;
	}

	/**
	 * Проверить заполнено ли поле
	 *
	 * @param array $data
	 * @param string $field
	 *
	 * @return bool
	 */
	public function is_required(array $data, string $field) : bool
	{
		return isset($data[$field]) && trim($data[$field]) !== '';
	}

	/**
	 * Проверить является ли значение действительным адресом электронной почты
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 *
	 * @return bool
	 */
	public function is_email(array $data, string $field) : bool
	{
		if (empty($data[$field])) {
			return true;
		}

		return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Проверить содержит ли строка хотя бы минимальную длину
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 * @param int $min			// минимальное кол-во символов
	 *
	 * @return bool
	 */
	public function is_min(array $data, string $field, int $min) : bool
	{
		if (!isset($data[$field])) {
			return true;
		}

		return mb_strlen($data[$field]) >= $min;
	}

	/**
	 * Проверить превышат ли строка максимальную длину
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 * @param int $max			// максимальное кол-во символов
	 *
	 * @return bool
	 */
	public function is_max(array $data, string $field, int $max): bool
	{
		if (!isset($data[$field])) {
			return true;
		}

		return mb_strlen($data[$field]) <= $max;
	}

	/**
	 * Проверить превышат ли строка максимальную длину и содержит ли минимальную
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 * @param int $min			// минимальное кол-во символов
	 * @param int $max			// максимальное кол-во символов
	 *
	 * @return bool
	 */
	public function is_between(array $data, string $field, int $min, int $max): bool
	{
		if (!isset($data[$field])) {
			return true;
		}

		$len = mb_strlen($data[$field]);
		return $len >= $min && $len <= $max;
	}

	/**
	 * Проверить равна ли одна строка другой
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 * @param string $other		// передаваемое поле для сравнения
	 *
	 * @return bool
	 */
	public function is_same(array $data, string $field, string $other) : bool
	{
		if (isset($data[$field], $data[$other])) {
			return $data[$field] === $data[$other];
		}

		if (!isset($data[$field]) && !isset($data[$other])) {
			return true;
		}

		return false;
	}

	/**
	 * Проверуть является ли строка буквенно-цифровой
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 *
	 * @return bool
	 */
	public function is_alphanumeric(array $data, string $field) : bool
	{
		if (!isset($data[$field])) {
			return true;
		}

		return ctype_alnum($data[$field]);
	}

	/**
	 * Проверить является ли пароль безопасным
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 *
	 * @return bool
	 */
	public function is_secure(array $data, string $field) : bool
	{
		if (!isset($data[$field])) {
			return false;
		}

		$pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
		return preg_match($pattern, $data[$field]);
	}

	/**
	 * Проверить является ли поле уникальным в столбце таблицы
	 *
	 * @param array $data		// передаваемое значение поля
	 * @param string $field		// передаваемый параметр ограничения
	 * @param string $table		// наименование таблицы
	 * @param string $column	// наименование колонки
	 *
	 * @return bool
	 */
	function is_unique(array $data, string $field, string $table, string $column) : bool
	{
		$db = new DateBase();
		$query = "SELECT $column FROM $table WHERE $column = :value";
		$stmt = $db->pdo->prepare($query);
		$stmt->bindValue(":value", $data[$field]);
		$stmt->execute();
		
		return $stmt->fetchColumn() === false;
	}
}