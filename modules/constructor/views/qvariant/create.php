<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Qvariant */

$this->title = 'Create Qvariant';
$this->params['breadcrumbs'][] = ['label' => 'Qvariants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qvariant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
