<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPart */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="step-part-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'step_id')->dropDownList(
        ArrayHelper::map($steps, 'id', 'name')
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(
        ArrayHelper::map($step_part_types, 'type', 'type')
    ) ?>

    <?= $form->field($model, 'selector')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>