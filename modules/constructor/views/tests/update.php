<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Tests */

$this->title = 'Обновление теста: ' . $model->type == 'common_test' ? $model->theme->name : $model->program->name;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
