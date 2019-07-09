<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/24
 * Time: 17:02
 */

namespace common\widget\sku;


use yii\web\AssetBundle;

class ProductCategoryAsset extends AssetBundle
{
    public $sourcePath = '@common/widget/productcategory/assets';

    public $css = [
        'css/cate-style.css',
    ];

    public $js = [
        'js/jquery.sort.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}