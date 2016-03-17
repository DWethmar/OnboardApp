<?php

namespace backend\modules\builder\controllers;


use backend\modules\builder\components\utilities\ApplicationUtil;
use backend\modules\builder\components\widgets\ChainEditor;
use backend\modules\builder\components\widgets\PageEditor;
use backend\modules\builder\models\Chain;
use backend\modules\builder\models\Page;
use common\components\base\controllers\CRUDAjaxController;
use common\components\helpers\AjaxHelper;
use common\components\utilities\ActiveRecordUtil;
use common\components\utilities\ChainUtil;
use common\components\utilities\StepUtil;
use InvalidArgumentException;
use Yii;
use yii\db\ActiveRecordInterface;

/**
 * Ajax Controller for chain.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class AjaxChainController extends CRUDAjaxController {

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
     * Save steps of an chain in sequence.
     *
     * @param integer $id the chain id.
     * @param string $step_sequence The step ids in as string: '8,2,3,4,5'.
     * @return array The result in json string.
     */
    public function actionSaveSequence($id, $step_sequence) {
        $chain = Chain::find()->where([
            'id' => $id
        ])->one();

        $step_ids = explode(',', $step_sequence);

        if (!empty($chain)) {
            $steps = ChainUtil::orderSteps($chain, $step_ids);
            if (ActiveRecordUtil::saveModelsInTransaction($steps)) {
                $data = ApplicationUtil::getChainTree($chain);
                return AjaxHelper::success([
                    'html' => ChainEditor::widget(['data' => $data])
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
        if (!$model instanceof Chain) {
            throw new InvalidArgumentException();
        }

        if ($is_new) { // Render the Page
            $data = ApplicationUtil::getPageTree($model->page);
            return PageEditor::widget(['data' => $data]);
        }

        $data = ApplicationUtil::getChainTree($model);
        return ChainEditor::widget(['data' => $data]);
    }

    /**
     * Pass additional key => value params to the view.
     *
     * @return array The additional params
     */
    protected function getAdditionalSaveViewParams(ActiveRecordInterface $model) {
        if (!$model instanceof Chain) {
            throw new InvalidArgumentException();
        }
        $application = $model->application;
        return [
            'chains' => Chain::find()
                ->leftJoin(Page::tableName() . ' page', 'page.id = ' . Chain::tableName() . '.page_id')
                ->where([
                    'page.application_id' => $application->id,
                ])
                ->andWhere(Chain::tableName() . '.id != :id', [
                    'id' => $model->id
                ])
                ->andWhere([
                    'NOT IN',
                    Chain::tableName() . '.id',
                    $model->getPreviousChains()->select('id')
                ])
                ->all(),
        ];
    }

    /**
     * Finds a page by its id.
     *
     * @param integer $id the page id.
     * @return Page The page.
     */
    protected function findModel($id) {
        return Chain::find()->where([Chain::tableName() . '.id' => $id])->checkAccess(Yii::$app->user->id)->one();
    }

    /**
     * Creates a new model.
     *
     * @param array $attributes The attributes to start with.
     *
     * @return Chain The new model.
     */
    protected function createModel($attributes = []) {
        $chain = new Chain($attributes);
        $chain->continue_on_completion = true;
        return $chain;
    }

}

