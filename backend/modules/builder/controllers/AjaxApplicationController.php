<?php

namespace backend\modules\builder\controllers;


use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\utilities\VersionUtil;
use backend\modules\builder\components\widgets\ApplicationEditor;
use backend\modules\builder\models\Application;
use common\components\base\controllers\CRUDAjaxController;
use common\components\helpers\AjaxHelper;
use common\models\application\ApplicationVersion;
use InvalidArgumentException;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for application.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxApplicationController extends CRUDAjaxController {

    /** @inheritdoc. */
    public function actionUpdate($id) {
        return parent::actionUpdate($id);
    }

    /**
     * Deletes an existing version.
     *
     * @param integer $id
     * @return string Json with status or redirect.
     */
    public function actionDelete($id) {
        $model =  ApplicationVersion::findOne($id);
        $count_sibling_versions = ApplicationVersion::find()->where([
            'application_id' => $model->application_id
        ])->count();
        if (($count_sibling_versions - 1) >= 1 && $model->delete()) {
            return $this->redirect('/');
        }
        return AjaxHelper::failed(['message' => Yii::t('app', 'Could not delete. Application needs at least 1 version.')]);
    }

    /**
     * Setup a new version.
     *
     * @param integer $id                   The Application id.
     * @param string $application_version   The version.
     *
     * @return string The rendered form or redirect.
     * @throws InvalidArgumentException On wrong version.
     * @throws Exception On save error.
     */
    public function actionSetupVersion($id, $application_version) {
        $application = $this->findModel($id);

        $old_application_version =  ApplicationVersion::find()->byStringVersion($application->id, $application_version)->one();
        if (empty($old_application_version)) {
            throw new InvalidArgumentException('old Version does not exists!');
        }

        $new_application_version = new ApplicationVersion();

        if ($new_application_version->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($new_application_version->save()) {
                    if (VersionUtil::duplicateApplicationVersionData($application, $old_application_version, $new_application_version)) {
                        $transaction->commit();
                        return $this->redirect([
                            '/builder/default/edit',
                            'application_id' => $application->id,
                            'version' => $new_application_version->version,
                        ]);
                    }
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            $new_application_version = new ApplicationVersion($old_application_version->attributes);
            $new_application_version->patch_version++;
            $new_application_version->name = $new_application_version->version;
        }

        return $this->renderPartial('setup', [
            'application' => $application,
            'new_application_version' => $new_application_version,
            'old_application_version' => $old_application_version,
        ]);
    }

    /**
     * The HTML to render when the model has been saved.
     *
     * @param ActiveRecordInterface $model  The successfully saved model.
     * @param boolean               $is_new Set to true if the model is new.
     *
     * @throws InvalidArgumentException On wrong instance.
     * @return string The HTM to return on a successful save.
     */
    protected function renderSave(ActiveRecordInterface $model, $is_new = false) {
        if (!$model instanceof Application) {
            throw new InvalidArgumentException();
        }

        $version = Yii::$app->request->get('version');
        if (empty($version)) {
            throw new InvalidArgumentException('No version in get params');
        }

        $application_version = ApplicationVersion::find()->byStringVersion($model->id, $version)->one();
        $data = ApplicationUtil::getApplicationTree($model, $application_version);
        return ApplicationEditor::widget(['data' => $data]);
    }

    /**
     * Finds a application by its id.
     *
     * @param integer $id the application id.
     * @return Application The application.
     */
    protected function findModel($id) {
        return Application::find()->where(['id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creating a new application is not allowed.
     * @throws InvalidArgumentException On access.
     */
    protected function createModel($attributes = []) {
        throw new InvalidArgumentException();
    }

}
