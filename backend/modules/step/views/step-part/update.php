<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPart */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Step Part',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="step-part-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'steps' => $steps,
        'step_part_types' => $step_part_types,
    ]) ?>

</div>