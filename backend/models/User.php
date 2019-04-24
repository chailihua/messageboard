<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id 自增ID
 * @property string $username 用户名
 * @property string $auth_key 自动登录key
 * @property string $password_hash 加密密码
 * @property string $password_reset_token 重置密码token
 * @property string $email 邮箱
 * @property int $role 角色等级
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property string $verification_token verification email token
     verification email token
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'verification_token'], 'required'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱地址',
            'role' => '用户角色',
            'status' => '状态',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
            'verification_token' => 'Verification Token',
        ];
    }
}
