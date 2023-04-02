<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TodoItem $model */

$this->title = 'Create Todo Item';
$this->params['breadcrumbs'][] = ['label' => 'Todo Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todo-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'editAgain' => $editAgain ?? false,
    ]) ?>

</div>
