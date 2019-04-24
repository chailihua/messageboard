<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\message */

$this->title = '新建留言';
$this->params['breadcrumbs'][] = ['label' => '留言板首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
