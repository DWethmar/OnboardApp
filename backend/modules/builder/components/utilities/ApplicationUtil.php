<?php

namespace backend\modules\builder\components\utilities;

use api\modules\v1\components\facade\OnboardManager;
use common\models\application\Application;
use common\models\application\ApplicationIdentity;
use common\models\application\ApplicationVersion;
use common\models\application\Chain;
use common\models\application\Page;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\Step;
use common\models\step\StepPart;
use common\models\step\StepPartLanguage;
use Psr\Log\InvalidArgumentException;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * This util handles Application data.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationUtil extends Object {

    /**
     * Create a complete tree structure for an application.
     *
     * Starting with the application all the way to StepPart.
     *
     * @param Application $application The application to use for the tree.
     * @param ApplicationVersion $application_version The version to use.
     * @param boolean $recursive Collect data recursive.
     *
     * @return array The complete tree of a application.
     */
    public static function getApplicationTree(Application $application, Applicationversion $application_version, $recursive = true) {
        $tree = ArrayHelper::toArray($application);

        if ($application->id != $application_version->application_id) {
            throw new InvalidArgumentException('The provided version is not related to the application!');
        }

        $tree['version'] = ArrayHelper::toArray($application_version);
        if ($recursive) {
            $pages = $application->getPages()->where([
                'application_version_id' => $application_version->id
            ])->all();
            foreach ($pages as $page) {
                $tree['pages'][] = static::getPageTree($page);
            }
        }
        return $tree;
    }


    /**
     * Create a complete tree structure for an page.
     *
     * Starting with the page all the way to StepPart.
     *
     * @param page    $page      The page to use for the tree.
     * @param boolean $recursive Collect data recursive.
     *
     * @return array The complete tree of a page.
     */
    public static function getPageTree(page $page, $recursive = true) {
        $tree =  ArrayHelper::toArray($page);
        if ($recursive) {
            foreach ($page->chains as $chain) {
                $tree['chains'][] = static::getChainTree($chain);
            }
        }
        return $tree;
    }

    /**
     * Create a complete tree structure for an chain.
     *
     * Starting with the chain all the way to StepPart.
     *
     * @param Chain   $chain     The chain to use for the tree.
     * @param boolean $recursive Collect data recursive.
     *
     * @return array The complete tree of a chain.
     */
    public static function getChainTree(Chain $chain, $recursive = true) {
        $tree =  ArrayHelper::toArray($chain);
        if ($recursive) {
            $tree['previous_chains'] = ArrayHelper::toArray($chain->previousChains);
            if (!empty($chain->nextChain)) {
                $tree['next_chain'] = ArrayHelper::toArray($chain->nextChain);
            }
            foreach ($chain->steps as $step) {
                $tree['steps'][] = static::getStepTree($step);
            }
        }
        return $tree;
    }

    /**
     * Create a complete tree structure for an step.
     *
     * Starting with the step all the way to StepPart.

     * @param Step $step The step to use for the tree.
     * @param boolean $recursive Collect data recursive.
     *
     * @return array The complete tree of a Step.
     */
    public static function getStepTree(Step $step, $recursive = true) {
        $tree = ArrayHelper::toArray($step);
        if ($recursive) {
            foreach ($step->stepParts as $step_part) {
                $tree['step_parts'][] = static::getStepPartTree($step_part);
            }
        }
        return $tree;
    }

    /**
     * Create a complete tree structure for an step.
     *
     * @param StepPart $step_part The step part to use for the tree.
     *
     * @return array The complete tree of a StepPart.
     */
    public static function getStepPartTree(StepPart $step_part) {
        return ArrayHelper::toArray($step_part);
    }

}
