<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $brief
 * @property int $is_nav
 * @property string $banner
 * @property string $keywords
 * @property string $description
 * @property string $redirect_url
 * @property int $sort_order
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * create_time,update_time to now()
     * create_user_id, update_user_id to current login user id
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_nav', 'sort_order', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['brief', 'banner', 'keywords', 'redirect_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'brief' => Yii::t('app', 'Brief'),
            'is_nav' => Yii::t('app', 'Is Nav'),
            'banner' => Yii::t('app', 'Banner'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'redirect_url' => Yii::t('app', 'Redirect Url'),
            'sort_order' => Yii::t('app', 'Sort Order'),
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
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     *  Get all catelog order by parent/child with the space befor child label
     *  Usage: ArrayHelper::map(Catalog::get(0, Catalog::find()->asArray()->all()), 'id', 'label')
     *  @param int $parentId parent catalog id
     *  @param array $array catalog array list
     *  @param int $level catalog level, will affect $repeat
     *  @param int $add times of $repeat
     *  @param string $repwat symbols or spaces to be assed for sub catalog   空格是全角空格！
     *  @return array catalog collections
     */
    static public function get($parentId = 0, $array = [], $level = 0, $add = 2, $repeat = '　')
    {
        $strRepeat = '';
        //为非顶级类别添加一些空格或符号 0是顶级
        if ($level > 1) {
            for ($j=0; $j < $level; $j++) { 
                $strRepeat .= $repeat;
            }
        }

        $newArray = array();

        foreach ((array)$array  as $v) {
            if ($v['parent_id'] == $parentId) {
                $item = (array)$v;
                $item['label'] = $strRepeat . (isset($v['title']) ? $v['title'] : $v['name']);
                $newArray[] = $item;

                $tempArray = self::get($v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray) {
                    $newArray = array_merge($newArray, $tempArray);
                }
            }
        }

        return $newArray;
    }



}
