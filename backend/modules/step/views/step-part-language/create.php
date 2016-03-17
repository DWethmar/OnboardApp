<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\StepPartLanguage */

$this->title = Yii::t('app', 'Create Step Part Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Part Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-part-language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'step_parts' => $step_parts,
        'application_languages' => $application_languages,
    ]) ?>

</div>