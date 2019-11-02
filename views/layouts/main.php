<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-paw"></i></a>
                </div>
                <div class="clearfix"></div>

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    [
                                        "label" => "Рабочий стол",
                                        "url" => Yii::$app->user->can('admin') ? "/site/index" : ['/progress/work-board/index'],
                                        "icon" => "home"
                                    ],
                                    [
                                        "label" => "Конструктор",
                                        "icon" => "cogs",
                                        "url" => "#",
                                        'visible' => Yii::$app->user->can('admin'),
                                        "items" => [
                                            [
                                                "label" => "Образовательные программаы",
                                                "url" => ["/constructor/programs/index"],
                                            ],
                                            [
                                                "label" => "Темы",
                                                "url" => ["/constructor/themes/index"],
                                            ],
                                            [
                                                "label" => "Задания к теме",
                                                "url" => ["/constructor/questions/index"],
                                            ],
                                            [
                                                "label" => "Тесты",
                                                "url" => ["/constructor/tests/index"],
                                            ],
                                            [
                                                "label" => "Задания к тестам",
                                                "url" => ["/constructor/tquest/index"],
                                            ],
                                            [
                                                "label" => "Варианты ответов",
                                                "url" => ["/constructor/qvariant/index"],
                                            ],
                                        ],
                                    ],
                                    [
                                        "label" => "Пользователи",
                                        "url" => "#",
                                        'visible' => Yii::$app->user->can('admin'),
                                        "icon" => "users",
                                        "items" => [
                                            ["label" => "Полный список", "url" => ["/user/admin/index"]],
                                            ["label" => "Создать", "url" => ["/user/admin/create"]],
                                            ["label" => "Назначение", "url" => ["/admin"]],
                                            ["label" => "Роли", "url" => ["/admin/role"]],
                                        ],
                                    ],
                                ],
                            ]
                        )
                        ?>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="sidebar-footer hidden-small">
                        <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span>', ['/user/security/logout'], ['data-method' => 'post']) ?>
                    </div>
                <?php } ?>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="http://placehold.it/128x128" alt=""><?= Yii::$app->user->identity->username ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <?= Html::a('Профиль', ['/user/settings/profile']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-sign-out pull-right"></i> Выйти', ['/user/security/logout'], ['data-method' => 'post']) ?>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com" rel="nofollow" target="_blank">Colorlib</a><br/>
                Extension for Yii framework 2 by <a href="http://yiister.ru" rel="nofollow" target="_blank">Yiister</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
