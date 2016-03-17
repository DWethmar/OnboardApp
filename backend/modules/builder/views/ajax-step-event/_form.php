<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\builder\models\StepPart */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="step-part-form-<?= $model->id ?>" class="step-part-form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => $model->isNewRecord ? 'new-record' : 'existing-record',
            'action' => Url::to(['builder/ajax-step-event/create'], true)
        ]
    ]); ?>
    <?= Html::activeHiddenInput($model, 'step_id') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(
        ArrayHelper::map($event_types, 'type', 'type')
    ) ?>

    <?= $form->field($model, 'action')->dropDownList(
        ArrayHelper::map($event_actions, 'action', 'action')
    ) ?>

    <?= $form->field($model, 'selector')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event')->textInput(['maxlength' => true]) ?>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
