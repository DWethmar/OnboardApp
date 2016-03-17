<?php

namespace api\modules\v1\components\facade;

use api\modules\v1\components\utilities\ApiDataUtil;
use common\models\application\Application;
use common\models\application\ApplicationIdentity;
use common\models\application\ApplicationLanguage;
use common\models\application\ApplicationVersion;
use common\models\application\Chain;
use common\models\application\Page;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\CommonStep;
use common\models\step\Step;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Object;

/**
 * This facade collects data that is needed for running the javascript tour.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class OnboardManager extends Object {

    /**
     * [WIP] Saves user progress.
     *
     * Check for if the step is a checkpoint.
     *
     * @param Application           $application            The application.
     * @param ApplicationVersion    $application_version    The application version.
     * @param Step                  $step                   The step to use.
     * @param string                $uid                    The user identifier.
     * @param boolean               $finish                 Finish this chain for this user.
     * @param boolean               $skip                   Skip this chain for this user.
     *
     * @return boolean The success.
     */
    public static function saveProgress(Application $application, ApplicationVersion $application_version, Step $step, $uid, $finish = false, $skip = false) {
        $identity = static::getApplicationIdentity($application, $uid)->one();

        if (null === $identity) {
            return false;
        }

        $common_step = $step->commonStep;
        $common_chain = $step->chain->commonChain;

        // Check previous step and set it to completed.
        // But only if the previous step has been started!
        $completed_previous_log = false;
        $previous_steps = Step::find()->with('chain')->previousStep($step->chain->common_chain_id, $step->sequence)->all();

        foreach ($previous_steps as $previous_step) {
            // Has the previous step been started?
            $previous_started_step_log = $previous_step->getApplicationIdentityProgressLogs()->andWhere([
                'application_identity_id' => $identity->id,
                'common_chain_id' => $previous_step->chain->common_chain_id,
            ])->stateStartStep()->one();

            // Has te previous step been completed?
            $previous_completed_step_log = $previous_step->getApplicationIdentityProgressLogs()->andWhere([
                'application_identity_id' => $identity->id,
                'common_chain_id' => $previous_step->chain->common_chain_id,
            ])->stateCompletedStep()->one();

            if (!empty($previous_started_step_log) && empty($previous_completed_step_log)) {
                $previous_log = new ApplicationIdentityProgressLog();
                $previous_log->application_identity_id = $identity->id;
                $previous_log->chain_id = $previous_step->chain_id;
                $previous_log->step_id = $previous_step->id;
                $previous_log->setStateCompletedStep();
                $previous_log->common_step_id = $previous_step->common_step_id;
                $previous_log->common_chain_id = $previous_step->chain->common_chain_id;
                $completed_previous_log = $previous_log->save();
                if (!$completed_previous_log) {
                    var_dump($previous_log->errors);
                }
            }
        }

        // Check if a step has already been started
        $log = static::getApplicationIdentityProgressLog($application, $identity, $step->chain->common_chain_id, $step->common_step_id)->stateStartStep()->with('step.chain')->one();

        $saved_new_log = false;
        // Only create the new Progress log if there isn one already.
        if (empty($log)) {
            $log = new ApplicationIdentityProgressLog();
            $log->application_identity_id = $identity->id;
            $log->chain_id = $step->chain_id;
            $log->step_id = $step->id;
            $log->setStateStartstep();
            $log->common_step_id = $common_step->id;
            $log->common_chain_id = $common_chain->id;
            $saved_new_log = $log->save();
        }

        $finished = false;
        // We are going to finish on this chain and on this step.
        if ($finish) {
            $finish_log = new ApplicationIdentityProgressLog();
            $finish_log->application_identity_id = $identity->id;
            $finish_log->chain_id = $step->chain_id;
            $finish_log->step_id = $step->id;
            $finish_log->setStateFinishedChain();
            $finish_log->common_step_id = $common_step->id;
            $finish_log->common_chain_id = $common_chain->id;
            $finished = $finish_log->save();
        }

        $skipped = false;
        // We are going to skip on this chain and on this step.
        if ($skip) {
            $skip_log = new ApplicationIdentityProgressLog();
            $skip_log->application_identity_id = $identity->id;
            $skip_log->chain_id = $step->chain_id;
            $skip_log->step_id = $step->id;
            $skip_log->setStateSkippedChain();
            $skip_log->common_step_id = $common_step->id;
            $skip_log->common_chain_id = $common_chain->id;
            $skipped = $skip_log->save();
        }

        return ($completed_previous_log || $saved_new_log || $finished || $skipped);
    }

    /**
     * Get Step for Application.
     *
     * @param Application        $application            The Application to check.
     * @param ApplicationVersion $application_version    The Application to check.
     * @param string             $step_code              The step id.
     *
     * @return ActiveQuery The step query.
     */
    public static function getStep(Application $application, ApplicationVersion $application_version, $step_code) {
        $step_query = Step::find()->where([
            CommonStep::tableName() .  '.code'                      => $step_code,
            Page::tableName() .        '.application_version_id'    => $application_version->id,
            Application::tableName() . '.id'                        => $application->id,
        ])
        ->leftJoin(Chain::tableName(),       Chain::tableName() .       '.id = ' . Step::tableName() . '.chain_id')
        ->leftJoin(Page::tableName(),        Page::tableName() .        '.id = ' . Chain::tableName() . '.page_id')
        ->leftJoin(Application::tableName(), Application::tableName() . '.id = ' . Page::tableName() . '.application_id')
        ->leftJoin(CommonStep::tableName(),  CommonStep::tableName() .  '.id = ' . Step::tableName() . '.common_step_id');

        return $step_query;
    }

    /**
     * Get Progress for an ApplicationIdentity.
     *
     * @param Application         $application          The Application to check.
     * @param ApplicationIdentity $identity             The ApplicationIdentity to check.
     * @param integer             $common_chain_id      The common chain id.
     * @param integer             $common_step_id       The common step id.
     * @return ActiveQuery The log query.
     */
    public static function getApplicationIdentityProgressLog(Application $application, ApplicationIdentity $identity, $common_chain_id, $common_step_id) {
        $table_name = ApplicationIdentityProgressLog::tableName();

        $log_query = ApplicationIdentityProgressLog::find()->where([
            $table_name.'.application_identity_id' => $identity->id,
            $table_name.'.common_chain_id' => $common_chain_id,
            $table_name.'.common_step_id' => $common_step_id,
            Application::tableName() . '.id' => $application->id,
        ])
        ->leftJoin(Chain::tableName(),       Chain::tableName() .       '.id = ' . ApplicationIdentityProgressLog::tableName() . '.chain_id')
        ->leftJoin(Page::tableName(),        Page::tableName() .        '.id = ' . Chain::tableName() . '.page_id')
        ->leftJoin(Application::tableName(), Application::tableName() . '.id = ' . Page::tableName() . '.application_id');
        return $log_query;
    }


    /**
     * Gets the application language.
     *
     * @param Application $application   The application model.
     * @param string      $language_code The language code.
     *
     * @return ActiveQuery The Application Langauge query.
     */
    static function getApplicationLanguage(Application $application, $language_code) {
        return ApplicationLanguage::find()->where([
            'application_id' => $application->id,
            'code' => $language_code,
        ]);
    }

    /**
     * Get identity for a application. Create if not exists.
     *
     * @param Application $application             The application model.
     * @param string      $application_identity_id The identifier for the client user.
     *
     * @return ActiveQuery The Application Indentity query.
     */
    static function getApplicationIdentity(Application $application, $application_identity_id) {
        $identity_query = ApplicationIdentity::find()->where([
            'application_id' => $application->id,
            'identifier' => $application_identity_id
        ]);
        return $identity_query;
    }

    /**
     * Get page for application by url.
     *
     * @param Application $application                  The application model.
     * @param ApplicationVersion $application_version   The application version to check the pages on.
     * @param string $url                               The referrer url.
     * @return ActiveQuery                              The query for page.
     * @throw InvalidParamException When a page cannot be linked to the provided url.
     *
     */
    static function getPage(Application $application, ApplicationVersion $application_version, $url) {
        $page_parts = parse_url($url);

        $page_path = isset($page_parts['path']) ? $page_parts['path'] : null;
        $page_query = isset($page_parts['query']) ? $page_parts['query'] : null;

        $relative_url = $page_path . (empty($page_query) ? '' : '?' . $page_query);
        $query = Page::find();

        $query->andWhere([
            'application_id' => $application->id,
            'application_version_id' =>  $application_version->id,
            'url' => $page_path,
            'ignore_url_query' => true,
        ]);

        $query->orFilterWhere([
            'application_id' => $application->id,
            'application_version_id' =>  $application_version->id,
            'url' => $relative_url,
            'ignore_url_query' => false,
        ]);

        $query->orderBy('('
            . ' CASE'
            . " WHEN url LIKE :relative_url_1 THEN 1"
            . " WHEN url LIKE :relative_url_2 THEN 2"
            . " WHEN url LIKE :relative_url_3 THEN 3"
            . ' ELSE 4'
            . ' END) ASC, url'
        );

        $query->addParams([
            'relative_url_1' => $relative_url,
            'relative_url_2' => $relative_url . '%',
            'relative_url_3' => '%' . $relative_url,
        ]);

        return $query;
    }

}
