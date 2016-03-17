<?php
/* @var $this yii\web\View */
/* @var $model common\models\application\Application */
?>
<div class="application-update">
    <h2><?= Yii::t('app', 'Update Application') ?></h2>
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>