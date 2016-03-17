<?php

namespace common\queries\step;
use common\models\application\Application;
use common\models\application\Chain;
use common\models\application\Page;
use common\models\step\Step;
use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\Step]].
 *
 * @see \common\models\step\Step
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepQuery extends ActiveQuery {

    /**
     * Add access filter to the Step Query.
     *
     * @param integer $user_id The user id to check.
     *
     * @return ActiveQuery The query.
     */
    public function checkAccess($user_id) {
        $this->leftJoin(Chain::tableName() . ' chain', 'chain.id = ' . Step::tableName() . '.chain_id')
            ->leftJoin(Page::tableName() . ' page', 'page.id = chain.page_id')
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
     * Get the previous step in a application version ;).
     *
     * @param integer $common_chain_id  The common chain id.
     * @param integer $sequence         The current sequence.
     *
     * @return ActiveQuery The query object.
     */
    public function previousStep($common_chain_id, $sequence) {
        return $this::andWhere(['id' => Step::find()
            ->select(Step::tableName() . '.id')
            ->leftJoin(Chain::tableName(), Chain::tableName().'.id = ' . Step::tableName() . '.chain_id')
            ->andWhere([Chain::tableName().'.common_chain_id' => $common_chain_id])
            ->having('max(sequence) = :sequence', ['sequence' => $sequence - 1])
            ->groupBy(Step::tableName() . '.id')
        ])
        ->orderBy('sequence DESC');
    }

    /**
     * @inheritdoc
     * @return \common\models\step\Step[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\Step|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
