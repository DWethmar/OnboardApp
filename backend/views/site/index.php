<?php

/* @var $this yii\web\View */

use backend\assets\SiteAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Menu;

SiteAsset::register($this);

$this->title = Yii::t('app', 'Dashboard');
?>
<div class="site-index">
    <div class="applications">
    <?php if (count($applications)): ?>
        <h2><?= Yii::t('app', 'My Applications') ?></h2>

        <?php foreach($applications as $application): ?>
            <div class="application">

                <span><?= $application->name ?></span>
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['/builder/default/edit', 'application_id' => $application->id]),
                    'method' => 'GET',
                    'options' => [
                        'class' => 'progress-form'
                    ]
                ]); ?>
                <div>
                    <?= Html::dropDownList('version', null,  ArrayHelper::map($application->applicationVersions, function($array, $defaultValue) {
                        return $array['major_version'] . '.' . $array['minor_version'] . '.' .  $array['patch_version'];
                    }, function($array, $defaultValue) {
                        return $array['major_version'] . '.' . $array['minor_version'] . '.' .  $array['patch_version'];
                    }))?>
                </div>
                <div>
                    <?= Html::submitButton()?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p><?= Yii::t('app', 'You don\'t have any applications yet.') ?></p>
        <?= Html::a(Yii::t('app', 'Create your application here'), Url::to([
            '/application/default/create'
        ])) ?>
    <?php endif; ?>
    </div>

    <hr />

    <?= Menu::widget([
        'items' => [
            ['label' => 'Applications', 'url' => ['application/default/index'], 'items' => [
                ['label' => 'Create', 'url' => ['application/default/create']],
                ['label' => 'Identity', 'url' => ['application/identity/index',], 'items' => [
                    ['label' => 'Create', 'url' => ['application/identity/create']],
                    ['label' => 'Progress', 'url' => ['step/progress/index']],
                ]],
                ['label' => 'Languages', 'url' => ['application/language/index',], 'items' => [
                    ['label' => 'Create', 'url' => ['application/language/create']],
                ]],
            ]],
            ['label' => 'settings', 'url' => ['/settings'], 'items' => [
                ['label' => 'Step type', 'url' => ['settings/step-type/index']],
                ['label' => 'Step part type', 'url' => ['settings/step-part-type/index']],
            ]],
        ],
    ]); ?>

</div>
