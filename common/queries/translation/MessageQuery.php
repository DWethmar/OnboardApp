<?php

namespace common\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Message]].
 *
 * @see \common\models\Message
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class MessageQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\Message[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Message|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}