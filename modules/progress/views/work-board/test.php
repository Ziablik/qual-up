<?php
/* @var $this yii\web\View */
/* @var $test \app\modules\constructor\models\Tests */

//\yii\helpers\VarDumper::dump($test->tquests,10,true);

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\yii\helpers\VarDumper::dump($_POST,10,true);
?>

<?= Html::beginForm('', 'post'); ?>

<?php foreach ($test->tquests as $tquest): ?>

<fieldset class="form-group">
    <div class="row">
        <legend class="col-form-label col-sm-6 pt-0"><?= $tquest->description ?></legend>
        <div class="col-sm-6">

            <?php foreach ($tquest->qvariants as $qvariant): ?>

            <div class="form-check">
                <input class="form-check-input" type="radio" name=<?= 'id='.$tquest->id ?> id="gridRadios1" value="1" checked>
                <label class="form-check-label" for="gridRadios1">
                    <?= $qvariant->text ?>
                </label>
            </div>

            <?php endforeach;?>

        </div>
    </div>
</fieldset>

<?php endforeach; ?>

<div class="form-group">
    <?= Html::submitButton('Далее', ['class' => 'btn btn-success']) ?>
</div>

<?php Html::endForm(); ?>