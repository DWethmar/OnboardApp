<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\application\ApplicationIdentity */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Application Identity',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Identities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="application-identity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'applications' => $applications,
    ]) ?>

</div>