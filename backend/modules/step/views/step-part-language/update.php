<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPartLanguage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Step Part Language',
    ]) . ' ' . $model->step_part_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Part Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->step_part_id, 'url' => ['view', 'step_part_id' => $model->step_part_id, 'application_language_id' => $model->application_language_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="step-part-language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'step_parts' => $step_parts,
        'application_languages' => $application_languages,
    ]) ?>

</div>