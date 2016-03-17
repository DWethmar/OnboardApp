<?php

namespace common\components\utilities;

use api\modules\v1\components\facade\OnboardManager;
use common\models\application\Application;
use common\models\application\ApplicationIdentity;
use common\models\application\Chain;
use common\models\application\Page;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\Step;
use common\models\step\StepPart;
use common\models\step\StepPartLanguage;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * This util handles Chain data.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainUtil extends Object {

    /**
     * Reset the step-sequence.
     *
     * @param Chain $chain The chain that provides the steps.
     * @return array Collection of ordered steps.
     */
    public static function resetStepSequence(Chain $chain) {
        $steps = $chain->getSteps()->orderBy('sequence')->all();

        foreach ($steps as $key => $step) {
            $step->sequence = $key + 1;
        }

        return $steps;
    }

    /**
     * Order steps with a provided sequence.
     *
     * @param Chain $chain The chain that provides the steps.
     * @param array $step_ids Sorted steps id for setting the new step sequence: [2, 3, 1]
     *
     * @return array Collection of ordered steps.
     */
    public static function orderSteps(Chain $chain, array $step_ids = []) {
        $steps = $chain->getSteps()->orderBy('sequence')->all();
        if (empty($step_ids)) {
            return [];
        }

        $highest_sequence = count($step_ids);
        foreach ($steps as $step) {
            $sequence = array_search($step->id, $step_ids) + 1; // Set sequence as index of the $step_ids array.
            if ($sequence === false) { // This step isn't in $step_ids. So we give it the highest sequence.
                $step->sequence = $highest_sequence;
                $highest_sequence++;
            } else {
                $step->sequence = $sequence;
            }
        }

        return $steps;
    }

}
