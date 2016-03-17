<?php

use common\models\step\ApplicationIdentityProgressLog;
use yii\db\Schema;
use yii\db\Migration;

/**
* This migration creates the base models.
*
* @author Dennis Wethmar <dennis@branchonline.nl>
**/
class m150826_093641_base_migration extends Migration {

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //////////////////////////////////////////
        // Application                          //
        //////////////////////////////////////////
        $this->createTable('{{%application}}', [
            'id'                                => $this->primaryKey(),
            'name'                              => $this->string(32)->notNull(),
            'access_key'                        => $this->string(64)->notNull(),
            'base_url'                          => $this->string(255)->notNull(),
            'default_application_language_id'   => $this->integer(),
            'created_at'                        => $this->integer()->notNull(),
            'updated_at'                        => $this->integer()->notNull(),
            'created_by'                        => $this->integer(),
            'updated_by'                        => $this->integer(),
            'tenant_id'                         => $this->integer()->notNull(),
        ], $tableOptions);
        // Bameable relations.
        $this->addForeignKey('fk_tbl_application_created_by_tbl_user', '{{%application}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_application_updated_by_tbl_user', '{{%application}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_application_tbl_tenant', '{{%application}}', 'tenant_id', '{{%tenant}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Application Identity                 //
        //////////////////////////////////////////
        $this->createTable('{{%application_identity}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'name' => $this->string(32),
            'identifier' => $this->string(32)->notNull(),
            'email' => $this->string(32),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_application_identity_created_by_tbl_user', '{{%application_identity}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_application_identity_updated_by_tbl_user', '{{%application_identity}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_application_identity_tbl_application', '{{%application_identity}}', 'application_id', '{{%application}}', 'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Application Language                 //
        //////////////////////////////////////////
        $application_language_code_length = 8;
        $this->createTable('{{%application_language}}', [
            'id' => $this->primaryKey(),
            'application_id' => $this->integer()->notNull(),
            'code' => $this->string($application_language_code_length)->notNull(),
            'name' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'CONSTRAINT u_application_language UNIQUE(application_id, code)',
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_application_language_created_by_tbl_user', '{{%application_language}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_application_language_updated_by_tbl_user', '{{%application_language}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_application_language_tbl_application', '{{%application_language}}', 'application_id', '{{%application}}', 'id', 'CASCADE', 'CASCADE');
        // Tbl Application Relation
        $this->addForeignKey('fk_tbl_application_tbl_application_language', '{{%application}}', 'default_application_language_id', '{{%application_language}}', 'id', 'RESTRICT', 'CASCADE');

        //////////////////////////////////////////
        // Page                                 //
        //////////////////////////////////////////
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'application_id' => $this->integer()->notNull(),
            'url' => $this->string(1024)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_page_created_by_tbl_user', '{{%page}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_page_updated_by_tbl_user', '{{%page}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_page_tbl_application', '{{%page}}', 'application_id', '{{%application}}', 'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Chain                                //
        //////////////////////////////////////////
        $this->createTable('{{%chain}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'next_chain_id' => $this->integer(),
            'name' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_chain_created_by_tbl_user', '{{%chain}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_chain_updated_by_tbl_user', '{{%chain}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_chain_tbl_page',         '{{%chain}}', 'page_id',        '{{%page}}',  'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_chain__next_tbl_chain',  '{{%chain}}', 'next_chain_id',  '{{%chain}}', 'id', 'SET NULL', 'CASCADE');

        //////////////////////////////////////////
        // Chain Requirement                    //
        //////////////////////////////////////////
        $this->createTable('{{%chain_requirement}}', [
            'parent_chain_id' => $this->integer(),
            'child_chain_id' => $this->integer(),
        ], $tableOptions);
        // Primary key.
        $this->addPrimaryKey('pk_chain_requirement', '{{%chain_requirement}}', ['parent_chain_id', 'child_chain_id']);
        // Relations.
        $this->addForeignKey('fk_chain_parent_chain', '{{%chain_requirement}}', 'parent_chain_id', '{{%chain}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_chain_child_chain',  '{{%chain_requirement}}', 'child_chain_id',  '{{%chain}}', 'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Step Type                            //
        //////////////////////////////////////////
        $step_type_length = 8;
        $this->createTable('{{%step_type}}', [
            'type' => $this->string($step_type_length),
        ], $tableOptions);
        // Primary key
        $this->addPrimaryKey('pk_step_type', '{{%step_type}}', 'type');

        //////////////////////////////////////////
        // Step                                 //
        //////////////////////////////////////////
        $this->createTable('{{%step}}', [
            'id' => $this->primaryKey(),
            'chain_id' => $this->integer()->notNull(), // Unique with sequence.
            'sequence' => $this->integer()->notNull(), // Unique with chain_id. // DEFERRED
            'type' => $this->string($step_type_length)->notNull(),
            'name' => $this->string(32)->notNull(),
            'highlight' => $this->boolean(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'CONSTRAINT u_step_chain_sequence UNIQUE(chain_id, sequence) DEFERRABLE INITIALLY DEFERRED',
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_step_created_by_tbl_user', '{{%step}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_step_updated_by_tbl_user', '{{%step}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_step_tbl_chain',     '{{%step}}', 'chain_id', '{{%chain}}',     'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_step_tbl_step_type', '{{%step}}', 'type',     '{{%step_type}}', 'type', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Step Part Position                   //
        //////////////////////////////////////////
        $step_part_position_name_length = 16;
        $this->createTable('{{%step_part_position}}', [
            'position' => $this->string($step_part_position_name_length),
            'full_name' => $this->string(32),
        ], $tableOptions);
        // Primary key
        $this->addPrimaryKey('pk_tbl_step_part_position', '{{%step_part_position}}', 'position');

        //////////////////////////////////////////
        // Step part Type                       //
        //////////////////////////////////////////
        $this->createTable('{{%step_part_type}}', [
            'type' => $this->string(8),
            'full_name' => $this->string(32),
        ], $tableOptions);
        // Primary key
        $this->addPrimaryKey('pk_tbl_step_part_type', '{{%step_part_type}}', 'type');

        //////////////////////////////////////////
        // Step Part                            //
        //////////////////////////////////////////
        $this->createTable('{{%step_part}}', [
            'id' => $this->primaryKey(),
            'step_id' => $this->integer()->notNull(),
            'name' => $this->string(32)->notNull(),
            'type' => $this->string(8)->notNull(),
            'position' => $this->string($step_part_position_name_length),
            'selector' => $this->string(1024),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_step_part_created_by_tbl_user', '{{%step_part}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_step_part_updated_by_tbl_user', '{{%step_part}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_step_part_tbl_step',               '{{%step_part}}', 'step_id',  '{{%step}}',               'id',       'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_step_part_tbl_step_part_type',     '{{%step_part}}', 'type',     '{{%step_part_type}}',     'type',     'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_step_part_tbl_step_part_position', '{{%step_part}}', 'position', '{{%step_part_position}}', 'position', 'CASCADE', 'SET NULL');

        //////////////////////////////////////////
        // Step Part Language                   //
        //////////////////////////////////////////
        $this->createTable('{{%step_part_language}}', [
            'step_part_id' => $this->integer()->notNull(),
            'application_language_id' => $this->integer()->notNull(),
            'value' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
        // Primary key.
        $this->addPrimaryKey('pk_tbl_step_part_language', '{{%step_part_language}}', ['step_part_id', 'application_language_id']);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_step_part_language_created_by_tbl_user', '{{%step_part_language}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_step_part_language_updated_by_tbl_user', '{{%step_part_language}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_step_part_language_tbl_step_part',            '{{%step_part_language}}', 'step_part_id',         '{{%step_part}}',            'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_step_part_language_tbl_application_language', '{{%step_part_language}}', 'application_language_id', '{{%application_language}}', 'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Application Identity Progress Log    //
        //////////////////////////////////////////
        $this->createTable('{{%application_identity_progress_log}}', [
            'id' => $this->primaryKey(),
            'application_identity_id' => $this->integer()->notNull(),
            'chain_id' => $this->integer()->notNull(),
            'step_id' => $this->integer()->notNull(),
            'state' => $this->string(32)->defaultValue(ApplicationIdentityProgressLog::STATE_START_STEP),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'CONSTRAINT u_application_identity_progress_log_unique UNIQUE(application_identity_id, chain_id, step_id, state)',
        ], $tableOptions);
        // Blameable relations.
        $this->addForeignKey('fk_tbl_application_identity_progress_log_created_by_tbl_user', '{{%application_identity_progress_log}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_application_identity_progress_log_updated_by_tbl_user', '{{%application_identity_progress_log}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_application_identity_progress_log_tbl_identity', '{{%application_identity_progress_log}}', 'application_identity_id', '{{%application_identity}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_application_identity_progress_log_tbl_chain',    '{{%application_identity_progress_log}}', 'chain_id',                '{{%chain}}',                'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_application_identity_progress_log_tbl_step',     '{{%application_identity_progress_log}}', 'step_id',                 '{{%step}}',                 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('{{%application_identity_progress_log}}');
        $this->dropTable('{{%step_part_language}}');
        $this->dropTable('{{%step_part}}');
        $this->dropTable('{{%step_part_type}}');
        $this->dropTable('{{%step_part_position}}');
        $this->dropTable('{{%step}}');
        $this->dropTable('{{%step_type}}');
        $this->dropTable('{{%chain_requirement}}');
        $this->dropTable('{{%chain}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%application_language}}');
        $this->dropTable('{{%application_identity}}');
        $this->dropTable('{{%application}}');
    }

}
