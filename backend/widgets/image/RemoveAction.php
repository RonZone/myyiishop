<?php

namespace backend\widgets\image;

use Yii;
use common\models\ProductImage;
use yii\base\Action;

class RemoveAction extends Action
{
    public $uploadDir = '@webroot/upload';

    public function run($id)
    {
        $iamge = ProductImage::findOne(['id' => $id]);
        if ($image) {
            $filename = $iamge->filename;
            if (ProductImage::deleteAll(['id' => $id])) {
                if (unlink(\Yii::getAlias($this->uploadDir . '/' . $filename))) {
                    if (unlink(\Yii::getAlias($this->uploadDir . '/small-' . $filename))) {
                        Yii::$app->response->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        }

        return false;
    }
}