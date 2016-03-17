<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Flag for ignoring the query part of a url.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class m151119_165045_page_url_query_ignore extends Migration {

    public function safeUp() {
        $this->addColumn('{{%page}}', 'ignore_url_query', $this->boolean()->defaultValue(false));
    }

    public function safeDown() {
        $this->dropColumn('{{%page}}', 'ignore_url_query');
    }

}
