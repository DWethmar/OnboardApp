<?php

namespace backend\modules\application\components\utilities;

use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\Step;
use yii\db\Query;
use common\models\application\ApplicationIdentity;

/**
 * Logic for generating application chart data
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationChartUtil {

    /**
     * Generate duration data.
     *
     * @return array The data for an Application wide map
     */
    public static function generateCompletedStepDurationData() {
        $query = new Query;
        $query->select('step.id, (log2.created_at - log1.created_at) as duration')
            ->from(ApplicationIdentityProgressLog::tableName() . ' log1')
            ->leftJoin(ApplicationIdentity::tableName() . ' identity', 'identity.id = log1.application_identity_id')
            ->leftJoin(Step::tableName() . ' step', 'step.id = log1.step_id')
            ->leftJoin(ApplicationIdentityProgressLog::tableName() . ' log2', "(log1.application_identity_id = log2.application_identity_id AND log1.chain_id = log2.chain_id AND log1.step_id = log2.step_id AND (log2.state = :STATE_COMPLETED_STEP OR log2.state = :STATE_FINISHED_CHAIN))", [
                'STATE_COMPLETED_STEP' =>  ApplicationIdentityProgressLog::STATE_COMPLETED_STEP,
                'STATE_FINISHED_CHAIN' =>  ApplicationIdentityProgressLog::STATE_FINISHED_CHAIN,
            ])
            ->where(['log1.state' => ApplicationIdentityProgressLog::STATE_START_STEP])
            ->andWhere(['!=', 'identity.identifier', '%_d'])
            ->andWhere(['!=', 'log2.created_at', '0'])
            ->orderBy('log1.created_at ASC');

        return $query->all();
    }

    /**
     * Generate duration for skipped data.
     *
     * @return array The data for an Application wide map
     */
    public static function generateUnfinishedStepDurationData() {
        $query = new Query;
        $query->select('step.id, (log2.created_at - log1.created_at) as duration')
            ->from(ApplicationIdentityProgressLog::tableName() . ' log1')
            ->leftJoin(ApplicationIdentity::tableName() . ' identity', 'identity.id = log1.application_identity_id')
            ->leftJoin(Step::tableName() . ' step', 'step.id = log1.step_id')
            ->leftJoin(ApplicationIdentityProgressLog::tableName() . ' log2', "(log1.application_identity_id = log2.application_identity_id AND log1.chain_id = log2.chain_id AND log1.step_id = log2.step_id AND log2.state = :STATE_SKIPPED_CHAIN)", [
                'STATE_SKIPPED_CHAIN' =>  ApplicationIdentityProgressLog::STATE_SKIPPED_CHAIN,
            ])
            ->where(['log1.state' => ApplicationIdentityProgressLog::STATE_START_STEP])
            ->andWhere(['!=', 'identity.identifier', '%_d'])
            ->andWhere(['!=', 'log2.created_at', '0'])
            ->orderBy('log1.created_at ASC');

        return $query->all();
    }


}