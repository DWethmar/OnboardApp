<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\application\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-version-form">

    <h2><?= Yii::t('app', 'New Application version from: {old_version}', [
            'old_version' => $old_application_version->version
        ]) ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($old_application_version, 'application_id')?>
    <?= $form->field($new_application_version, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($new_application_version, 'major_version')->textInput(['maxlength' => true]) ?>
    <?= $form->field($new_application_version, 'minor_version')->textInput(['maxlength' => true]) ?>
    <?= $form->field($new_application_version, 'patch_version')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($new_application_version->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $new_application_version->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>