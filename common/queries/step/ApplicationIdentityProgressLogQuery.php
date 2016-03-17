<?php

namespace common\queries\step;

use common\models\step\ApplicationIdentityProgressLog;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\ApplicationIdentityProgressQuery]].
 *
 * @see \common\models\step\ApplicationIdentityProgressQuery
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationIdentityProgressLogQuery extends ActiveQuery {

    /**
     * Filter on Finished Chain state.
     *
     * @return ActiveQuery The query object.
     */
    public function stateFinishedChain() {
        return $this::andWhere(['state' => ApplicationIdentityProgressLog::STATE_FINISHED_CHAIN]);
    }

    /**
     * Filter on Skipped Chain state.
     *
     * @return ActiveQuery The query object.
     */
    public function stateSkippedChain() {
        return $this::andWhere(['state' => ApplicationIdentityProgressLog::STATE_SKIPPED_CHAIN]);
    }

    /**
     * Filter on Start Step state.
     *
     * @return ActiveQuery The query object.
     */
    public function stateStartStep() {
        return $this::andWhere(['state' => ApplicationIdentityProgressLog::STATE_START_STEP]);
    }

    /**
     * Filter on Skipped Step state.
     *
     * @return ActiveQuery The query object.
     */
    public function stateCompletedStep() {
        return $this::andWhere(['state' => ApplicationIdentityProgressLog::STATE_COMPLETED_STEP]);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepApplicationIdentity[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepApplicationIdentity|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}