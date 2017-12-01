<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property int $id
 * @property int $product_id
 * @property string $filename
 * @property string $description
 * @property string $image
 * @property string $thumb
 * @property string $origin
 * @property int $sort_order
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'sort_order'], 'integer'],
            [['filename'], 'string', 'max' => 128],
            [['description', 'image', 'thumb', 'origin'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'filename' => Yii::t('app', 'Filename'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'thumb' => Yii::t('app', 'Thumb'),
            'origin' => Yii::t('app', 'Origin'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
