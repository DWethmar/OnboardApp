<?php

namespace common\queries\step;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\StepPartLanguage]].
 *
 * @see \common\models\step\StepPartLanguage
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguageQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartLanguage[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepPartLanguage|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}