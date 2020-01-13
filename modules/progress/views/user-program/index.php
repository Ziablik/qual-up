<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\progress\models\search\UserProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Прогресс пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-program-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user.username',
            'program.name',
            'progress',
            [
                'attribute' => 'finish_test_is_complete',
                'content' => function($model){
                    return $model->finish_test_is_complete?'<i class="fa fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                }
            ],
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
