<?php
/**
 * Common status Class
 * User: ron
 * date: 2017/11/24
 * Time: 14:20
 */
 
namespace common\models;

use Yii;

class YesNo
{
    const NO = 0;
    const YES = 1;

    public $id;
    public $label;

    public function __construct($id = null)
    {
        if ($id !== null) {
            $this->id = $id;
            $this->label = $this->getLabel($id);
        }
    }

    public static function labels($id = null)
    {
        $data = [
            self::YES => Yii::t('app', 'YES'),
            self::NO => Yii::t('app', 'NO'),
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public function getLabel($id)
    {
        $labels = self::labels();
        return isset($labels[$id]) ? $labels[$id] : null;
    }
}