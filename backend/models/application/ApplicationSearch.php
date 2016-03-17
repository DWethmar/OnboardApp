<?php

namespace backend\models\application;

use common\queries\application\ApplicationQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\application\Application;

/**
 * ApplicationSearch represents the model behind the search form about `common\models\application\Application`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationSearch extends Application {

    /**
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'createdBy',
            'updatedBy',
            'tenant',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'tenant_id'], 'integer'],
            [['name', 'access_key', 'base_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Application::find();

        $data_provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $data_provider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'tenant_id' => $this->tenant_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'access_key', $this->access_key]);

        $this->_checkAccess($query);

        return $data_provider;
    }

    /**
     * @param ApplicationQuery $query Query with added conditions,
     * @return void.
     */
    private function _checkAccess(ApplicationQuery &$query) {
        $query->andWhere(['tenant_id' => Yii::$app->user->identity->tenant_id]);
    }

}