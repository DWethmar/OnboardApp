<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\application\ChainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Chains');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chain-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // TODO: echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Chain'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Page', 'value' => 'page.name'],
            'next_chain_id',
            'name',
            'created_at:datetime',
            'updated_at:datetime',
            ['label' => 'Created by', 'value' => 'createdBy.username'],
            ['label' => 'Updated by', 'value' => 'createdBy.username'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>