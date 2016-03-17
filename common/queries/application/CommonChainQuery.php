<?php

namespace common\queries\application;
use common\models\application\CommonChain;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CommonChain]].
 *
 * @see CommonChain
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class CommonChainQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return CommonChain[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CommonChain|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}