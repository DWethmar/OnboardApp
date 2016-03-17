<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\Step */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Step',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Steps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="step-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'chains' => $chains,
        'step_types' => $step_types,
    ]) ?>

</div>