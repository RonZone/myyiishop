<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Auth */

$this->title = 'Create Auth';
$this->params['breadcrumbs'][] = ['label' => 'Auths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
