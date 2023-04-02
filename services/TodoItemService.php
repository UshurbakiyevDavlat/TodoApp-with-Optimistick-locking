<?php

namespace app\services;

use app\models\TodoItem;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
    public function update($model): array
    {
        $result = [];
        // get the latest version of the model from the database
        $latestModel = $model;
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

    public function done($request,$response, $data,$model): array
    {
        if ($request->isPut && $data['done'] !== null) {
            $model->done = (bool)$data['done'];
            if ($model->save()) {
                $response->statusCode = 200;
                $response->format = Response::FORMAT_JSON;
                return ['success' => true, 'done' => $model->done];
            }
            $response->statusCode = 422;
            $response->format = Response::FORMAT_JSON;
            return ['success' => false, 'errors' => $model->errors];
        }

        $response->statusCode = 400;
        $response->format = Response::FORMAT_JSON;
        return ['success' => false, 'message' => 'Invalid request'];
    }
}
