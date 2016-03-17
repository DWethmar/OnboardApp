<?php

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPart */
?>
<div class="step-part-create">
    <h2><?= Yii::t('app', 'Add Step-Part') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
        'application_languages' => $application_languages,
        'positions' => $positions,
    ]) ?>
</div>