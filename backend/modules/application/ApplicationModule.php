<?php

namespace backend\modules\application;

use yii\base\Module;

class ApplicationModule extends Module {

    /**
     * @var string The namespace where the controllers live.
     */
    public $controllerNamespace = 'backend\modules\application\controllers';

    /**
     * @var string The default action to use.
     */
    public $defaultRoute = 'default';

}