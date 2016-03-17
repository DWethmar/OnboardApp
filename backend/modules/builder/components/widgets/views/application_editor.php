<?php

use backend\modules\builder\components\widgets\PageEditor;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="application_editor_<?= $data['id'] ?>" class="editor application-editor">
    <div class="editor-head">
        <span class="glyphicon glyphicon-globe"></span>
        <span class="type"><?= Yii::t('app', 'Application') ?>:</span>
        <h2><?= Html::a($data['name'], Url::to(['/application/default/view', 'id' => $data['id']])) ?> (<?= $version ?>)</h2>
    </div>
    <div class="controls">
        <?= Html::a(Yii::t('app', 'Edit'), Url::to([
            '/builder/ajax-application/update',
            'id' => $data['id'],
            'version' => $version,
            ]),
            ['class' => 'edit-x']
        ) ?>
        <?= Html::a(Yii::t('app', 'Add Page'), Url::to([
            '/builder/ajax-page/create',
            'application_id' => $data['id'],
            'application_version' => $version,
            ]),
            ['class' => 'create-x']
        ) ?>
        <?= Html::a(Yii::t('app', 'Delete Version'), Url::to([
            '/builder/ajax-application/delete',
            'id' => $data['version']['id'],
        ]),
            ['class' => 'delete-x']
        ) ?>
        <?= Html::a(Yii::t('app', 'New Version'), Url::to([
            '/builder/ajax-application/setup-version',
            'id' => $data['id'],
            'application_version' => $version,
        ]),
            ['class' => 'create-x']
        ) ?>
    </div>
    <div class="collection page-collection">
        <?php foreach($data['pages'] as $page): ?>
            <?= PageEditor::widget(['data' => $page])?>
        <?php endforeach; ?>
    </div>
</div>