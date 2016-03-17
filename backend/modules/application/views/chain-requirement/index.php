<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\application\ChainRequirementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Chain Requirements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chain-requirement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //TODO echo $this->render('_search', ['model' => $search_model]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Chain Requirement'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'parent_chain_id',
            'child_chain_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>