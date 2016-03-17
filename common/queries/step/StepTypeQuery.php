<?php

namespace common\queries\step;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\StepType]].
 *
 * @see \common\models\step\StepType
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepTypeQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\step\StepType[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepType|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}