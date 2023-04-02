<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TodoItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="todo-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'done')->checkbox() ?>

    <?= $form->field($model, 'version')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?php if (!$editAgain) : ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?php elseif ($editAgain) : ?>
            <?= Html::a('Edit again', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>

        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?>

        <?php if (!$model->isNewRecord) : ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
