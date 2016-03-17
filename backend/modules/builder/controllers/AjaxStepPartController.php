<?php

namespace backend\modules\builder\controllers;

use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\widgets\StepEditor;
use backend\modules\builder\components\widgets\StepPartEditor;
use backend\modules\builder\models\Application;
use backend\modules\builder\models\StepPart;
use common\components\base\controllers\CRUDAjaxController;
use common\components\helpers\AjaxHelper;
use common\models\application\ApplicationLanguage;
use common\models\application\Chain;
use common\models\step\StepPartPosition;
use common\models\step\StepPartType;
use InvalidArgumentException;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for Step Part.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxStepPartController extends CRUDAjaxController {

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
     *
     * @param integer $id the step part id.
     * @param integer $language_id The application language id.
     *
     * @return Array The translation data in array: [success => x, language_id => x, value=> x]
     */
    public function actionGetTranslation($id, $language_id) {
        $step_part = StepPart::find()->checkAccess(Yii::$app->user->id)->where([
            StepPart::tableName() . '.id' => $id,
        ])->one();

        if (!empty($step_part)) {
            $step_part_language = $step_part->getStepPartLanguages()->where([
                'application_language_id' => $language_id
            ])->one();

            if (empty($step_part_language)) { // return empty value.
                return AjaxHelper::success([
                    'language_id' => $language_id,
                    'value' => '',
                ]);
            } else {
                return AjaxHelper::success([ // return existing value.
                    'language_id' => $step_part_language->application_language_id,
                    'title' => $step_part_language->title,
                    'value' => $step_part_language->value,
                ]);
            }
        }
        return AjaxHelper::failed();
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
        if (!$model instanceof StepPart) {
            throw new InvalidArgumentException();
        }

        if ($is_new) { // Render Chain
            $data = ApplicationUtil::getStepTree($model->step);
            return StepEditor::widget(['data' => $data]);
        }

        $data = ApplicationUtil::getStepPartTree($model);
        return StepPartEditor::widget(['data' => $data]);
    }

    /**
     * Pass additional key => value params to the view.
     *
     * @throws InvalidArgumentException On wrong $model instance.
     * @return array The additional params
     */
    protected function getAdditionalSaveViewParams(ActiveRecordInterface $model) {
        if (!$model instanceof StepPart) {
            throw new InvalidArgumentException();
        }

        $application = $model->application;

        return [
            'application_languages' => ApplicationLanguage::find()->where([
                'application_id' => $application->id
            ])->all(),
            'positions' => StepPartPosition::find()->all(),
        ];
    }

    /**
     * Finds a step part by its id.
     *
     * @param integer $id the step id.
     * @return Application The application.
     */
    protected function findModel($id) {
        return StepPart::find()->where([StepPart::tableName() . '.id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return Chain The new model.
     */
    protected function createModel($attributes = []) {
        $step = new StepPart($attributes);
        $step->type = StepPartType::getDefaultType()->type;
        $step->show_next_step_controls = true;
        $step->show_previous_step_controls = true;
        $step->show_skip_chain_controls = true;
        return $step;
    }

}

