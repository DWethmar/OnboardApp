<?php

use common\models\application\Application;
use common\models\application\ApplicationVersion;
use yii\db\Migration;

/**
 * This migration creates a new model for application versions.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 * @see http://semver.org/
 */
class m151116_093008_application_version extends Migration {

    public function safeUp() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //////////////////////////////////////////
        // Application Version                  //
        //////////////////////////////////////////
        $this->createTable('{{%application_version}}', [
            'id'                                => $this->primaryKey(),
            'application_id'                    => $this->integer()->notNull(),
            'name'                              => $this->string(16)->notNull(),

            'major_version'                     => $this->integer()->notNull()->defaultValue(1),
            'minor_version'                     => $this->integer()->notNull()->defaultValue(0),
            'patch_version'                     => $this->integer()->notNull()->defaultValue(0),

            'created_at'                        => $this->integer()->notNull(),
            'updated_at'                        => $this->integer()->notNull(),
            'created_by'                        => $this->integer(),
            'updated_by'                        => $this->integer(),
            'CONSTRAINT u_application_version UNIQUE(application_id, major_version, minor_version, patch_version)',
        ], $tableOptions);
        // Bameable relations.
        $this->addForeignKey('fk_tbl_application_version_created_by_tbl_user', '{{%application_version}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_application_version_updated_by_tbl_user', '{{%application_version}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        // Relations.
        $this->addForeignKey('fk_tbl_application_version_tbl_application', '{{%application_version}}', 'application_id', '{{%application}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Common Chain                         //
        //////////////////////////////////////////
        $this->createTable('{{%common_chain}}', [
            'id'                                => $this->primaryKey(),
            'application_id'                    => $this->integer()->notNull(),
            'code'                              => $this->string(16)->notNull(),

            'created_at'                        => $this->integer()->notNull(),
            'updated_at'                        => $this->integer()->notNull(),
            'created_by'                        => $this->integer(),
            'updated_by'                        => $this->integer(),
            'CONSTRAINT u_common_chain UNIQUE(application_id, code)',
        ], $tableOptions);
        // Bameable relations.
        $this->addForeignKey('fk_tbl_common_chain__created_by_tbl_user', '{{%common_chain}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_common_chain__updated_by_tbl_user', '{{%common_chain}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_common_chain_tbl_application', '{{%common_chain}}', 'application_id', '{{%application}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Common Step                          //
        //////////////////////////////////////////
        $this->createTable('{{%common_step}}', [
            'id'                                => $this->primaryKey(),
            'application_id'                    => $this->integer()->notNull(),
            'code'                              => $this->string(16)->notNull(),

            'created_at'                        => $this->integer()->notNull(),
            'updated_at'                        => $this->integer()->notNull(),
            'created_by'                        => $this->integer(),
            'updated_by'                        => $this->integer(),
            'CONSTRAINT u_common_step UNIQUE(application_id, code)',
        ], $tableOptions);
        // Bameable relations.
        $this->addForeignKey('fk_tbl_common_step__created_by_tbl_user', '{{%common_step}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_tbl_common_step__updated_by_tbl_user', '{{%common_step}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        // Relations.
        $this->addForeignKey('fk_tbl_common_step_tbl_application', '{{%common_step}}', 'application_id', '{{%application}}',  'id', 'CASCADE', 'CASCADE');

        foreach (Application::find()->all() as $application) {
            // Seed initial Application
            $application_version = new ApplicationVersion();
            $application_version->application_id = $application->id;
            $application_version->name = 'Initial version';
            $application_version->save();
        }

        //////////////////////////////////////////
        // Application Identity Progress Log    //
        //////////////////////////////////////////
        $this->addColumn('{{%application_identity_progress_log}}', 'common_chain_id',        $this->integer()); // NOT NULL in next migration
        $this->addColumn('{{%application_identity_progress_log}}', 'common_step_id',         $this->integer()); // NOT NULL in next migration
        // Relations.
        $this->addForeignKey('fk_tbl_application_identity_progress_log_tbl_common_chain',            '{{%application_identity_progress_log}}', 'common_chain_id', '{{%common_chain}}',  'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tbl_application_identity_progress_log_tbl_common_step',             '{{%application_identity_progress_log}}', 'common_step_id', '{{%common_step}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Page                                 //
        //////////////////////////////////////////
        //TODO: Remove application_id in next migration
        $this->addColumn('{{%page}}', 'application_version_id', $this->integer()); // NOT NULL in next migration
        // Relations.
        $this->addForeignKey('fk_tbl_page_tbl_application_version', '{{%page}}', 'application_version_id', '{{%application_version}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Chain                                //
        //////////////////////////////////////////
        $this->addColumn('{{%chain}}', 'common_chain_id', $this->integer()); // NOT NULL in next migration
        // Relations.
        $this->addForeignKey('fk_tbl_chain_tbl_common_chain', '{{%chain}}', 'common_chain_id', '{{%common_chain}}',  'id', 'CASCADE', 'CASCADE');

        //////////////////////////////////////////
        // Step                                //
        //////////////////////////////////////////
        $this->addColumn('{{%step}}', 'common_step_id', $this->integer()); // NOT NULL in next migration
        // Relations.
        $this->addForeignKey('fk_tbl_step_tbl_common_step', '{{%step}}', 'common_step_id', '{{%common_step}}',  'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropColumn('{{%application_identity_progress_log}}', 'common_chain_id');
        $this->dropColumn('{{%application_identity_progress_log}}', 'common_step_id');

        $this->dropColumn('{{%page}}', 'application_version_id');

        $this->dropColumn('{{%chain}}', 'common_chain_id');

        $this->dropColumn('{{%step}}', 'common_step_id');

        $this->dropTable('{{%common_chain}}');
        $this->dropTable('{{%common_step}}');

        $this->dropTable('{{%application_version}}');
    }

}
