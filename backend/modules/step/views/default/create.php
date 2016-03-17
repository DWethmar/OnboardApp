<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\Step */

$this->title = Yii::t('app', 'Create Step');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Steps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'chains' => $chains,
        'step_types' => $step_types,
    ]) ?>

</div>