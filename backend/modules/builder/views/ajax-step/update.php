<?php

/* @var $this yii\web\View */
/* @var $model common\models\step\Step */
?>
<div class="step-update">
    <h2><?= Yii::t('app', 'Update Step') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>