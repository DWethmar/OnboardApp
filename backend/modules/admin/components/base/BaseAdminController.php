<?php

namespace backend\modules\admin\components\base;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Base controller for the admin module.
 *
 * @author Dennnis Wethmar <dennis@branchonline.nl>
 */
class BaseAdminController extends Controller {

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ], [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ]
            ],
        ];
    }

}