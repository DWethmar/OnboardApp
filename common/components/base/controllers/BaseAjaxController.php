<?php

namespace common\components\base\controllers;

use common\components\helpers\AjaxHelper;
use Yii;
use yii\db\ActiveRecordInterface;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Base Ajax Controller for application.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
abstract class BaseAjaxController extends Controller {

    /**
     * Make sure all requests to this controller are ajax post requests.
     *
     * @throws BadRequestHttpException When the action is not called via an ajax post request.
     */
    public function beforeAction() {
        if ((!Yii::$app->request->isPost || !Yii::$app->request->isAjax) && !YII_DEBUG) {
            throw new BadRequestHttpException('Illegal request');
        }
        return true;
    }

}
