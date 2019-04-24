<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .grid-view th{
        color:#337ab7;
    }
</style>
<div class="user-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute'=>'role',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->role == 10 ? "普通用户" : "管理员";
                }
            ],
            [
                'attribute'=>'created_at',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->created_at);
                }
            ],
            [
                'attribute'=>'updated_at',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->updated_at);
                }
            ],
            [
                'label' => '操作',
                'format'=>'raw',
                'value' => function($model){
                    $button = '' ;
                    $showUrl = "?r=user/view&id=".$model->id; //查看详情
                    $button .= Html::a("详情", $showUrl, ['title' => '详情']).'<br>' ;
                    return $button;
                }
            ],
        ],
    ]); ?>
</div>
