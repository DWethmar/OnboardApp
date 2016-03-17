<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * This migrations alters the application_identity identifier to 128 length.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151029_153101_application_identity_identifier_lenght extends Migration {

    public function safeUp() {
        $this->alterColumn('{{%application_identity}}', 'identifier', $this->string(128));
    }

    public function safeDown() {
        $this->alterColumn('{{%application_identity}}', 'identifier', $this->string(32));
    }

}
