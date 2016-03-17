<?php

namespace common\queries\application;

use common\models\application\Application;
use common\models\application\Page;
use common\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class PageQuery extends ActiveQuery {

    /**
     * Add access key filter to the Page Query.
     *
     * @return ActiveQuery The query.
     */
    public function checkAccess($user_id) {
        $this->leftJoin(Application::tableName() . ' application', 'application.id = ' . Page::tableName() . '.application_id')
            ->andWhere([
                'application.tenant_id' => User::find()->select(User::tableName() . '.tenant_id')->where([User::tableName() . '.id' => $user_id])->scalar()
            ]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Page[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Page|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}