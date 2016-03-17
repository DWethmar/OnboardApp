<?php
namespace common\assets\bower;

use yii\web\AssetBundle;

/**
 * Assets for RemodalAsset.
 *
 * @see https://github.com/VodkaBears/Remodal
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class RemodalAsset extends AssetBundle {

    /** @inheritdoc */
    public $sourcePath = '@bower/remodal';

    /** @inheritdoc */
    public $js = [
        'dist/remodal.min.js',
    ];

    /** @inheritdoc */
    public $css = [
        'dist/remodal.css',
        'dist/remodal-default-theme.css',
    ];

    /** @inheritdoc */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}