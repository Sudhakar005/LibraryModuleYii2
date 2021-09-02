<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="authors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'author_name') ?>

    <?= $form->field($model, 'date_of_birth') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
