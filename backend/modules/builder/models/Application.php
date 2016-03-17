<?php

namespace backend\modules\builder\models;

use Yii;
use yii\base\Model;
use common\models\application\Application as ApplicationBase;

/**
 * Application represents the model behind the search form about `common\models\application\Application`.
 *
 * This model is used for the application editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Application extends ApplicationBase {

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            'id',
            'name',
            'base_url',
            'tenant_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['name', 'base_url'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

}