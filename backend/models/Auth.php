<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "auth_role".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $operation_list
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            ['name', 'string', 'min' => 3, 'max' => 64],
            ['name', 'validatePermission'],

            ['description', 'string', 'min' => 1, 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
