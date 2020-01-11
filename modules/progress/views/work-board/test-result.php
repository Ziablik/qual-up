<?php
/* @var $this yii\web\View */
/* @var $test \app\modules\constructor\models\Tests */

/* @var $answers_by_user array */

use yii\helpers\VarDumper;
$test_complete = (count($answers_by_user['right'])/(count($answers_by_user['right']) + count($answers_by_user['wrong']))*100 >=70);
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div id="w0" class="x_panel" style="<?= $test_complete?'background-color: #1ABB9C;':'background-color: #f78989; border: 1px solid #f78989; color: #fff;' ?>">
            <div class="x_title">
                <h1 style="text-align: center">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <?= $test_complete?'Поздравляем':'Попробуйте еще раз (доступен, осталась '. (2-$user_test_model->count_attempts) .' попытка)' ?>
                </h1>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h1 style="text-align: center">
                    Ваш результат: <?= count($answers_by_user['right']). ' из ' .(count($answers_by_user['right']) + count($answers_by_user['wrong'])) ?>
                </h1>
            </div>
        </div>
    </div>
</div>
