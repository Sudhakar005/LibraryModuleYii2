<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Libraries */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<div class="libraries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'opening_time',
            'closing_time',
            'no_of_books',
            'created_at',
            'modified_at',
        ],
    ]) ?>

</div>
<h1>Books Details</h1>
<table border='1'>
        <thead>
            <th>Title</th>
            <th>Author Name</th>
            <th>Publication Date</th> 
            <th>Action</th> 
        </thead>
        <tbody>
            <?php
            if(count($model->books_details) > 0){
                foreach($model->books_details as $bookKey => $bookVal){?>
                    <tr>
                        <td><?= $bookVal['book_title']; ?></td>
                        <td><?= isset($authorListArray[$bookVal['author_id']]) ? $authorListArray[$bookVal['author_id']] : 'Not Set'; ?></td>
                        <td><?= $bookVal['published_at']; ?></td>
                        <td><?= Html::submitButton('Un Assign Book', ['class' => 'btn btn-primary unassignbook', 'data-bookid' => $bookVal['book_id'], 'data-libraryid' => $bookVal['library_id']]) ?></td>
                    </tr>
            <?php }}else{?>
                <td>No Records Found.</td>
            <?php }?>
        </tbody>
</table>
<h1>Assign Books To This Library</h1>
<?php
$listArray = [];
if(count($model->books_list) > 0){
    foreach($model->books_list as $key => $val){
        $listArray[$val['book_id']] = $val['book_title'];
    }
}
?>
<?php $form = ActiveForm::begin(['action' => ['libraries/assignbook']]); ?>
<?= $form->field($model, 'library_id')->hiddenInput(['value'=> $model->id])->label(false);?>
<?= $form->field($model, 'books_list')->dropDownList($listArray, ['prompt' => 'select']) ?>
<div class="form-group">
    <?= Html::submitButton('Assign Book', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<script>
$(document).on('click', '.unassignbook:button', function () {
		$bookId= $(this).attr('data-bookid');
        $libraryId= $(this).attr('data-libraryid');
        $PageUrl = '<?php echo Yii::$app->homeUrl . '?r=libraries/unassignbook'; ?>';
        $redirectUrl = '<?php echo Yii::$app->homeUrl . '?r=libraries'; ?>';
        $.ajax({
            url: $PageUrl,
            type: 'POST',
            data:'book_id ='+$bookId+'&library_id='+$libraryId,            
            success: function (result) {
                window.location.href = $redirectUrl;
            },
            error: function (error) {
                
            }
        });
	});
</script>