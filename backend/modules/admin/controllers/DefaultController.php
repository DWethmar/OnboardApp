<?php

namespace backend\modules\admin\controllers;

use backend\modules\admin\components\base\BaseAdminController;

/**
 * Entry controller for module.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class DefaultController extends BaseAdminController {

    /**
     * Render and returns the index html page with the render function.
     *
     * @return string The rendered html.
     */
    public function actionIndex() {
        return $this->render('index');
    }

}