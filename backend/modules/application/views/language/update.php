<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\application\ApplicationLanguage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Application Language',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="application-language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'applications' => $applications,
    ]) ?>

</div>