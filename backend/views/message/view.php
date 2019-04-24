<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Message */

$this->title = "留言详情";
$this->params['breadcrumbs'][] = ['label' => '留言板首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="message-view">


    <p>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除,删除后不可恢复?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            [
                'attribute'=>'user_name',
                'value'=>$username,
                'contentOptions'=>['style' => 'width:93%;'],            
            ],
            'message',
            [
                'attribute'=>'add_time',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->add_time);
                }
            ],
            [
                'attribute'=>'admin_id',
                'value'=>$adminname,
            ],
            'reply',
            [
                'attribute'=>'reply_time',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->reply_time >0 ? date("Y-m-d H:i:s",$model->reply_time) : "---";
                }
            ],            
        ],
    ]) ?>

</div>
