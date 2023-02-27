<?php
namespace App;

use App;

/**
 * Ядро приложения
 */
class Kernel 
{
	// Контроллер по умолчанию
    public $defaultControllerName = 'CommentsController'; // MainController
    
	// Екшен по умолчанию
    public $defaultActionName = "actionIndex";
	
	/**
     * Подключения запрашиваемого контроллера и экшена
	 * @return void
     */
    public function launch() : void {
		
        list($controllerName, $actionName, $params) = App::$router->resolve();
        echo $this->launchAction($controllerName, $actionName, $params);  
    }

	/**
     * Обработчик парамметров подключения контроллеров и экшенов
	 *
	 * @param string $controllerName	// наименование контроллера
	 * @param string $actionName		// наименование эшена
	 * @param array $params				// передаваемые парраметры
	 *
	 * @return mixed 					// содержимое эшена
     */
    public function launchAction( string $controllerName, ? string $actionName, array $params)
	{
		// Определение имени запрашиваеммого контроллера
        $controllerName = empty($controllerName) ? $this->defaultControllerName : ucfirst($controllerName.'Controller');
		
		// Подключение файла контроллера
		$file = ROOTPATH.'/Controllers/'.$controllerName.'.php';
        if(!file_exists($file)){
			Kernel::ErrorPage404();
        }
        require_once $file;
		
		// Проверка класса контроллера
		$class = "\\Controllers\\".ucfirst($controllerName);
        if(!class_exists($class)){
            Kernel::ErrorPage404();
        }
		
		// Создание объекта класса
        $controller = new $class;
        $actionName = empty($actionName) ? $this->defaultActionName : $actionName = 'action'.$actionName;
       
	    // Проверка экшена контроллера
		if (!method_exists($controller, $actionName)){
			Kernel::ErrorPage404();
        }

		// Подключение экшена
        return $controller->$actionName($params);
    }

	/**
     * Отображение страницы 404 Not Found
	 * @return void
     */
	public static function ErrorPage404() : void
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('Location:'.$host.'main/error');
    }
}