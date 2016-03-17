<?php

use backend\modules\builder\components\widgets\StepPartEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div id="step_editor_<?= $data['id'] ?>" class="editor step-editor" data-key="<?= $data['id'] ?>">
    <div class="editor-head">
        <span class="glyphicon glyphicon-tasks"></span>
        <span class="type"><?= Yii::t('app', 'Step') ?>:</span>
        <span><?= $data['name'] ?></span>
        <span>(<?= $data['sequence'] ?>)</span>
    </div>
    <div class="controls">
        <?= Html::a(Yii::t('app', 'Edit'), Url::to([
            '/builder/ajax-step/update',
            'id' => $data['id']
        ]), [
            'class' => 'edit-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Add Step Part'), Url::to([
            '/builder/ajax-step-part/create',
            'step_id' => $data['id']]
        ), [
            'class' => 'create-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Add Event'), Url::to([
            '/builder/ajax-step-event/create',
            'step_id' => $data['id']]
        ), [
            'class' => 'create-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'View Events'), Url::to([
            '/builder/ajax-step-event/overview',
            'id' => $data['id']]
        ), [
            'class' => 'edit-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), Url::to([
            '/builder/ajax-step/delete',
            'id' => $data['id']]
        ),[
            'class' => 'delete-x'
        ]) ?>

        <?php $form = ActiveForm::begin([
            'action' => Url::to('/step/progress/index'),
            'method' => 'GET',
            'options' => [
                'class' => 'progress-form'
            ]
        ]); ?>

        <?= Html::activeHiddenInput($progress_search_model, 'step_id') ?>

        <?= Html::a(Yii::t('app', 'Progress'), Url::to([
            '#'
        ]), [
            'class' => 'submit-x'
        ]) ?>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="collection step-part-collection">
        <?php foreach($data['step_parts'] as $step_part): ?>
            <?= StepPartEditor::widget(['data' => $step_part])?>
        <?php endforeach; ?>
    </div>
</div>
