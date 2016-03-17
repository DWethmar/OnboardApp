<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\step\StepPartLanguage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="step-part-language-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'step_part_id')->dropDownList(
        ArrayHelper::map($step_parts, 'id', 'name')
    ) ?>

    <?= $form->field($model, 'application_language_id')->dropDownList(
        ArrayHelper::map($application_languages, 'id', 'name')
    ) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>