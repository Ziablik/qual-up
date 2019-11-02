<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\constructor\models\Tests;
use app\modules\constructor\models\Qvariant;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Tquest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tquest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'right_variant')
        ->dropDownList(ArrayHelper::map(
                $model->qvariants ? Qvariant::find()->where(['tquest_id' => $model->id])->all()
                : Qvariant::find()->all(),
                'id',
                'text'))
        ->label('Выберите правильный ответ') ?>

    <?= $form->field($model, 'test_id')
        ->dropDownList(ArrayHelper::map(Tests::find()->all(), 'id', 'theme.name'))
        ->label('Выберите тест для задания') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
