<?php

namespace backend\models\application;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\application\ChainRequirement;

/**
 * ChainRequirementSearch represents the model behind the search form about `common\models\application\ChainRequirement`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainRequirementSearch extends ChainRequirement {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_chain_id', 'child_chain_id'], 'integer'],
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
        $query = ChainRequirement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'parent_chain_id' => $this->parent_chain_id,
            'child_chain_id' => $this->child_chain_id,
        ]);

        return $dataProvider;
    }

}