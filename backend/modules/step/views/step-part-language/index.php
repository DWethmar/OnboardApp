<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\step\StepPartLanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Step Part Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-part-language-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // TODO: echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Step Part Language'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'step_part_id',
            'application_language_id',
            'value:ntext',
            'created_at:date',
            'updated_at:date',
            ['label' => 'Created by', 'value' => 'createdBy.username'],
            ['label' => 'Updated by', 'value' => 'createdBy.username'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>