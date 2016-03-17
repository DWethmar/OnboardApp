<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations add min/max dimensions to the chain. The purpose of this migrations is to
 * protect styling that is triggered by media queries.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151109_100644_min_max_height_chains extends Migration {

    public function safeUp() {
        $this->addColumn('{{%chain}}', 'min_window_width', $this->integer());
        $this->addColumn('{{%chain}}', 'min_window_height', $this->integer());

        $this->addColumn('{{%chain}}', 'max_window_width', $this->integer());
        $this->addColumn('{{%chain}}', 'max_window_height', $this->integer());
    }

    public function safeDown() {
        $this->dropColumn('{{%chain}}', 'min_window_width');
        $this->dropColumn('{{%chain}}', 'min_window_height');

        $this->dropColumn('{{%chain}}', 'max_window_width');
        $this->dropColumn('{{%chain}}', 'max_window_height');
    }

}
