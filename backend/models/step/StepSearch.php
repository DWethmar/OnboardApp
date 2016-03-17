<?php

namespace backend\models\step;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\step\Step;

/**
 * StepSearch represents the model behind the search form about `common\models\step\Step`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepSearch extends Step {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'chain_id', 'sequence', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['type', 'name', 'highlight'], 'safe'],
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
        $query = Step::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'chain_id' => $this->chain_id,
            'sequence' => $this->sequence,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
