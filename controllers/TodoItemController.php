<?php

namespace app\controllers;

use app\models\TodoItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TodoItemController extends Controller
{
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
            // get the latest version of the model from the database
            $latestModel = $this->findModel($id);

            // update the model attributes with the ones from the submitted form
            $latestModel->attributes = Yii::$app->request->post('TodoItem');

            // update the version attribute
            $latestModel->version = $model->version;

            try {
                if ($latestModel->save()) {
                    return $this->redirect(['view', 'id' => $latestModel->id]);
                }
            } catch (StaleObjectException $e) {
                Yii::$app->session->setFlash('error', 'The record has been updated by another user. Please reload the page and try again.');
                $model = $this->findModel($id);
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
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
     */
    public function actionToggleDone($id)
    {
        $model = $this->findModel($id);
        $model->done = !$model->done;
        $model->save(false); // disable validation to allow for optimistic locking to work

        return $this->redirect(['view', 'id' => $model->id]);
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
