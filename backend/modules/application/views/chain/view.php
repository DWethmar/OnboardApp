<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\step\Chain */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chain-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'next_chain_id',
            'name',
            'created_at:datetime',
            'updated_at:datetime',
            ['label' => 'Created By', 'value' => $model->createdBy->username],
            ['label' => 'Updated By', 'value' => $model->updatedBy->username],
        ],
    ]) ?>

</div>