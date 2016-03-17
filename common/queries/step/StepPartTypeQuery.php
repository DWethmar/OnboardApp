<?php

namespace common\queries\step;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\StepPartType]].
 *
 * @see \common\models\step\StepPartType
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartTypeQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartType[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartType|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
}