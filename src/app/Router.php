<?php
namespace App;
/**
 * Класс-маршрутизатор.
 */
class Router
{
	/**
     * Распределение парамметров запроса
	 * @return array
     */
    public function resolve () : array
    {
		$route =  null;
        
        if(($pos = strpos($_SERVER['REQUEST_URI'], '?')) !== false){
			$route = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }
		
        $route = is_null($route) ? $_SERVER['REQUEST_URI'] : $route;
        $route = explode('/', $route);
        array_shift($route);
        $result[0] = array_shift($route);
        $result[1] = array_shift($route);
        $result[2] = $route;
        return $result;
    }
}