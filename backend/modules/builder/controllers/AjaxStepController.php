<?php

namespace backend\modules\builder\controllers;


use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\widgets\ChainEditor;
use backend\modules\builder\components\widgets\StepEditor;
use backend\modules\builder\models\Application;
use backend\modules\builder\models\Step;
use common\components\base\controllers\CRUDAjaxController;
use common\components\utilities\ActiveRecordUtil;
use common\components\utilities\ChainUtil;
use common\models\application\Chain;
use common\models\step\StepType;
use InvalidArgumentException;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for application.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxStepController extends CRUDAjaxController {

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
        if (!$model instanceof Step) {
            throw new InvalidArgumentException();
        }

        if ($is_new) { // Render Chain
            $data = ApplicationUtil::getChainTree($model->chain);
            return ChainEditor::widget(['data' => $data]);
        }

        $data = ApplicationUtil::getStepTree($model);
        return StepEditor::widget(['data' => $data]);
    }

    /**
     * Finds a step by its id.
     *
     * @param integer $id the step id.
     * @return Application The application.
     */
    protected function findModel($id) {
        return Step::find()->where([Step::tableName() . '.id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return Chain The new model.
     */
    protected function createModel($attributes = []) {
        $step = new Step($attributes);
        $step->type = StepType::getDefaultType()->type;
        $step->show = true;
        return $step;
    }

    /**
     * Generic after delete logic.
     *
     * @param ActiveRecordInterface $model The successfully deleted model.
     * @return void
     */
    protected function afterDelete(ActiveRecordInterface $model) {
        if (!$model instanceof Step) {
            throw new InvalidArgumentException();
        }
        $steps = ChainUtil::resetStepSequence($model->chain);
        ActiveRecordUtil::saveModelsInTransaction($steps);
    }

}

