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
            'id',
            'message',
            [
                'attribute'=>'add_time',
                'value'=>function($model){// 形参为此行记录对象
                    return date("Y-m-d H:i:s",$model->add_time);
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function($model){// 形参为此行记录对象
                    return $model->reply == "" ? "待回复" :"已回复";
                }
            ],
            // 'admin_id',
            //'reply',
            //'reply_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
