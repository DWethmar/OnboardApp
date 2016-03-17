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
use common\models\step\StepEvent;
use common\models\step\StepPart;
use common\models\step\StepPartLanguage;
use Psr\Log\InvalidArgumentException;
use yii\base\Exception;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * This util handles Application version data.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class VersionUtil extends Object {

    /**
     * Duplicates application data to an new version.
     *
     * @param Application $application The application to update with a new version.
     * @param ApplicationVersion $old_application_version The old version model.
     * @param ApplicationVersion $new_application_version The new version model.
     *
     * @return bool The success
     * @throws Exception
     */
    public static function duplicateApplicationVersionData(Application $application, ApplicationVersion $old_application_version, ApplicationVersion $new_application_version) {

        if ($application->id != $old_application_version->application_id) {
            throw new InvalidArgumentException('Old Version is not related to application!');
        }

        if ($application->id != $new_application_version->application_id) {
            throw new InvalidArgumentException('New Version is not related to application!');
        }

        $pages = $application->getPages()->where([
            'application_version_id' => $old_application_version->id
        ])->all();

        // Copy Pages
        foreach ($pages as $page) {
            $copied_page = new Page($page->attributes);
            $copied_page->application_version_id = $new_application_version->id;
            unset($copied_page->id);

            if ($copied_page->save()) {

                $copied_chains = [];
                // Copy Chains
                foreach ($page->chains as $chain) {
                    $copied_chain = new Chain($chain->attributes);
                    $copied_chain->page_id = $copied_page->id;
                    unset($copied_chain->id);

                    if ($copied_chain->save()) {
                        $copied_chains[] = $copied_chain;

                        // Copy steps
                        foreach ($chain->steps as $step) {
                            $copied_step = new Step($step->attributes);
                            $copied_step->chain_id = $copied_chain->id;
                            unset($copied_step->id);

                            if ($copied_step->save()) {

                                // Copy step parts
                                foreach ($step->stepParts as $step_part) {
                                    $copied_step_part = new StepPart($step_part->attributes);
                                    $copied_step_part->step_id = $copied_step->id;
                                    unset($copied_step_part->id);

                                    // Copy step translations
                                    if ($copied_step_part->save()) {
                                        foreach ($step_part->stepPartLanguages as $step_part_language) {
                                            $copied_step_part_language = new StepPartLanguage($step_part_language->attributes);
                                            $copied_step_part_language->step_part_id = $copied_step_part->id;

                                            if (!$copied_step_part_language->save()) {
                                                throw new Exception('Could not copy step part language!');
                                            }
                                        }
                                    } else {
                                        throw new Exception('Could not copy step!');
                                    }
                                }

                                // Copy events
                                foreach ($step->stepEvents as $step_event) {
                                    $copied_step_event = new StepEvent($step_event->attributes);
                                    $copied_step_event->step_id = $copied_step->id;
                                    unset($copied_step_event->id);

                                    if (!$copied_step_event->save()) {
                                        throw new Exception('Could not copy step event!');
                                    }
                                }
                            } else {
                                var_dump($copied_chain->errors);
                                throw new Exception('Could not copy step!');
                            }
                        }
                    } else {
                        throw new Exception('Could not copy chain!');
                    }
                }
                static::setCorrectNextChain($copied_chains);
            } else {
                var_dump($copied_page);
                throw new Exception('Could not copy page!');
            }
        }

        return true;
    }

    /**
     * Sets the correct next chain on a copied chain.
     *
     * @param array $chains The chains to update.
     */
    private static function setCorrectNextChain(array $chains) {
        foreach ($chains as $chain) {
            if (!empty($chain->nextChain)) {
                $common_chain_id = $chain->nextChain->common_chain_id;

                $correct_chain = Chain::find()->where([
                    'common_chain_id' => $common_chain_id
                ])
                    ->leftJoin(Page::tableName() . ' p' , 'p.id = page_id')
                    ->andWhere(['p.application_version_id' => $chain->page->application_version_id])
                    ->one();
                $chain->next_chain_id = $correct_chain->id;
                $chain->save();
            }
        }
    }

}

