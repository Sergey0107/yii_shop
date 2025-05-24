<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HomePageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/home-page.css',
    ];

    public $js = [
        'js/catalog.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}