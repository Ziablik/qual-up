<?php
/* @var $this yii\web\View */
/* @var $test \app\modules\constructor\models\Tests */
/* @var $answers_by_user array */
use yii\helpers\VarDumper;

?>


<?php foreach ($test->tquests as $tquest): ?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div id="w0" class="x_panel">
            <div class="x_title">
                <h1>
                    <i class="fa fa-question-circle"></i>
                    <?= $tquest->description ?>
                </h1>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <fieldset class="form-group">
                    <div class="row">
                        <div class="col-md-10">
                            <?php foreach ($tquest->qvariants as $qvariant): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label" for="gridRadios1">
                                        <h2>
                                            <?php
                                                if (in_array($qvariant->id, $answers_by_user['wrong']))
                                                    echo '<div class="text-danger">'. $qvariant->text .'</div>';
                                                elseif ($qvariant->id == $tquest->right_variant)
                                                    echo '<div class="text-success">'. $qvariant->text .'</div>';
                                                else
                                                    echo '<div>'. $qvariant->text .'</div>';
                                            ?>
                                        </h2>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
