<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\application\Page */
?>
<div class="page-create">
    <h2><?= Yii::t('app', 'Add Page') ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>