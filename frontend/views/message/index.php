<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\messageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言板首页';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    
    th{
        color:#337ab7;
    }
</style>
<div class="message-index">
    <p>
        <?= Html::a('新建留言', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'contentOptions'=>['style' => 'width: 20px;', 'class' => 'text-center'],
            ],
            [
                'attribute'=>'message',
                'value'=>function($model){// 形参为此行记录对象
                    return mb_strlen($model->message,'utf-8') > 38 ? mb_substr($model->message,0,38,'utf-8')."..." : $model->message;
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
                    return $model->status == 0 ? "待回复" :"已回复";
                },
                'contentOptions' => function($model){
                    return $model->status == 0 ? ['style' => 'color:#333']:['style' => 'color:#5bc0de'];
                },                
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view-btn}&nbsp;&nbsp;&nbsp;&nbsp;{del-btn}',
                'header' => '操作',
                'buttons'=>[
                    'view-btn'=>function($url,$model,$key){
                        return Html::a('详情', ['view', 'id' => $model->id],['class' => 'btn btn-info']);
                    },
                    'del-btn'=>function($url,$model,$key){
                        return Html::a('删除', ['delete', 'id' => $model->id], [
                                                'class' => 'btn btn-danger',
                                                'data'  => [
                                                            'confirm' => '确认删除,删除后不可恢复?',
                                                            'method' => 'post',
                                                        ],
                                                ]);
                    }                    

                ],

            ],
        ],
    ]); ?>


</div>
