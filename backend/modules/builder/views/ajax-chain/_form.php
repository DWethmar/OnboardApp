<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\step\Chain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'page_id') ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'next_chain_id')->dropDownList(
        ArrayHelper::map($chains, 'id', 'name'),
        [
            'prompt' => Yii::t('app', '--SELECT NEXT CHAIN--')
        ]
    ) ?>

    <?= $form->field($model, 'min_window_width') ?>
    <?= $form->field($model, 'max_window_width') ?>
    <?= $form->field($model, 'min_window_height') ?>
    <?= $form->field($model, 'max_window_height') ?>

    <?= $form->field($model, 'continue_on_completion')->checkbox() ?>

    <?= $model->isNewRecord ? $form->field($model, 'create_step')->checkbox() : '' ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>