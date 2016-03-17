<?php

namespace common\queries\application;

use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\application\Application]].
 *
 * @see \common\models\application\Application
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationQuery extends ActiveQuery {

    /**
     * Add access key filter to the Application Query.
     *
     * @return ActiveQuery The query.
     */
    public function checkAccess($user_id) {
        $this->andWhere(['tenant_id' => User::find()->select('tenant_id')->where(['id' => $user_id])->scalar()]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\application\Application[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\application\Application|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * Add access key filter to the Application Query.
     *
     * @return ActiveQuery The query.
     */
    public function byAccessKey($key) {
        $this->andWhere(['access_key' => $key]);
        return $this;
    }

}