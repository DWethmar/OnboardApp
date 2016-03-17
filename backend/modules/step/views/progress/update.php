<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\ApplicationIdentityProgressLog */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Application Identity Progress Log',
    ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Identity Progress Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="application-identity-progress-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>