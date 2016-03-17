<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations add a show flag to a step.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151105_105619_step_hide extends Migration {

    public function safeUp() {
        $this->addColumn('{{%step}}', 'show', $this->boolean()->defaultValue(true));
    }

    public function safeDown() {
        $this->dropColumn('{{%step}}', 'show');
    }

}
