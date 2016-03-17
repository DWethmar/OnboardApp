<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\builder\models\StepPart */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="step-part-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => $model->isNewRecord ? 'new-record' : 'existing-record'
        ]
    ]); ?>

    <?= Html::activeHiddenInput($model, 'id')?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'selector')->textInput(['maxlength' => true]) ?>

    <div>
        <?= html::activeLabel($model, 'position') ?>
        <?= Html::activeDropDownList($model, 'position', ArrayHelper::map($positions, 'position', 'full_name')) ?>
        <?= $form->field($model, 'offset_x')->textInput() ?>
        <?= $form->field($model, 'offset_y')->textInput() ?>
    </div>

    <?= $form->field($model, 'show_next_step_controls')->checkbox() ?>
    <?= $form->field($model, 'show_previous_step_controls')->checkbox() ?>
    <?= $form->field($model, 'show_skip_chain_controls')->checkbox() ?>

    <h2><?= Yii::t('app', 'Translation') ?></h2>

    <?= Html::activeHiddenInput($model->stepPartLanguage, 'step_part_id')?>
    <?= Html::activeDropDownList($model->stepPartLanguage, 'application_language_id', ArrayHelper::map($application_languages, 'id', 'name')) ?>
    <?= $form->field($model->stepPartLanguage, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model->stepPartLanguage, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>