<?php
/* @var $this yii\web\View */
/* @var $program \app\modules\constructor\models\Programs */

use app\modules\progress\models\UserQuestion;
use yiister\gentelella\widgets\Panel;
$script = <<< JS
    $("[name='my-checkbox']").bootstrapSwitch();

    $("[name='my-checkbox']").each(function() {
        if (!$(this).attr('checked')) {
            $(this).parent().children().on('click', function(event) {
                $(this).parents('div.bootstrap-switch-mini').addClass('bootstrap-switch-disabled');
                $(this).parent().children().unbind();
                question_id = $(this).parents('div.col-md-1').prev().attr('question');
                $.ajax({
                    type: "POST",
                    url: "/progress/work-board/question-on",
                    data: {"question_id": question_id},
                    success: function(data) {
                        data = JSON.parse(data);
                        $("div[theme='"+ data.theme_id +"']").css('width', data.progress + '%').text(data.progress + '%');
                    }
                });
            })
        }
    });
    
    $("a[theme]").on('click', function(event) {
        theme_id = $(this).attr('theme');
        $.ajax({
            type: "POST",
            url: "/progress/work-board/presentation-success",
            data: {"theme_id": theme_id},
            success: function(data) {
                data = JSON.parse(data);
                $("div[theme='"+ data.theme_id +"']").css('width', data.progress + '%').text(data.progress + '%');
            }
        });
    });
    
    $('span.bootstrap-switch-handle-on').append('<i class="fa fa-check" aria-hidden="true"></i>')
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
                    <h1 style="text-align: center"><?= \yii\helpers\Html::a('Презентация введения', $program->presentation0->path, ['target' => '_blank']) ?></h1>
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
                    <h2><?= \yii\helpers\Html::a('Презентация к теме', $theme->presentation0->path, ['target' => '_blank', 'theme' => $theme->id]) ?></h2>
                    <ul class="list-group">
                        <?php foreach ($theme->questions as $question): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-11" question=<?= $question->id ?>>
                                    Задание: <?= $question->description ?>
                                </div>
                                <div class="col-md-1">
                                    <input type="checkbox" data-toggle="switch" data-size="mini" name="my-checkbox"
                                        <?php
                                            $user_question_model = UserQuestion::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['question_id' => $question->id])->one();
                                            if ($user_question_model->completed == 1){
                                                echo 'checked disabled ';
                                            }
                                        ?>
                                    data-on-text="" data-off-text="" data-on-color="success" data-off-color="danger">
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <h2><?= \yii\helpers\Html::a('Ссылка на тест', 'test?test_id='.$theme->tests[0]->id)?></h2>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?= $theme->userThemes[0]->progress ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" theme=<?= $theme->id ?>><?= $theme->userThemes[0]->progress ?>%</div>
                    </div>
                    <?php Panel::end();?>
                    <?php endforeach;?>
<!--                    <h1 style="text-align: center">--><?//= \yii\helpers\Html::a(
//                            ($program->progress == 100)?'Итоговый тест (доступен)':'Итоговый тест (не доступен)',
//                            $program->presentation0->path,
//                            ['target' => '_blank', 'style' => ($program->progress == 100)?'color:#5cb85c':'color:#90111A'])
//                    ?><!--</h1>-->
                </div>
            </div>
        </div>
    </div>
</div>
