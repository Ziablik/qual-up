<?php
/* @var $this yii\web\View */
/* @var $program \app\modules\constructor\models\Programs */

use yiister\gentelella\widgets\Panel;
$script = <<< JS
    $("[name='my-checkbox']").bootstrapSwitch();
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div id="w0" class="x_panel">
            <div class="x_title">
                <h1>
                    <i class="fa fa-laptop"></i>
                    <?= $program->name ?>
                </h1>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12">
                    <h2>Презентация введения</h2>
<!--                    <iframe src="http://docs.google.com/viewer?url=http://panel.origami-test.ru/uploads/files/$2y$13$orC/23/zBSjv08axk.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>-->
                    <?php
                    $isAccess = true;
                    foreach ($program->themes as $theme):
                        Panel::begin(
                            [
                                'header' => $theme->name,
                                'icon' => $isAccess?'arrow-down':'close',
                                'expandable' => true,
                                'hideArrow' => !$isAccess,
                            ]
                        );
                    if ($theme->userThemes[0]->progress != 100)
                        $isAccess = false;
                    ?>
                    <h2>Презентация к теме</h2>
                    <ul class="list-group">
                        <?php foreach ($theme->questions as $question): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-11">
                                    Задание: <?= $question->description ?>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" data-toggle="switch" data-size="mini" name="my-checkbox">
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <h2><?= \yii\helpers\Html::a('Ссылка на тест', 'test?id='.$theme->tests[0]->id)?></h2>
                    <div id="w1" class="active progress-striped progress">
                        <div class="progress-bar-success progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?= $theme->userThemes[0]->progress ?>%"><span class="sr-only"></span></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?= $theme->userThemes[0]->progress ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $theme->userThemes[0]->progress ?>%</div>
                    </div>
                    <?php Panel::end();?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
