<?php
/**
 * Сервис Локатор: компоненты нашего приложения.
 */
class App
{
    /** @var obj App\Router() */    
    public static $router;
	
	/** @var obj App\Kernel() */
    public static $kernel;
	
	/** @var obj App\DateBase() */
	public static $db;

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