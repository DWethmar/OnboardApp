<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\application\ApplicationLanguage */

$this->title = Yii::t('app', 'Create Application Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Application Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-language-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'applications' => $applications,
    ]) ?>

</div>