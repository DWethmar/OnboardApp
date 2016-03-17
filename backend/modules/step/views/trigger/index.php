<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\step\TriggerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Triggers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trigger-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // TODO: echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Trigger'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'application_id',
            'name',
            'event',
            'selector',
            'created_at:date',
            'updated_at:date',
            'created_by',
            'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>