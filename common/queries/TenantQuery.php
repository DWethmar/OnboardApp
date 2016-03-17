<?php

namespace common\queries;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tenant]].
 *
 * @see Tenant
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class TenantQuery extends ActiveQuery {

    /**
     * @inheritdoc
     * @return Tenant[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tenant|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}