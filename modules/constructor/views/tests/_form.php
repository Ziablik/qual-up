<?php

use app\modules\constructor\models\Programs;
use app\modules\constructor\models\Themes;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\constructor\models\Tests */
/* @var $form yii\widgets\ActiveForm */

$script = <<<JS
    $('.field-tests-program_id').hide();
    $('select#tests-type').on('change', function() {
      if(this.value === 'common_test'){
          $('.field-tests-program_id').hide();
          $('.field-tests-theme_id').show();
      }
      else{
          $('.field-tests-theme_id').hide();
          $('.field-tests-program_id').show();
      }
    })
JS;
$this->registerJs($script, yii\web\View::POS_READY)
?>

<div class="tests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([
        'common_test' => 'Тест для темы',
        'finish_test' => 'Итоговый тест'
    ])->label('Выберите тип теста') ?>

    <?= $form->field($model, 'theme_id')
        ->dropDownList(ArrayHelper::map(Themes::find()->all(), 'id', 'name'))
        ->label('Выберите тему') ?>

    <?= $form->field($model, 'program_id')
        ->dropDownList(ArrayHelper::map(Programs::find()->all(), 'id', 'name'))
        ->label('Выберите образовательрную программу') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
