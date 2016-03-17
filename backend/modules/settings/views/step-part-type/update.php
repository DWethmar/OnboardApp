<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPartType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Step Part Type',
    ]) . ' ' . $model->type;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Part Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type, 'url' => ['view', 'id' => $model->type]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="step-part-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>