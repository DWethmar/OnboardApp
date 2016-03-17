<?php

namespace console\components\seed;

use common\components\utilities\ActiveRecordUtil;
use common\models\step\StepEventAction;
use common\models\step\StepEventType;
use yii\helpers\Console;

/**
 * Seed System with Event settings.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEventSeeder {

    /**
     * Seed Event settings.
     *
     * @return void
     */
    public static function go() {
        echo "\n----------------------------------------\n";
        echo Console::ansiFormat('Seeding Event settings', [Console::FG_CYAN]);
        echo "\n----------------------------------------\n";

        static::_seedStepEventTypes();
        static::_seedStepEventActions();
    }

    /**
     * Seed system with Step Event Types.
     *
     * @return bool the success.
     */
    private static function _seedStepEventTypes() {
        $types = StepEventType::getAllTypes();

        $existing_types = StepEventType::find()
            ->select('type')
            ->column();

        $new_types = [];
        foreach ($types as $type) {
            echo "\nChecking if step event type: " . Console::ansiFormat($type, [Console::FG_BLUE]) . " exists! \n";
            if (!in_array($type,  $existing_types)) {
                echo "\nCreating " . Console::ansiFormat($type, [Console::FG_GREEN]) . " type \n";
                $step_event_type = new StepEventType();
                $step_event_type->type = $type;

                $new_types[] = $step_event_type;
            } else {
                $log = Console::ansiFormat($type, [Console::FG_RED]);
                echo "\nStep event type already exists: $log \n";
            }
        }

        return ActiveRecordUtil::saveModelsInTransaction($new_types);
    }

    /**
     * Seed system with Step Event Actions.
     *
     * @return bool the success.
     */
    private static function _seedStepEventActions() {
        $actions = StepEventAction::getAllActions();

        $existing_actions = StepEventAction::find()
            ->select('action')
            ->column();

        $new_actions = [];
        foreach ($actions as $action) {
            echo "\nChecking if step event action: " . Console::ansiFormat($action, [Console::FG_BLUE]) . " exists! \n";
            if (!in_array($action,  $existing_actions)) {
                echo "\nCreating " . Console::ansiFormat($action, [Console::FG_GREEN]) . " type \n";
                $step_event_action = new StepEventAction();
                $step_event_action->action = $action;

                $new_actions[] = $step_event_action;
            } else {
                $log = Console::ansiFormat($action, [Console::FG_RED]);
                echo "\nStep event action already exists: $log \n";
            }
        }

        return ActiveRecordUtil::saveModelsInTransaction($new_actions);
    }

}