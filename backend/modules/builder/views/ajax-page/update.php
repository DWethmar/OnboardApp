<?php

/* @var $this yii\web\View */
/* @var $model common\models\application\Page */
?>
<div class="page-update">
    <h2><?= Yii::t('app', 'Update Page') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>