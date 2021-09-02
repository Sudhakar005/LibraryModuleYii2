<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Authors */

$this->title = $model->author_id;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'author_id',
            'author_name',
            'date_of_birth',
            'author_email',
            'no_of_books',
            'created_at',
            'modified_at',
        ],
    ]) ?>

</div>
