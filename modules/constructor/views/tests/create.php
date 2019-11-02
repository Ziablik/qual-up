<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Tests */

$this->title = 'Создание теста';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
