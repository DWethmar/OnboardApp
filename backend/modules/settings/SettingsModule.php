<?php

namespace backend\modules\settings;

use yii\base\Module;

/**
 * Module for various settings.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class SettingsModule extends Module {

    /**
     * @var string The namespace where the controllers live.
     */
    public $controllerNamespace = 'backend\modules\settings\controllers';

    /**
     * @var string The default action to use.
     */
    public $defaultRoute = 'default';

}