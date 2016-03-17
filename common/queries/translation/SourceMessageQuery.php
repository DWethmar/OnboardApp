<?php

namespace common\queries\translation;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\SourceMessage]].
 *
 * @see \common\models\SourceMessage
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class SourceMessageQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\SourceMessage[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\SourceMessage|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}