<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations adds x and y offset to step.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151105_092048_step_offset extends Migration {

    public function safeUp() {
        $this->addColumn('{{%step_part}}', 'offset_x', $this->integer());
        $this->addColumn('{{%step_part}}', 'offset_y', $this->integer());
    }

    public function safeDown() {
        $this->dropColumn('{{%step_part}}', 'offset_x');
        $this->dropColumn('{{%step_part}}', 'offset_y');
    }

}
