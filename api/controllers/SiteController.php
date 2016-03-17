<?php

namespace api\controllers;

use yii\base\Controller;
use yii\web\HttpException;

/**
 * Entry controller for the api.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Entry action for site.
     *
     * @throws HttpException
     */
    public function actionIndex() {
        throw new HttpException(404);
    }

}