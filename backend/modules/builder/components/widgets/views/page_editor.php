<?php

use backend\modules\builder\components\widgets\ChainEditor;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="page_editor_<?= $data['id'] ?>" class="editor page-editor">
    <div class="editor-head">
        <span class="glyphicon glyphicon-book"></span>
        <span class="type"><?= Yii::t('app', 'PAGE') ?></span>
        <h3><?= $data['name'] ?></h3>
    </div>
    <div class="controls">
        <?= Html::a(Yii::t('app', 'Edit'), Url::to([
            '/builder/ajax-page/update',
            'id' => $data['id']]),
            ['class' => 'edit-x']
        ) ?>
        <?= Html::a(Yii::t('app', 'Add Chain'), Url::to([
            '/builder/ajax-chain/create',
            'page_id' => $data['id']]),
            ['class' => 'create-x']
        ) ?>
        <?= Html::a(Yii::t('app', 'Delete'), Url::to([
            '/builder/ajax-page/delete',
            'id' => $data['id']]),
            ['class' => 'delete-x']
        ) ?>
    </div>
    <div class="collection chain-collection">
        <?php foreach($data['chains'] as $chain): ?>
            <?= ChainEditor::widget(['data' => $chain])?>
        <?php endforeach; ?>
    </div>
</div>