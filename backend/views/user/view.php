<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            //'auth_key',
            //'token',
            //'access_token',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'balance',
            //'point',
            //'recommended_by',
            //'recommended_name',
            //'supported_by',
            //'auth_role',
            [
                'attribute' => 'auth_role',
                'value' => $model->authRole ? $model->authRole->name : '-',
            ],
            //'role',
            //'status',
            [
                'attribute' => 'status',
                'value' => $model->statusLabel,
            ],
            //以下这种时间格式，需要在config中配置formatter组件
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
