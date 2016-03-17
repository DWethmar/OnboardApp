<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\application\ChainRequirement */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Chain Requirement',
    ]) . ' ' . $model->parent_chain_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chain Requirements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent_chain_id, 'url' => ['view', 'parent_chain_id' => $model->parent_chain_id, 'child_chain_id' => $model->child_chain_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="chain-requirement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>