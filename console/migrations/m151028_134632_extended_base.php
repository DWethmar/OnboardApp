<?php

use yii\db\Schema;
use yii\db\Migration;

class m151028_134632_extended_base extends Migration {

    /** @inheritdoc */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->addColumn('{{%step_part}}', 'show_next_step_controls',       $this->boolean()->defaultValue(true));
        $this->addColumn('{{%step_part}}', 'show_previous_step_controls',   $this->boolean()->defaultValue(true));
        $this->addColumn('{{%step_part}}', 'show_skip_chain_controls',      $this->boolean()->defaultValue(true));

        $this->addColumn('{{%step_part_language}}', 'title', $this->string(1024));
    }

    /** @inheritdoc */
    public function safeDown() {
        $this->dropColumn('{{%step_part}}', 'show_next_step_controls');
        $this->dropColumn('{{%step_part}}', 'show_previous_step_controls');
        $this->dropColumn('{{%step_part}}', 'show_skip_chain_controls');

        $this->dropColumn('{{%step_part_language}}', 'title');
    }

}
