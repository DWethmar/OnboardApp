<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\step\Chain */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Chain',
    ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="chain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pages' => $pages,
        'chains' => $chains,
    ]) ?>

</div>