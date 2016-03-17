<?php

namespace common\queries\application;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ApplicationIdentity]].
 *
 * @see ApplicationIdentity
 */
class ApplicationIdentityQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return ApplicationIdentity[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ApplicationIdentity|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}