<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create') . Yii::t('app', 'User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key',
            // 'token',
            // 'access_token',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'balance',
            //'point',
            //'recommended_by',
            //'recommended_name',
            //'supported_by',
            //'auth_role',
            //'role',
            [
                'attribute' => 'auth_role',
                'value' => function ($model) {
                            return $model->authRole ? $model->authRole->name : '-';
                        },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'auth_role',
                        User::getArrayAuthRole(),
                        ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]
                    )
            ],
            //'status',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($model){
                        if ($model->status === $model::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::STATUS_INACTIVE) {
                            $class = 'lable-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $arrayStatus,
                        ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]
                    )
            ],
            //'created_at',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'Y-M-D H:i:s'],
            ],
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
