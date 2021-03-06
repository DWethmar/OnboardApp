<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\application\Application */

$this->title = Yii::t('app', 'Create Application');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Applications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tenants' => $tenants,
        'application_languages' => $model->applicationLanguages,
    ]) ?>

</div>