<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\application\ApplicationIdentitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Application Identities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-identity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //TODO: echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Application Identity'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'Application', 'value' => 'application.name'],
            'name',
            'identifier',
            'email:email',
            'created_at:datetime',
            'updated_at:datetime',
            ['label' => 'Created By', 'value' => 'createdBy.username'],
            ['label' => 'Updated By', 'value' => 'updatedBy.username'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>