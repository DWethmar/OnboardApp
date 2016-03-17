<?php

namespace backend\modules\builder\controllers;

use backend\modules\builder\components\utilities\ApplicationUtil;
use common\models\application\Application;
use common\models\application\ApplicationVersion;
use Psr\Log\InvalidArgumentException;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * The Default controller for the builder module.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class DefaultController extends Controller {

    /**
     * Render a edit view  to build a application.
     *
     * @param integer $application_id   The id of a application.
     * @param string  $version          The application version as string.
     *
     * @throws NotFoundHttpException if application is not found or access is valid.
     * @return string The rendered HTML.
     */
    public function actionEdit($application_id, $version) {

        $application_version = ApplicationVersion::find()->byStringVersion($application_id, $version)->one();

        if (empty($application_version)) {
            throw new NotFoundHttpException('Application version not found.');
        }

        $application = Application::find()
            ->where(['id' => $application_id])
            ->checkAccess(Yii::$app->user->id)
            ->with(['pages' => function ($query) use($application_version) {
                $query->andWhere(['application_version_id' => $application_version->id]);
            }])
            ->one();

        if (empty($application)) {
            throw new NotFoundHttpException('Application not found.');
        }

        return $this->render('edit', [
            'model' => $application,
            'data' => ApplicationUtil::getApplicationTree($application, $application_version),
        ]);
    }

}