<?php

namespace common\queries\application;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\application\ApplicationLanguage]].
 *
 * @see \common\models\application\ApplicationLanguage
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationLanguageQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return \common\models\application\ApplicationLanguage[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\application\ApplicationLanguage|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}