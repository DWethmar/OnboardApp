<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\StepPart */

$this->title = Yii::t('app', 'Create Step Part');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-part-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'steps' => $steps,
        'step_part_types' => $step_part_types,
    ]) ?>

</div>