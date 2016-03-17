<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\StepType */

$this->title = Yii::t('app', 'Create Step Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>