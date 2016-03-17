<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\application\ApplicationIdentity */

$this->title = Yii::t('app', 'Create Application Identity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Identities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-identity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'applications' => $applications,
    ]) ?>

</div>