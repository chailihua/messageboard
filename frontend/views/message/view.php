<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\message */

$this->title = "详情";
$this->params['breadcrumbs'][] = ['label' => '留言板首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="message-view">

    <p>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'message',
            [
                'attribute'=>'add_time',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->add_time);
                },
                'contentOptions'=>['style' => 'width:87%;'],                
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->reply == "" ? "待回复" :"已回复";
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
