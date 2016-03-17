<?php

use backend\modules\builder\components\widgets\StepEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div id="chain_editor_<?=$data['id'] ?>" class="editor chain-editor" data-key="<?=$data['id'] ?>">
    <div class="editor-head">
        <div>
            <span class="glyphicon glyphicon-link"></span>
            <span class="type"><?= Yii::t('app', 'Chain') ?></span>
            <h4 class="name"><?= $data['name'] ?></h4>
        </div>

        <div class="chain-flow">
            <?php if (empty($data['previous_chains'])): ?>
                <span class="glyphicon glyphicon-book"></span>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <span class="name"><b><?= $data['name'] ?></b></span>
                <?php if(isset($data['next_chain']['name'])): ?>
                <span class="glyphicon glyphicon-arrow-right"></span>
                <span class="next-chain">
                    <?= Html::a(
                        $data['next_chain']['name'],
                        '#chain_editor_' . $data['next_chain']['id']
                    ) ?>
                </span>
                <?php endif; ?>
            <?php else: ?>
                <table class="previous-chains">
                    <?php foreach($data['previous_chains'] as $previous_chain): ?>
                        <tr>
                            <td>
                                <span class="glyphicon glyphicon-link"></span>
                                <span class="glyphicon glyphicon-arrow-right"></span>
                                <?= Html::a(
                                    $previous_chain['name'],
                                    '#chain_editor_' . $previous_chain['id'], [
                                        'class' => 'chain-link',
                                        'data-key' => $previous_chain['id'],
                                    ]
                                ) ?>
                            </td>
                            <td>
                                <span class="glyphicon glyphicon-arrow-right"></span>
                                <span class="name"><b><?= $data['name'] ?></b></span>
                            </td>
                            <td>
                                <?php if(isset($data['next_chain']['name'])): ?>
                                    <span class="glyphicon glyphicon-arrow-right"></span>
                                    <span class="next-chain">
                                        <?= Html::a(
                                            $data['next_chain']['name'],
                                            '#chain_editor_' . $data['next_chain']['id'], [
                                                'class' => 'chain-link',
                                                'data-key' => $data['next_chain']['id'],
                                            ]
                                        ) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php endif; ?>

        </div>

    </div>
    <div class="controls">
        <?= Html::a(Yii::t('app', 'Edit'), Url::to([
            '/builder/ajax-chain/update',
            'id' => $data['id']
        ]), [
            'class' => 'edit-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Add Step'), Url::to([
            '/builder/ajax-step/create',
            'chain_id' => $data['id']
        ]), [
            'class' => 'create-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Save Sequence'), Url::to([
            '#'
        ]), [
            'class' => 'save-sequence-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Show Steps'), Url::to([
            '#'
        ]), [
            'class' => 'toggle-x'
        ]) ?>
        <?= Html::a(Yii::t('app', 'Delete'), Url::to([
            '/builder/ajax-chain/delete',
            'id' => $data['id']
        ]), [
            'class' => 'delete-x'
        ]) ?>

        <?php $form = ActiveForm::begin([
            'action' => Url::to('/step/progress/index'),
            'method' => 'GET',
            'options' => [
                'class' => 'progress-form'
            ]
        ]); ?>

            <?= Html::activeHiddenInput($progress_search_model, 'chain_id') ?>

            <?= Html::a(Yii::t('app', 'Progress'), Url::to([
                '#'
            ]), [
                'class' => 'submit-x'
            ]) ?>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="collection step-collection">
        <?php foreach($data['steps'] as $step): ?>
            <?= StepEditor::widget(['data' => $step])?>
        <?php endforeach; ?>
    </div>
</div>