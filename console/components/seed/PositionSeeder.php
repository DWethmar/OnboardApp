<?php

namespace console\components\seed;

use common\components\utilities\ActiveRecordUtil;
use common\models\step\StepPartPosition;
use yii\helpers\Console;

/**
 * Seed System with Positions.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class PositionSeeder {

    /**
     * Create Default Positions.
     *
     * @return void
     */
    public static function go() {
        echo "\n----------------------------------------\n";
        echo Console::ansiFormat('Seeding default positions', [Console::FG_CYAN]);
        echo "\n----------------------------------------\n";

        $position_names = StepPartPosition::getAllPosition();

        $existing_positions = StepPartPosition::find()
            ->select('position')
            ->column();

        $positions = [];
        foreach ($position_names as $position_name) {
            echo "\nChecking if position: " . Console::ansiFormat($position_name, [Console::FG_BLUE]) . " already exists! \n";
            if (!in_array($position_name,  $existing_positions)) {
                echo "\nCreating " . Console::ansiFormat($position_name, [Console::FG_GREEN]) . " position \n";
                $position = new StepPartPosition();
                $position->position = $position_name;
                $position->full_name = ucfirst(str_replace('-', ' ', $position_name));
                $positions[] = $position;
            } else {
                $log = Console::ansiFormat($position_name, [Console::FG_RED]);
                echo "\nPosition already exist: $log \n";
            }
        }

        ActiveRecordUtil::saveModelsInTransaction($positions);
    }

}