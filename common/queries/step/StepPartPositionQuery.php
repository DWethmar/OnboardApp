<?php

namespace common\queries\step;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\StepPartPosition]].
 *
 * @see \common\models\step\StepPartPosition
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartPositionQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartPosition[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartPosition|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}