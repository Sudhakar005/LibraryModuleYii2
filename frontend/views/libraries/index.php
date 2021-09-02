<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LibrariesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libraries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libraries-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Libraries', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'opening_time',
            'closing_time',
            'no_of_books',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
