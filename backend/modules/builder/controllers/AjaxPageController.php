<?php

namespace backend\modules\builder\controllers;


use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\widgets\ApplicationEditor;
use backend\modules\builder\components\widgets\PageEditor;
use backend\modules\builder\models\Page;
use common\components\base\controllers\CRUDAjaxController;
use common\models\application\Application;
use common\models\application\ApplicationVersion;
use InvalidArgumentException;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for page.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxPageController extends CRUDAjaxController {

    /** @inheritdoc. */
    public function actionUpdate($id) {
        return parent::actionUpdate($id);
    }

    /** @inheritdoc. */
    public function actionCreate() {
        return parent::actionCreate();
    }

    /** @inheritdoc. */
    public function actionDelete($id) {
        return parent::actionDelete($id);
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
        if (!$model instanceof Page) {
            throw new InvalidArgumentException();
        }

        if ($is_new) { // Render the whole editor
            $application_version = ApplicationVersion::find()->byStringVersion($model->application_id, $model->application_version)->one();
            $data = ApplicationUtil::getApplicationTree($model->application, $application_version);
            return ApplicationEditor::widget(['data' => $data]);
        }

        $data = ApplicationUtil::getPageTree($model);
        return PageEditor::widget(['data' => $data]);
    }

    /**
     * Finds a page by its id.
     *
     * @param integer $id the page id.
     * @return Page The page.
     */
    protected function findModel($id) {
        return Page::find()->where([Page::tableName() . '.id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return Page The new model.
     */
   protected function createModel($attributes = []) {
        $page = new Page($attributes);
        return $page;
    }

}