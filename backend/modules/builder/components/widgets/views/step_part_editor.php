<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div id="step_part_editor_<?= $data['id'] ?>" class="editor step-part-editor">
    <div class="editor-head">
        <span class="glyphicon glyphicon-comment"></span>
        <span class="type"><?= Yii::t('app', 'Step Part') ?>:</span>
        <span class="name"><?= $data['name'] ?></span>
        <div>
            <i><?= $data['selector'] ?></i>
        </div>
    </div>
    <div class="controls">
        <?= Html::a(Yii::t('app', 'Edit'), Url::to([
            '/builder/ajax-step-part/update',
            'id' => $data['id']
        ]), [
            'class' => 'edit-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), Url::to([
            '/builder/ajax-step-part/delete',
            'id' => $data['id']]
        ), [
            'class' => 'delete-x'
        ]) ?>
    </div>
</div>