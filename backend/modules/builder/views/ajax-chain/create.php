<?php

/* @var $this yii\web\View */
/* @var $model common\models\step\Chain */
?>
<div class="chain-create">
    <h2><?= Yii::t('app', 'Create Chain') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
        'chains' => $chains,
    ]) ?>
</div>