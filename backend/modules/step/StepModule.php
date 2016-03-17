<?php

namespace backend\modules\step;

use yii\base\Module;

/*
 * Module for steps.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepModule extends Module {

    /**
     * @var string The namespace where the controllers live.
     */
    public $controllerNamespace = 'backend\modules\step\controllers';

    /**
     * @var string The default action to use.
     */
    public $defaultRoute = 'default';

}