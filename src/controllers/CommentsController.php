<?php
namespace Controllers;

use App\Controller;
use Models\Comments;

/**
 * Контроллер 'Comments' "Коментарии"
 */
class CommentsController extends Controller
{
	/**
     * Индексная страница
     */
	public function actionIndex()
	{
		$model = new Comments();
		$items = $model->getAll(); // получаем все строки
		$info = $model->get_info();

		$data = [
			'items' => $items,
			'info' => $info
		];

		return $this->generate('comments/index.php', 'template.php', $data);
	}

	/**
     * Добавление комментария
	 * @return bool
     */
	public function actionCreate()
	{
		// Передаваеммые параметры
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$data = $_REQUEST;

			$model	= new Comments();
			$fields = $model->rules();

			// Проверка и подготовка данных
			if (!$error = $model->employ($data, $fields, $model->get_errors())) {
				
				// Сохранение данных в таблицу БД
				if ($model->save()) {

					$status = array(
						'error'  => 0
					);
					echo json_encode($status);
					return false;
				}
			}

			// Статус об ошибке
			$status = array(
				'error'  => 1,
				'message' => $error
			);
			echo json_encode($status);
		}
		
		return false;
	}

	/**
     * Список комментариев
     */
	public function actionItems()
	{
		$model = new Comments();
		
		$items = $model->getAll(); // получаем все строки

		$data = [
			'items' => $items
		];

		return $this->generate('comments/items.php', '_blank.php', $data);
	}
	
	
	/**
     * Список комментариев для запроса Ajax Vue
     */
	public function actionAjax()
	{
		$model = new Comments();
		
		$items = $model->getAll();

		echo (json_encode($items));
	}
	
}