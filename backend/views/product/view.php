<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => $model->category ? $model->category->name : '-',
            ],
            'name',
            'sku',
            'stock',
            'weight',
            'market_price',
            'price',
            'brief',
            'content:ntext',
            'thumb',
            'image',
            //'origin',
            'keywords',
            'description:ntext',
            [
                'attribute' => 'type',
                'value' => \common\models\ProductType::labels($model->type),
            ],
            [
                'attribute' => 'brand_id',
                'value' => $model->brand ? $model->brand->name : '-',
            ],
            [
                'attribute' => 'status',
                'value' => \common\models\Status::labels($model->status),
            ],
            //'star',
            //'sales',
            //'status',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy->username,
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy->username,
            ],
        ],
    ]) ?>

</div>
