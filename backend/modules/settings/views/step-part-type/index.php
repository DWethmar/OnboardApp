<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\step\StepPartTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Step Part Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-part-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $search_model]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Step Part Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $data_provider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->type), ['view', 'id' => $model->type]);
        },
    ]) ?>

</div>