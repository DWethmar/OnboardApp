<?php

namespace common\queries\step;

use backend\modules\builder\models\Page;
use common\models\application\Application;
use common\models\application\Chain;
use common\models\application\ChainRequirement;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Chain]].
 *
 * @see Chain
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainQuery extends ActiveQuery {

    /**
     * Add access filter to the Chain Query.
     *
     * @return ActiveQuery The query.
     */
    public function checkAccess($user_id) {
        $this->leftJoin(Page::tableName() . ' page', 'page.id = ' . Chain::tableName() . '.page_id')
            ->leftJoin(Application::tableName() . ' application', 'application.id = page.application_id')
            ->andWhere([
                'application.tenant_id' => User::find()
                    ->select(User::tableName() . '.tenant_id')
                    ->where([User::tableName() . '.id' => $user_id])
                    ->scalar()
            ]);
        return $this;
    }

    /**
     * Selects the root chain of a application
     * @param integer $application_id the application id.
     *
     * @return ActiveQuery The query.
     */
    public function root($application_id) {
        $sub_query = ChainRequirement::find()
            ->select('child_chain_id')
            ->leftJoin(Chain::tableName() . ' c', 'c.id = parent_chain_id')
            ->where(['c.application_id' => $application_id]);
        $this->andWhere(['not in', 'id', $sub_query]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Chain[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Chain|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}