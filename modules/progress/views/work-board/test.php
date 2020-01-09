<?php
/* @var $this yii\web\View */
/* @var $test \app\modules\constructor\models\Tests */

//\yii\helpers\VarDumper::dump($test->tquests,10,true);

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$script = <<< JS
    $('div.next').click(function(event) {
        divQuest = $(this).parents('div.item.active');
        divQuest.removeClass('active');
        divQuest.next().addClass('active');
    })
JS;

$this->registerJs($script, yii\web\View::POS_READY)

//\yii\helpers\VarDumper::dump($_POST,10,true);
?>

<?php $carousel_html=[]; ?>

<?= Html::beginForm('', 'post'); ?>

<?php
    $count = 1;
    foreach ($test->tquests as $tquest){
        $button = ($count < count($test->tquests))?'<div class="btn btn-info next">Далее</div>':'<div class="form-group">'.Html::submitButton('Завершить', ['class' => 'btn btn-success']).'</div>';
        $answers_html = '';
        foreach ($tquest->qvariants as $qvariant){
            $answers_html .= '
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tquest_id='. $tquest->id .'" value='. $qvariant->id .' checked>
                                <label class="form-check-label" for="gridRadios1">
                                    <h2>'. $qvariant->text. '</h2>
                                </label>
                            </div>
        ';
        }
        array_push($carousel_html, '
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="w0" class="x_panel">
                    <div class="x_title">
                        <h1>
                            <i class="fa fa-question-circle"></i>'.
                            $tquest->description.'
                        </h1>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-md-10">'.
                                    $answers_html.'
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>'.
                $button.'
            </div>
        </div>'
        );
        $count+=1;
    }
?>

<?= yii\bootstrap\Carousel::widget([
        'items'=>$carousel_html,
        'clientOptions' => ['interval' => false, 'wrap' => false],
        'controls' => false
]); ?>
    <div class="form-group">
        <?= Html::submitButton('Завершить', ['class' => 'btn btn-success']) ?>
    </div>

<?php Html::endForm(); ?>