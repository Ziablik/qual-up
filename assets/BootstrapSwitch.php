<?php


namespace app\assets;


use yii\web\AssetBundle;

class BootstrapSwitch extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-switch/dist';
    public $css = [
        'css/bootstrap3/bootstrap-switch.css',
    ];
    public $js = [
        'js/bootstrap-switch.js',
    ];
}