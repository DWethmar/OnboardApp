<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\step\ApplicationIdentityProgressLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-identity-progress-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'application_identity_id')->textInput() ?>

    <?= $form->field($model, 'chain_id')->textInput() ?>

    <?= $form->field($model, 'step_id')->textInput() ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>