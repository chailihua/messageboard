<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
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
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'role')->radioList(['10'=>'普通用户','11'=>'管理员']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
