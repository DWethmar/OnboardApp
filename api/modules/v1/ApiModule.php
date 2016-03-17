<?php

namespace api\modules\v1;

use yii\base\Module;

/**
 * Module for api v1.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApiModule extends Module {

    /**
     * @var string The namespace where the controllers live.
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @var string The default action to use.
     */
    public $defaultRoute = 'data';

}