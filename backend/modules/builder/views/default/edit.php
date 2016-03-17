<?php


use backend\modules\builder\components\widgets\ApplicationEditor;
use backend\modules\builder\components\widgets\assets\EditorAsset;
use yii\jui\JuiAsset;
use yii\widgets\DetailView;

EditorAsset::register($this);
?>

<div id="base-editor">
    <?= ApplicationEditor::widget(['data' => $data]) ?>
</div>

<div id="_editor_modal"></div>
