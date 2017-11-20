<?php

namespace backend\models;

use Yii;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $token
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $balance
 * @property int $point
 * @property int $recommended_by
 * @property string $recommended_name
 * @property int $supported_by
 * @property int $auth_role
 * @property string $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Address[] $addresses
 * @property Comment[] $comments
 * @property Consultation[] $consultations
 * @property Favorite[] $favorites
 * @property Order[] $orders
 * @property PointLog[] $pointLogs
 * @property Profile $profile
 * @property UserEmail[] $userEmails
 */
class User extends \common\models\User
{
    
    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['balance'], 'number'],
            [['point', 'recommended_by', 'supported_by', 'auth_role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'access_token', 'password_hash', 'password_reset_token', 'email', 'recommended_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['token', 'role'], 'string', 'max' => 64],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'token' => 'Token',
            'access_token' => 'Access Token',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'balance' => 'Balance',
            'point' => 'Point',
            'recommended_by' => 'Recommended By',
            'recommended_name' => 'Recommended Name',
            'supported_by' => 'Supported By',
            'auth_role' => 'Auth Role',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultations()
    {
        return $this->hasMany(Consultation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPointLogs()
    {
        return $this->hasMany(PointLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmails()
    {
        return $this->hasMany(UserEmail::className(), ['user_id' => 'id']);
    }
}
