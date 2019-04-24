<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = "留言回复";
$this->params['breadcrumbs'][] = ['label' => '留言板首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '回复';
?>
<div class="message-update">

    <?= $this->render('_form', [
        'model' => $model,
        'username' => $username,
    ]) ?>

</div>
