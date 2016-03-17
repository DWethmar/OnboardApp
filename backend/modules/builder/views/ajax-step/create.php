<?php

/* @var $this yii\web\View */
/* @var $model common\models\step\Step */
?>
<div class="step-create">
    <h2><?= Yii::t('app', 'Add Step') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>