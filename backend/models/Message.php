<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property string $message 留言内容
 * @property string $user_id 用户id
 * @property string $add_time 添加留言时间
 * @property string $admin_id 回复人员id
 * @property string $reply 回复内容
 * @property string $reply_time 回复时间
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'add_time', 'admin_id', 'reply_time'], 'integer'],
            [['message', 'reply'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'message' => '留言内容',
            'user_id' => '用户ID',
            'user_name' => '用户名称',
            'add_time' => '留言时间',
            'admin_id' => '管理员',
            'status' =>"回复状态",
            'reply' => '回复内容',
            'reply_time' => '回复时间',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class,['id'=>'user_id'])->select(['username','email']);
    }
}
