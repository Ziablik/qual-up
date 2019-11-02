<?php
/* @var $this yii\web\View */
/* @var $program \app\modules\constructor\models\Programs */


use yiister\gentelella\widgets\Panel;
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
                    foreach ($program->themes as $theme):
                        Panel::begin(
                            [
                                'header' => $theme->name,
                                'icon' => 'arrow-down',
                                'expandable' => true,
                            ]
                        )
                    ?>
                    <h2>Презентация к теме</h2>
                    <ul class="list-group">
                        <?php foreach ($theme->questions as $question): ?>
                        <li class="list-group-item">Задание: <?= $question->description ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <h2><?= \yii\helpers\Html::a('Ссылка на тест', 'test?id='.$theme->tests[0]->id)?></h2>
                    <div id="w1" class="active progress-striped progress">
                        <div class="progress-bar-success progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?= 100 ?>%"><span class="sr-only">70% Complete</span></div>
                    </div>
                    <?php Panel::end();?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>
