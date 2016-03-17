<?php

namespace backend\modules\application\controllers;

use backend\modules\application\components\utilities\ApplicationChartUtil;
use backend\modules\application\components\utilities\LogStatisticsUtil;
use Yii;
use common\models\application\Application;
use common\models\application\Page;
use backend\models\application\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatisticsController contains actions related to statistics & charts.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StatisticsController extends Controller {

    /**
     * The duration of steps.
     *
     * @return string the rendered html.
     */
    public function actionIndex() {
        $completed_step_data = ApplicationChartUtil::generateCompletedStepDurationData();
        $unfinished_step_data = ApplicationChartUtil::generateUnfinishedStepDurationData();

        return $this->render('index', [
            'completed_step_data' => $completed_step_data,
            'unfinished_step_data' => $unfinished_step_data
        ]);
    }

    /**
     * Homerun data.
     *
     * @return string The rendered Html.
     */
    public function actionHomerun() {
        $data1 = LogStatisticsUtil::generateChainDurationData('_stats_even', 'green');
        $data2 = LogStatisticsUtil::generateChainDurationData('_stats_oneven', 'red');

        return $this->render('homerun', [
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }

}