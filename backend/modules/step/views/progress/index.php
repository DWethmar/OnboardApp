<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\step\ApplicationIdentityProgressLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Application Identity Progress Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-identity-progress-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // TODO: echo $this->render('_search', ['model' => $search_model]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Application Identity Progress Log'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' =>'identifier', 'value' => 'applicationIdentity.identifier'],
            ['attribute' =>'chain_name', 'value' => 'chain.name'],
            ['attribute' =>'step_name', 'value' => 'step.name'],
            ['attribute' =>'step_sequence', 'value' => 'step.sequence'],
            'state',
            'step.created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>