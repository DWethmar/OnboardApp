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
class UserQuery extends ActiveQuery {

    /**
     * Add active filter to the User Query.
     *
     * @return ActiveQuery The query.
     */
    public function active() {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }

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