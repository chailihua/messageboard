<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .grid-view th{
        color:#337ab7;
    }
</style>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,      
        'columns' => [
            [
                'attribute'=>'user_id',
                'contentOptions'=>['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute'=>'user_name',
                'value'=>function($model){// 形参为此行记录对象
                    $name = \backend\models\User::find()
                            ->select(["username"])
                            ->andWhere(['id' => $model->user_id])
                            ->one(); 
                    if($name){
                        return $name->username;
                    }else{
                        return "---";
                    }
                },
                'contentOptions'=>['style' => 'width: 80px;', 'class' => 'text-center'],
            ],
            [
                'attribute'=>'message',
                'value'=>function($model){// 形参为此行记录对象
                    return mb_strlen($model->message,'utf-8') > 13 ? mb_substr($model->message,0,13,'utf-8')."..." : $model->message;
                }
            ],            
            [
                'attribute'=>'add_time',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->add_time);
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->status == 0 ? "待回复" : "已回复";
                },
                'contentOptions' => function($model){
                    return $model->status == 0 ? ['style' => 'color:red']:['style' => 'color:green'];
                },
            ],
            [
                'attribute'=>'admin_id',
                'value'=>function($model){// 形参为此行记录对象
                    $name = \backend\models\User::find()
                        ->select(["username"])
                        ->andWhere(['id' => $model->admin_id])
                        ->one(); 
                    if($name){
                        return $name->username;
                    }else{
                        return "---";
                    }
                },
                'contentOptions'=>['style' => 'width: 80px;', 'class' => 'text-center'],
            ],
            [
                'attribute'=>'reply',
                'value'=>function($model){// 形参为此行记录对象
                    return mb_strlen($model->reply,'utf-8') > 13 ? mb_substr($model->reply,0,13,'utf-8')."..." : $model->reply;
                }
            ],            
            [
                'attribute'=>'reply_time',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->reply_time >0 ? date("Y-m-d H:i:s",$model->reply_time) : "---";
                }
            ],            
            [
                'label' => '操作',
                'format'=>'raw',
                'value' => function($model){
                    $button = '' ;
                    $showUrl = "?r=message/".($model->status == 0 ? "update" : "view")."&id=".$model->id; //查看详情
                    $button .= Html::a($model->status == 0 ? '回复' : "详情", $showUrl, ['title' => '详情']).'<br>' ;
                    return $button;
                }
            ],

        ],
    ]); ?>


</div>
