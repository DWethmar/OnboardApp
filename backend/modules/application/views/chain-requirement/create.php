<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\application\ChainRequirement */

$this->title = Yii::t('app', 'Create Chain Requirement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chain Requirements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chain-requirement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>