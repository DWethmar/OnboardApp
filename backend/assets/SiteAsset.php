<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Assets for the site.
 *
 * @author Dennis Wethmar <dennis@branconline.nl>
 */
class SiteAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/assets/files/';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/site-applications.css',
    ];

}
