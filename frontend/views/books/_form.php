<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Books */
/* @var $form yii\widgets\ActiveForm */
$customAuthorList = [];
if(count($authorList) > 0){
    foreach($authorList as $authorKey => $authorVal){
        $customAuthorList[$authorVal['author_id']] = $authorVal['author_name'];
    }
}
?>
<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'book_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->dropDownList([ 'Tamil' => 'Tamil', 'English' => 'English', 'Hindi' => 'Hindi', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'published_at')->textInput() ?>

    <?= $form->field($model, 'author_id')->dropDownList($customAuthorList, ['prompt' => 'Select', 'options'=>[$model->author_id => ["Selected" => true]]]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
