<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\constructor\models\Tquest;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Qvariant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qvariant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tquest_id')->dropDownList(ArrayHelper::map(Tquest::find()->all(), 'id', 'description')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
