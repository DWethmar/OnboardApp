<?php

namespace common\queries\step;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[CommonStep]].
 *
 * @see CommonStep
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class CommonStepQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return CommonStep[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CommonStep|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}