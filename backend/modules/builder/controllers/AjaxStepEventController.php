<?php

namespace backend\modules\builder\controllers;

use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\widgets\StepEditor;
use backend\modules\builder\components\widgets\StepPartEditor;
use backend\modules\builder\models\Application;
use backend\modules\builder\models\Step;
use backend\modules\builder\models\StepPart;
use common\components\base\controllers\CRUDAjaxController;
use common\components\helpers\AjaxHelper;
use common\models\application\ApplicationLanguage;
use common\models\application\Chain;
use common\models\step\StepEvent;
use common\models\step\StepEventAction;
use common\models\step\StepEventType;
use common\models\step\StepPartPosition;
use common\models\step\StepPartType;
use InvalidArgumentException;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for Step events.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxStepEventController extends CRUDAjaxController {

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
     * Renders a over view for step events.
     *
     * @param integer $id The step id.
     *
     * @throws InvalidArgumentException On wrong step id.
     * @return string The rendered Html.
     */
    public function actionOverview($id) {
        $step = Step::find()
            ->checkAccess(Yii::$app->user->id)
            ->where([Step::tableName() . '.id' => $id])
            ->with('stepEvents')
            ->one();

        if ($step === null) {
            throw InvalidArgumentException();
        }
        $events = $step->stepEvents;
        $event_listeners = array_filter($events, function($m) {
            return $m->type === StepEventType::TYPE_LISTENER;
        });

        $event_triggers = array_filter($events, function($m) {
            return $m->type === StepEventType::TYPE_TRIGGER;
        });

        return $this->renderPartial('overview', [
            'step' => $step,
            'event_listeners' => $event_listeners,
            'event_triggers' => $event_triggers,
        ]);
    }

    /**
     * The HTML to render when the model has been saved.
     *
     * @param ActiveRecordInterface $model  The successfully saved model.
     * @param boolean               $is_new Set to  true if the model is new.
     *
     * @throws InvalidArgumentException On wrong instance.
     * @return string The HTM to return on a successful save.
     */
    protected function renderSave(ActiveRecordInterface $model, $is_new = false) { return ''; }

    /**
     * Pass additional key => value params to the view.
     *
     * @throws InvalidArgumentException On wrong $model instance.
     * @return array The additional params
     */
    protected function getAdditionalSaveViewParams(ActiveRecordInterface $model) {
        if (!$model instanceof StepEvent) {
            throw new InvalidArgumentException();
        }

        $step = Step::findOne($model->step_id);

        return [
            'step' => $step,
            'event_types' => StepEventType::find()->all(),
            'event_actions' => StepEventAction::find()->all(),
        ];
    }

    /**
     * Finds a step part by its id.
     *
     * @param integer $id the step id.
     * @return Application The application.
     */
    protected function findModel($id) {
        return StepEvent::find()->where([StepEvent::tableName() . '.id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return Chain The new model.
     */
    protected function createModel($attributes = []) {
        return (new StepEvent($attributes));
    }

}

