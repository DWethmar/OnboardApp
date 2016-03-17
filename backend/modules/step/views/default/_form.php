<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\step\Step */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="step-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chain_id')->dropDownList(
        ArrayHelper::map($chains, 'id', 'name')
    ) ?>

    <?= $form->field($model, 'sequence')->textInput() ?>

    <?= $form->field($model, 'type')->textInput()->dropDownList(
        ArrayHelper::map($step_types, 'type', 'type')
    ) ?>

    <?= $form->field($model, 'highlight')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>