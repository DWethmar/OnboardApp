<?php

use yii\db\Migration;

/**
* This migration makes sure that some base tables are build.
*
* @author Dennis Wethmar <dennis@branchonline.nl> 
**/
class m130524_201442_init extends Migration{

    public function safeUp(){
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tenant}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'tenant_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_user_created_by_user', '{{%user}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_updated_by_user', '{{%user}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_tenant', '{{%user}}', 'tenant_id', '{{%tenant}}', 'id', 'CASCADE', 'NO ACTION');

        // Tenant -> user
        $this->addForeignKey('fk_tenant_created_by_user', '{{%tenant}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tenant_updated_by_user', '{{%tenant}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%message}}', [
            'id' => $this->integer(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('pk_message', '{{%message}}', ['id', 'language']);
        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown(){
        $this->dropForeignKey('fk_user_tenant', '{{%user}}');
        $this->dropTable('{{%tenant}}');
        $this->dropTable('{{%user}}');
        $this->droptable('{{%message}}');
        $this->droptable('{{%source_message}}');
    }

}
