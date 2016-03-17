<?php

/* @var $this yii\web\View */
/* @var $model common\models\step\Step */
?>
<div class="step-part-update">
    <h2><?= Yii::t('app', 'Update Step-Events') ?></h2>
    <h4><?= Yii::t('app', 'For {step_name}', ['step_name' => $step->name]) ?></h4>
    <?= $this->render('_form', [
        'model' =>          $model,
        'event_types' =>    $event_types,
        'event_actions' =>  $event_actions,
    ]) ?>
</div>
