<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $sku
 * @property int $stock
 * @property string $weight
 * @property string $market_price
 * @property string $price
 * @property string $brief
 * @property string $content
 * @property string $thumb
 * @property string $image
 * @property string $origin
 * @property string $keywords
 * @property string $description
 * @property int $type
 * @property int $brand_id
 * @property string $star
 * @property int $sales
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Comment[] $comments
 * @property Consultation[] $consultations
 * @property Favorite[] $favorites
 * @property OrderProduct[] $orderProducts
 * @property Category $category
 * @property ProductImage[] $productImages
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * create_time, update_time to now()
     * crate_user_id, update_user_id to current login user id
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'sku'], 'required'],
            [['category_id', 'stock', 'type', 'brand_id', 'sales', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['weight', 'market_price', 'price', 'star'], 'number'],
            [['content', 'description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['sku'], 'string', 'max' => 64],
            [['brief', 'thumb', 'image', 'origin', 'keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'sku' => Yii::t('app', 'Sku'),
            'stock' => Yii::t('app', 'Stock'),
            'weight' => Yii::t('app', 'Weight'),
            'market_price' => Yii::t('app', 'Market Price'),
            'price' => Yii::t('app', 'Price'),
            'brief' => Yii::t('app', 'Brief'),
            'content' => Yii::t('app', 'Content'),
            'thumb' => Yii::t('app', 'Thumb'),
            'image' => Yii::t('app', 'Image'),
            'origin' => Yii::t('app', 'Origin'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'brand_id' => Yii::t('app', 'Brand ID'),
            'star' => Yii::t('app', 'Star'),
            'sales' => Yii::t('app', 'Sales'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultations()
    {
        return $this->hasMany(Consultation::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }


}
