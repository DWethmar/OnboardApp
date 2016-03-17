<?php

namespace backend\modules\builder\components\widgets\assets;

use yii\web\AssetBundle;

/**
 * Assets for the editor.
 *
 * @author Dennis Wethmar <dennis@branconline.nl>
 */
class EditorAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/builder/components/widgets/assets/files/';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/editor.js',
        'js/editor.step-sort.js',
        'js/editor.step-events.js',
        'js/editor.step-toggle-display.js'
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/editor-style.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'common\assets\bower\RemodalAsset',
        'yii\jui\JuiAsset',
    ];
}
