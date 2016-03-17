<?php

namespace backend\modules\application\components\utilities;

use common\models\application\ApplicationIdentity;
use common\models\application\Chain;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\Step;
use yii\db\Query;

/**
 * Logic for generating application chart data
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class LogStatisticsUtil {

    /**
     * Get the duration data for all users in application->id = 4
     *
     * @param string $user_group_identifier The group that we want.
     * @param $set The set for group.
     * @return array The data
     */
    public static function generateChainDurationData($user_group_identifier = '_stats_even', $set) {
        $application_users = ApplicationIdentity::find()->where([
            'application_id' => 4,
        ])->andWhere([
            'like', 'identifier', $user_group_identifier
        ])->all();
        $data = [];
        $i = 0;

        foreach ($application_users as $application_user) {
            $user_times_query = static::getStartTimes($application_user->id);
            $times = $user_times_query->all();

            foreach ($times as $key => $start_time) {
                $next_time = isset($times[$key + 1]) ? $times[$key + 1] : [];
                if (empty($next_time)) {
                    break;
                } else {
                    $data[] = [$key + 1, ($next_time['created_at'] - $start_time['created_at']), $set, $application_user->identifier];
                    $i++;
                }
            }

        }
        return $data;
    }


    /**
     * Generate duration data.
     *
     * @return array The data for an Application wide map
     */
    public static function getStartTimes($identity_id) {
        $query = new Query;
        $query->select('identity.identifier, log1.created_at as created_at')
            ->from(ApplicationIdentityProgressLog::tableName() . ' log1')

            ->leftJoin(ApplicationIdentity::tableName() . ' identity', 'identity.id = log1.application_identity_id')

            ->leftJoin(Step::tableName() . ' step', 'step.id = log1.step_id')
            ->leftJoin(Chain::tableName() . ' chain', 'chain.id = log1.chain_id')

            ->where(['log1.common_chain_id' => Chain::find()
                ->select('common_chain_id')
                ->andFilterWhere(['like', 'name', 'Task:%', false])
                ->groupBy('common_chain_id')
            ])

            ->andWhere(['log1.state' => ApplicationIdentityProgressLog::STATE_START_STEP])
            ->andWhere(['step.sequence' => 1])
            ->andWhere(['identity.id' => $identity_id])

            ->orderBy('log1.created_at ASC');

        return $query;
    }

}