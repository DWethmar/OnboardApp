<?php

namespace common\queries\step;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\ChainRequirement]].
 *
 * @see \common\models\step\ChainRequirement
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainRequirementQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\step\ChainRequirement[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\ChainRequirement|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}