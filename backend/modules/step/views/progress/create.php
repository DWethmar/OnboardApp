<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\step\ApplicationIdentityProgressLog */

$this->title = Yii::t('app', 'Create Application Identity Progress Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Identity Progress Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-identity-progress-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>