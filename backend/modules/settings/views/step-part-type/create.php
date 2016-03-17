<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\StepPartType */

$this->title = Yii::t('app', 'Create Step Part Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Step Part Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-part-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>