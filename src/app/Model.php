<?php
namespace App;

use PDO;
use PDOException;
use App;
use Services\Validators;

// Основная модель для работы с БД
Abstract class Model
{
	/** @var object obj PDO */
    protected object $db;
	
	/** @var string */
    protected string $table;

	/**
     * Подготовить параметры при инициализации класса
     */
    public function __construct()
    {
		// Подключиться к БД
		$this->db = App::$db->pdo;
		
		// Имя запрашивоемой таблицы
        $this->table = strtolower(explode('\\',get_class($this))[1]);
    }

	/**
     * Получить имя таблицы
     * @return string
     */
    public function getTableName() : string {
        return $this->table;
    }

	/**
     * Запись в таблицу базу данных
     * @return bool
     */
    public function save() : bool 
	{
        $AllFields = array_keys($this->fieldsTable());
        $SetFields = array();
        $arrayData = array();

        foreach($AllFields as $field) 
		{
			// Проверяем соотвествие полей модели таблицы
            if (!empty($this->$field)) {
                $SetFields[] = $field;
                $arrayData[] = $this->$field;
            }
        }
		
		// Преобразование данных для подготовленного запроса
        $forQueryFields = implode(', ', $SetFields);
        $rangePlace		= array_fill(0, count($SetFields), '?');
        $forQueryPlace  = implode(', ', $rangePlace);
         
		// Выполнить подготовленный запрос на добавленние данных в таблицу БД
        try {
			$query = "INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)";
			$stmt = $this->db->prepare($query);
			$result = $stmt->execute($arrayData);

        } catch(PDOException $e) {
            echo 'Error : '.$e->getMessage();
            return false;
        }
        return $result;
    }

	/**
     * Проверить и подготовить данные для добавления в таблицу БД
     *
     * @parram array $data		// передоваемые поля
     * @parram array $fields	// ограничение полей
     * @parram array $errors	// описания сообщений на правила ограничений
	 * 
     * @return array
     */
	public function employ(array $data, array $fields, array $errors=[]) : array 
	{
		$employ = new Validators();

		if (!$error = $employ->validate($data, $fields, $errors)) {
			foreach($fields as $value => $key){
				if (property_exists($this, $value)) {
					$this->$value = $data[$value];
				}
			}
		}
		return $error;
	}

	/**
     * Получить все записи из таблицы
     * @return array
     */
    public function getAll() : array 
	{
		try{
			$query = "SELECT * FROM $this->table ORDER BY id DESC";
			$stmt = $this->db->query($query);
			$rows =	$stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e) {
			echo 'Error : '.$e->getMessage();
			exit;
		}
		return $rows;
	}
}