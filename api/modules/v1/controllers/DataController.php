<?php

namespace api\modules\v1\controllers;

use api\modules\v1\components\facade\OnboardManager;
use api\modules\v1\components\utilities\ApiDataUtil;
use common\models\application\Application;
use common\models\application\ApplicationVersion;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Data controller.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class DataController extends Controller {

    /**
     * @inheritdoc.
     */
    public $defaultAction = 'get';

    /**
     * @inheritdoc.
     */
    public function init() {
        parent::init();
        Yii::$app->user->enableSession = false;

        $request = Yii::$app->request;
        if (!$request->isAjax && !YII_DEBUG) {
            throw new NotFoundHttpException('Send ajax request please');
        }
    }

    /**
     * @inheritdoc.
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }

    /**
     * Get the JSONP data for a user.
     *
     * @param string $callback  The JSONP callback.
     * @param string $url       The encoded url.
     * @param string $uid       The user identifier.
     * @param string $lang      The language for the translations.
     * @param string $version   The Application version.
     *
     * @return string Return data as JSONP.
     */
    public function actionSteps($callback, $url, $uid, $lang, $version = null) {
        $application = Yii::$app->user->identity;
        $application_version = $this->_getApplicationVersion($application, $version);
        if (null === $application_version) {
            return 'invalid version!';
        }
        $data = ApiDataUtil::getOnboardData(urldecode($url), $application, $application_version, $uid, $lang);
        return $callback . '('. json_encode($data) . ');';
    }

    /**
     * Saves the progress of a user.
     *
     * @param string    $callback   The JSONP callback.
     * @param int       $step_code  The Step common code.
     * @param string    $uid        The user identifier.
     * @param boolean   $finish     Should this action finish the chain.
     * @param boolean   $skip       Should this action skip the chain.
     * @param string    $version    The Application version.
     *
     * @return string Return data as JSONP.
     */
    public function actionSave($callback, $step_code, $uid, $finish, $skip, $version = null) {
        $success = false;
        $application = Yii::$app->user->identity;

        $application_version = $this->_getApplicationVersion($application, $version);
        if (null === $application_version || ($application->id != $application_version->application_id)) {
            return 'invalid version';
        }

        $step = OnboardManager::getStep($application, $application_version, $step_code)->one();
        if ($step !== null) {
            $success = OnboardManager::saveProgress($application, $application_version, $step, $uid, $finish === 'true', $skip === 'true');
        }
        return $callback . '('. json_encode([
            'success' => $success,
            'finish' => $finish,
            'skipped' => $skip,
        ]) . ');';
    }

    /**
     * Get version by string.
     *
     * @param Application $application
     * @param string $version
     * @return ApplicationVersion The version to use.
     */
    private function _getApplicationVersion(Application $application, $version) {
        $application_version = null;
        if ($version === '*') { // Get highest version
            $application_version = ApplicationVersion::find()
                 ->where([
                'id' => ApplicationVersion::find()
                    ->select('id')
                    ->where([
                        'application_id' => $application->id
                    ])
                    ->orderBy('major_version DESC, minor_version DESC, patch_version DESC')
                    ->limit(1)
            ])->one();
        } else {
            $application_version = ApplicationVersion::find()->byStringVersion($application->id, $version)->one();
        }
        return $application_version;
    }

}
