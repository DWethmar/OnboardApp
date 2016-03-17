<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations adds the rest of the base domain model.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m150930_075340_base2 extends Migration {

    /** @inheritdoc */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //////////////////////////////////////////
        // Step Event Type                      //
        //////////////////////////////////////////
        $step_event_type_length = 16;
        $this->createTable('{{%step_event_type}}', [
            'type' => $this->string($step_event_type_length),
        ], $tableOptions);
        // Primary key
        $this->addPrimaryKey('pk_tbl_step_event_type', '{{%step_event_type}}', 'type');

        //////////////////////////////////////////
        // Step Event Action                    //
        //////////////////////////////////////////
        $step_event_action_length = 16;
        $this->createTable('{{%step_event_action}}', [
            'action' => $this->string($step_event_action_length),
        ], $tableOptions);
        // Primary key
        $this->addPrimaryKey('pk_tbl_step_event_action', '{{%step_event_action}}', 'action');

        //////////////////////////////////////////
        // Step Event                           //
        //////////////////////////////////////////
        $this->createTable('{{%step_event}}', [
            'id' => $this->primaryKey(),
            'step_id' => $this->integer()->notNull(),
            'name' => $this->string(32)->notNull(),

            'type' => $this->string($step_event_type_length)->notNull(),
            'action' => $this->string($step_event_action_length)->notNull(),
            'event' => $this->string(64)->notNull(),
            'selector' => $this->string(1024),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_step_event_created_by_tbl_user', '{{%step_event}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_step_event_updated_by_tbl_user', '{{%step_event}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations
        $this->addForeignKey('fk_tbl_step_event_tbl_step',              '{{%step_event}}', 'step_id', '{{%step}}',              'id',     'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_step_event_tbl_step_event_type',   '{{%step_event}}', 'type',    '{{%step_event_type}}',   'type',   'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_step_event_tbl_step_event_action', '{{%step_event}}', 'action',  '{{%step_event_action}}', 'action', 'CASCADE', 'CASCADE');
    }

    /** @inheritdoc */
    public function safeDown() {
        $this->dropTable('{{%step_event}}');
        $this->dropTable('{{%step_event_action}}');
        $this->dropTable('{{%step_event_type}}');
    }

}
