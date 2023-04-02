<?php
namespace app\services;

use app\models\TodoItem;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class TodoItemService
{
    private TodoItem $todoItemRepository;

    public function __construct(TodoItem $todoItemRepository)
    {
        $this->todoItemRepository = $todoItemRepository;
    }

    /**
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function update($model, $id): array
    {
        $result = [];
        // get the latest version of the model from the database
        $latestModel = $this->todoItemRepository->findOne($id);
        if (!$latestModel) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // update the model attributes with the ones from the submitted form
        $latestModel->attributes = Yii::$app->request->post('TodoItem');

        // update the version attribute
        $latestModel->version = $model->version;

        try {
            if ($latestModel->save()) {
                $result = ['view', 'id' => $latestModel->id];
            }
        } catch (StaleObjectException $e) {
            throw new StaleObjectException($e->getMessage());
        }
        return $result;
    }
}
