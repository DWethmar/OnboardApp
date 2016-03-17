<?php

namespace api\modules\v1\components\utilities;

use api\modules\v1\components\facade\OnboardManager;
use common\models\application\Application;
use common\models\application\ApplicationIdentity;
use common\models\application\ApplicationVersion;
use common\models\application\Chain;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\StepEventType;
use common\models\step\StepEventAction;
use yii\base\Exception;
use yii\base\Object;

/**
 * This util handles data for the api.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApiDataUtil extends Object{

    /**
     * [WIP] Collect the data for a Onboard tour.
     *
     * @param string $url The requested url.
     * @param Application $application The application that is currently logged in.
     * @param ApplicationVersion $application_version
     * @param string $application_identity_id The identifier for the client user.
     * @param string $language_code The language code.
     * @return object The collected data for a user in a plain php model.
     * @throws Exception
     */
    public static function getOnboardData($url, Application $application, ApplicationVersion $application_version, $application_identity_id, $language_code) {
        $result = [];

        $application_language = OnboardManager::getApplicationLanguage($application, $language_code)->one();

        $pages = OnboardManager::getPage($application, $application_version, $url)->all();

        foreach ($pages as $page) {
            $application_identity = OnboardManager::getApplicationIdentity($application, $application_identity_id)->one();
            if (empty($application_identity)) {
                $application_identity = new ApplicationIdentity();
                $application_identity->application_id = $application->id;
                $application_identity->identifier = $application_identity_id;
                if (!$application_identity->save()) {
                    throw new Exception('Could not create identity');
                }
            }

            $chains = $page->chains;
            $chain = static::getActiveChain($chains, $application_identity);

            if (!empty($chain)) {

                $result['continue_on_completion'] = $chain->continue_on_completion;

                $result['version'] = $application_version->version;

                $result['min_window_width'] = $chain->min_window_width;
                $result['max_window_width'] = $chain->max_window_width;
                $result['min_window_height'] = $chain->min_window_height;
                $result['max_window_height'] = $chain->max_window_height;

                $steps = $chain->getSteps()->with(['stepParts', 'stepEvents'])->all();

                foreach ($steps as $step) { // TODO: opsplitsen in afzonderlijke functies

                    if (!count($step->stepParts)) {
                        continue;
                    }

                    $events = $step->stepEvents;

                    $step_data = [];
                    $step_data['step_code'] = $step->commonStep->code;
                    $step_data['sequence'] =  $step->sequence;
                    $step_data['type'] =      $step->type;

                    $step_data['highlight'] = $step->highlight;

                    $step_data['event_listeners_show'] =     static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_SHOW);
                    $step_data['event_listeners_hide'] =     static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_HIDE);
                    $step_data['event_listeners_previous'] = static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_PREVIOUS);
                    $step_data['event_listeners_next'] =     static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_NEXT);
                    $step_data['event_listeners_finish'] =   static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_FINISH);
                    $step_data['event_listeners_skip'] =     static::getEventData($events, StepEventType::TYPE_LISTENER, StepEventAction::ACTION_SKIP);

                    $step_data['event_triggers_show'] =     static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_SHOW);
                    $step_data['event_triggers_hide'] =     static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_HIDE);
                    $step_data['event_triggers_previous'] = static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_PREVIOUS);
                    $step_data['event_triggers_next'] =     static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_NEXT);
                    $step_data['event_triggers_finish'] =   static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_FINISH);
                    $step_data['event_triggers_skip'] =     static::getEventData($events, StepEventType::TYPE_TRIGGER, StepEventAction::ACTION_SKIP);

                    $step_data['scroll_to'] =               true;
                    $step_data['show'] =                    $step->show;

                    $step_data['parts'] = [];
                    foreach ($step->stepParts as $step_part) {

                        $step_part_language = $step_part->getStepPartLanguages()->where([
                            'application_language_id' => $application_language->id
                        ])->one();

                        $step_part_data = [];
                        $step_part_data['selector'] =               $step_part->selector;
                        $step_part_data['title'] =                  empty($step_part_language) ? '' : $step_part_language->title;
                        $step_part_data['value'] =                  empty($step_part_language) ? '' : $step_part_language->value;
                        $step_part_data['show_button_next'] =       $step_part->show_next_step_controls;
                        $step_part_data['show_button_previous'] =   $step_part->show_previous_step_controls;
                        $step_part_data['show_button_skip'] =       $step_part->show_skip_chain_controls;
                        $step_part_data['position'] =               $step_part->position;
                        $step_part_data['offset_x'] =               $step_part->offset_x;
                        $step_part_data['offset_y'] =               $step_part->offset_y;

                        $step_data['parts'][] = (object) $step_part_data;
                    }

                    $result['steps'][] = (object) $step_data;
                }

                return (object) $result; // Cast to object so it can be interpreted as a object in Javascript.
            }
        }

        if (empty($pages)) {
            return (object) $result;
        }
    }

    /**
     * Format event data for the onboard tour..
     *
     * @param array  $events The Events to filter.
     * @param string $type   The Type to filter on.
     * @param string $action The Action to filter on.
     *
     * @return array The formatted events.
     */
    protected static function getEventData(array $events, $type, $action) {
        $events = static::filterEvents($events, $type, $action);
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'event' => $event->event,
                'selector' => $event->selector,
            ];
        }
        return $data;
    }

    /**
     * Filter Events on type and action.
     *
     * @param array  $events The Events to filter.
     * @param string $type   The Type to filter on.
     * @param string $action The Action to filter on.
     *
     * @return array The filtered events.
     */
    protected static function filterEvents(array $events, $type, $action) {
        return array_filter($events, function($m) use ($type, $action) {
            return $m->type === $type && $m->action === $action;
        });
    }

    /**
     * [WIP] Choose the current chain.
     *
     * This function searches the active chain for a ApplicationIdentity.
     * [TODO] We look if previous chains are completed by the identity
     * and if the chain requirements are met.
     *
     * @param array               $chains   The chains to choose from.
     * @param ApplicationIdentity $identity Current identity to check progress for.
     *
     * @return Chain|null The chosen chain.
     */
    public static function getActiveChain(array $chains, ApplicationIdentity $identity) {
        foreach ($chains as $chain) {
            if ($chain->isFinished($identity->id)) { // Check if this chain is finished.
                continue;
            }

            $previous_unfinished_chain = array_filter($chain->previousChains, function($chain) use ($identity){
                return !$chain->isFinished($identity->id);
            });

            if (empty($previous_unfinished_chain)) {
                return $chain;
            }
        }
        return null;
    }

}
