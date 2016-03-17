<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\application\Application */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Application',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="application-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tenants' => $tenants,
        'application_languages' => $model->applicationLanguages,
    ]) ?>

</div>