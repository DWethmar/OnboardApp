<?php

namespace backend\modules\admin;

use yii\base\Module;

/**
 * Module for admin controls.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AdminModule extends Module {

    /**
     * @var string The namespace where the controllers live.
     */
    public $controllerNamespace = 'backend\modules\admin\controllers';

    /**
     * @var string The default action to use.
     */
    public $defaultRoute = 'default';

}