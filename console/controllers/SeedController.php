<?php

namespace console\controllers;

use common\models\Tenant;
use console\components\seed\PositionSeeder;
use console\components\seed\StepEventSeeder;
use console\components\seed\UserSeeder;
use frontend\models\SignupForm;
use yii\console\Controller;

/**
 * Seed system.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class SeedController extends Controller {

    /**
     * Create system tenant and user.
     *
     * @return int Status code.
     */
    public function actionGo() {
        UserSeeder::go();
        PositionSeeder::go();
        StepEventSeeder::go();
        return 0;
    }

}