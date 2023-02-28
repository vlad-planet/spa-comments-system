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
     * @return void
     */
	public function actionIndex() : void
	{
		$this->generate('main/index.php', 'template.php');
	}
	
	/**
     * Страница об ошибке
     * @return void
     */
	public function actionError() : void
	{
		$this->generate('404_view.php', 'template.php');
	}
}