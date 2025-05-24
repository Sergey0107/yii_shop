<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CatalogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/catalog.css',
    ];

    public $js = [
        'js/catalog.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}