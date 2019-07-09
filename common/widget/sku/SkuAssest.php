<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/24
 * Time: 17:02
 */

namespace common\widget\sku;


use yii\web\AssetBundle;

class SkuAssest extends AssetBundle
{
    public $sourcePath = '@common/widget/sku/assests';

    public $css = [
        'css/shCore.css',
        'css/shCoreDefault.css',
    ];

    public $js = [
        'js/jquery.min.js',
//        'js/json2.js',
//        'js/shBrushJScript.js',
//        'js/shCore.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}