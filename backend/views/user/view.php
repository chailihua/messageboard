<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = "用户详情";
$this->params['breadcrumbs'][] = ['label' => '用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
