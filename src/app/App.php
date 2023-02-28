<?php
/**
 * Сервис Локатор: компоненты нашего приложения.
 */
class App
{
    /** @var object App\Router() */
    public static object $router;
	
	/** @var object App\Kernel() */
    public static object $kernel;
	
	/** @var object App\DateBase() */
	public static object $db;

	// Инициализация класса
    public static function init() : void
    {
        spl_autoload_register(['static','loadClass']);
        static::bootstrap();
    }
    
	// Подключение файлов ядра
    public static function bootstrap()
    {
        static::$router = new App\Router();
        static::$kernel = new App\Kernel();
		static::$db 	= new App\DateBase();
    }
    
	// Подключение запрашиваемого класса
    public static function loadClass ($className)
    {
		$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
		require_once ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php';
    }
}