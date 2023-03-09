<?php
namespace App;

/**
 * Основной контроллер
 */
class Controller 
{
	/**
     * Генерация и подключение шаблона
     */
	public function generate(string $content_view, string $template_view, array $data = null) : void
	{
		if (is_array($data)) {
			foreach( $data as $key => $val ){
				extract($data[$key]);
			}		
		}
		// Динамически подключаем общий шаблон (внешний вид)
		include 'views/'.$template_view;
	}
}