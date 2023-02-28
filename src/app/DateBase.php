<?php
namespace App;

use PDO;
/**
 * Сервис подключения БД.
 */
class DateBase
{
	/** @var object PDO() */
    public object $pdo;
    
	// Подготовить соеденение с БД
    public function __construct()
    {
        $settings = $this->getPDOSettings();
		$this->pdo = new PDO($settings['dsn'], $settings['user'], $settings['pass'], null);
	}
    
	// Настройки подключения
    // @return array
    protected function getPDOSettings() : array
    {
        $config = include ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'db.php';
        $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        return $result;       
    }
}