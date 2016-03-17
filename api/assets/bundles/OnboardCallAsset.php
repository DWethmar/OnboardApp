<?php

namespace api\assets\bundles;

use yii\web\AssetBundle;

/**
 * Assets for including the Call script.
 *
 * @author Dennis Wethmar <dennis@branconline.nl>
 */
class OnboardCallAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@api/assets/files/';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/call.example.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
