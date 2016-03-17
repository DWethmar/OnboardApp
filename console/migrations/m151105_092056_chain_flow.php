<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations add a check for a chain.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151105_092056_chain_flow extends Migration {

    public function safeUp() {
        $this->addColumn('{{%chain}}', 'continue_on_completion', $this->boolean()->defaultValue(true));
    }

    public function safeDown() {
        $this->dropColumn('{{%chain}}', 'continue_on_completion');
    }

}
