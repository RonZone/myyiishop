<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Address */

$this->title = Yii::t('app', 'Create') . Yii::t('app', 'Address');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Address'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
