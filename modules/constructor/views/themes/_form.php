<?php

use app\modules\constructor\models\Programs;
use app\modules\constructor\models\Tests;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Themes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="themes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'program_id')
        ->dropDownList(ArrayHelper::map(Programs::find()->all(), 'id', 'name'))
        ->label('Выберите образовательную программу')
    ?>

    <?= $form->field($model, 'presentation')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
