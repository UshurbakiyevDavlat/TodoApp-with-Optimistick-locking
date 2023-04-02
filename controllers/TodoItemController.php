<?php

namespace app\controllers;

use app\models\TodoItem;
use app\services\TodoItemService;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TodoItemController extends Controller
{
    private TodoItemService $todoItemService;

    public function __construct($id, $module, TodoItemService $todoItemService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->todoItemService = $todoItemService;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TodoItem::find()->orderBy(['priority' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new TodoItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $redirect = $this->todoItemService->update($model, $id);
            } catch (\Exception $exception) {
                Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
                Yii::$app->session->setFlash('error', 'Conflict, item was changed by another user, your changes will be lost. [Edit again] [Cancel]');
                return $this->render('update', [
                    'model' => $model,
                    'editAgain' => true
                ]);
            }

            return $this->redirect($redirect);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * @throws \Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \JsonException|InvalidConfigException
     */
    public function actionDone($id): array
    {
        $request = Yii::$app->getRequest();
        $response = Yii::$app->getResponse();
        $body = $request->getRawBody();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        $model = $this->findModel($id);

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
        return ['success' => false, 'message' => 'Invalid request', 'params' => $request->getBodyParams()];
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?TodoItem
    {
        if (($model = TodoItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Item does not exist.');
    }
}
