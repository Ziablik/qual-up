<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Questions */

$this->title = 'Создание задания';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
