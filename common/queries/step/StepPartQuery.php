<?php

namespace common\queries\step;

use backend\modules\builder\models\Step;
use common\models\application\Application;
use common\models\application\Chain;
use common\models\application\Page;
use common\models\step\StepPart;
use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\step\StepPart]].
 *
 * @see \common\models\step\StepPart
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartQuery extends ActiveQuery {

    /**
     * Add access filter to the Step part Query.
     *
     * @return ActiveQuery The query.
     */
    public function checkAccess($user_id) {
        $this->leftJoin(Step::tableName() . ' step', 'step.id = ' . StepPart::tableName() . '.step_id')
            ->leftJoin(Chain::tableName() . ' chain', 'chain.id = step.chain_id')
            ->leftJoin(Page::tableName() . ' page', 'page.id = chain.page_id')
            ->leftJoin(Application::tableName() . ' application', 'application.id = page.application_id')
            ->andWhere([
                'application.tenant_id' => User::find()
                    ->select(User::tableName() . '.tenant_id')
                    ->where([User::tableName() . '.id' => $user_id])
                    ->limit(1)
            ]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepPart[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\step\StepPart|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}