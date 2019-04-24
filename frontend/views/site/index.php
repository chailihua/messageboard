<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = '首页';
$this->registerCssFile('css/message.css');
?>
<div>
<h2 class="h2title">我的留言</h2>


<?php foreach($list as $k=>$v){ ?>
    <div><?= 
        Html::encode($k)."---".Html::encode($v) 


    ?></div>
<?php } ?>

</div>
