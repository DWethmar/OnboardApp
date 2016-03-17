<?php

namespace backend\modules\settings\controllers;

use yii\web\Controller;

/**
 * Entry controller for module.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class DefaultController extends Controller {

    /**
     * Render and returns the index html page with the render function.
     *
     * @return string The rendered html.
     */
    public function actionIndex() {
        return $this->render('index');
    }

}