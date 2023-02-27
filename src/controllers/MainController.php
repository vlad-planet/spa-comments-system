<?php
namespace Controllers;

use App\Controller;

/**
 * Главный контроллер
 */
class MainController extends Controller
{
	/**
     * Индексная страница
     */
	public function actionIndex()
	{
		return $this->generate('main/index.php', 'template.php');
	}
	
	/**
     * Страница об ошибке
     */
	public function actionError()
	{
		return $this->generate('404_view.php', 'template.php');
	}
}