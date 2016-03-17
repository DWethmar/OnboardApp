<?php

namespace common\components\base\controllers;

use common\components\helpers\AjaxHelper;
use Yii;
use yii\db\ActiveRecordInterface;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Base Ajax Controller for generic CRUD operations.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
abstract class CRUDAjaxController extends BaseAjaxController {

    /** @return string The Update view path. */
    protected function getUpdateViewPath() { return 'update'; }

    /** @return string The Create view path. */
    protected function getCreateViewPath() { return 'create'; }

    /**
     * A hook after the save of a model.
     *
     * @param ActiveRecordInterface $model  The successfully saved model.
     * @param boolean               $is_new Set to true if the model is new.
     *
     * @return void
     */
    protected function afterSave(ActiveRecordInterface $model, $is_new = false) {}

    /**
     * Generic after delete logic.
     *
     * @param ActiveRecordInterface $model The successfully deleted model.
     * @return void
     */
    protected function afterDelete(ActiveRecordInterface $model) {}

    /**
     * The HTML to render when the model has been saved.
     *
     * @param ActiveRecordInterface $model  The successfully saved model.
     * @param boolean               $is_new Set to true if the model is new.
     *
     * @return string The HTM to return on a successful save.
     */
    abstract protected function renderSave(ActiveRecordInterface $model, $is_new = false);

    /**
     * Pass additional key => value params to the view.
     *
     * @param ActiveRecordInterface $model The model to be passed to the view..
     * @param boolean               $is_new Set to true if the model is new.
     *
     * @return array The additional params.
     */
    protected function getAdditionalSaveViewParams(ActiveRecordInterface $model, $is_new = false) { return []; }

    /**
     * Get Update form for a model trough ajax.
     *
     * Implement by overriding this function.
     *
     * @param integer $id the application id.
     * @return array all key-value pairs.
     */
    protected function actionUpdate($id) {
        $model = static::findModel($id);

        if (empty($model)) {
            return AjaxHelper::failed(['id' => $id]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterSave($model, false);
            return AjaxHelper::success([
                'html' => $this->renderSave($model, false)
            ]);
        }

        return AjaxHelper::render($this->renderPartial($this->getUpdateViewPath(), array_merge([
                'model' => $model
            ],
            $this->getAdditionalSaveViewParams($model)
        )));
    }

    /**
     * Get Create form for a model trough ajax.
     *
     * Load the model with params from GET.
     * Implement by overriding this function.
     *
     * @return array all key-value pairs.
     */
    protected function actionCreate() {
        $model = $this->createModel(Yii::$app->request->get());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->afterSave($model, true);
            return AjaxHelper::success([
                'html' => $this->renderSave($model, true)
            ]);
        }
        return AjaxHelper::render($this->renderPartial($this->getCreateViewPath(), array_merge([
                'model' => $model
            ],
            $this->getAdditionalSaveViewParams($model)
        )));
    }

    /**
     * Deletes an existing model.
     *
     * If delete is success then return status: success.
     * Check the function findModel of implementing controllers
     * of this class for logic concerning access violations.
     *
     * Implement by overriding this function.
     *
     * @param integer $id
     * @return array all key-value pairs.
     */
    protected function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->delete()) {
            $this->afterDelete($model);
            return AjaxHelper::success();
        }
        return AjaxHelper::failed();
    }

    /**
     * Find a model by its id.
     *
     * @param integer $id the model id.
     * @return ActiveRecord The model to find.
     */
    abstract protected function findModel($id);

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return ActiveRecord The new model.
     */
    abstract protected function createModel($attributes = []);

}
