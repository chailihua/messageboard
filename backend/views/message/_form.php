 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

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
        ],
    ]) ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reply')->textArea(['rows'=>3,'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('回复', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
