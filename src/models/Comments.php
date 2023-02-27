<?php
namespace Models;
use App\Model;

/**
 * Класс модели для таблицы 'Comments' Коментарии
 * 
 * @property string $id ID		Записи
 * @property string $name		Имя Пользователя
 * @property string $email		Емайл Пользователя
 * @property string $title		Заголовок комментария 
 * @property string $text		Текст комментария
 * @property string $date		Дата и время добавления
 */
class Comments extends Model
{
	/** @var string */
	public string $id;
	public string $name;
	public string $email;
	public string $title;
	public string $text;
	public string $date;
	
	/**
	 * Правила ограничений полей
	 * @return array
	 */
    public function rules() : array
    {
		return [
			'name'  => 'required, max:40',
			'email' => 'required | email | unique: comments,email',
			'title' => 'required | min: 10, max:255',
			'text'  => 'required | min: 10, max:255'
		];
	}
	
	/**
	 * Описание полей таблицы
	 * @return array
	 */
    public function fieldsTable() : array
	{
        return [
			'id'    => 'Id',
			'name'  => 'Name',
			'email' => 'Email',
			'title' => 'Title',
			'text'  => 'Text',
			'date'  => 'Date'
        ];
    }

	/** 
	 * Перезаписать сообщение по умолчанию на правило ограничений
	 * @return array
	 */
	public function get_errors() : array
	{	
		return [
			'required' => 'Поле %s обязательно',
		];
	}

	/** 
	 * Информация Контент
	 * @return array
	 */
	public function get_info() : array
	{	
		return array(

			array(
				'name' => 'Анализа существующих паттернов поведения',
				'description' => 'Также как постоянный количественный рост и сфера нашей активности требует анализа анализа существующих паттернов поведения. Есть над чем задуматься: реплицированные с зарубежных источников, современные исследования освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, своевременно верифицированы.'
			),

			array(
				'name' => 'Базовые сценарии поведения пользователей',
				'description' => 'Лишь базовые сценарии поведения пользователей, инициированные исключительно синтетически, указаны как претенденты на роль ключевых факторов. Как принято считать, сделанные на базе интернет-аналитики выводы представлены в исключительно положительном свете.'
			)

		);
	}
}