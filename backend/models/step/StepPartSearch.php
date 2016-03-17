<?php

namespace backend\models\step;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\step\StepPart;

/**
 * StepPartSearch represents the model behind the search form about `common\models\step\StepPart`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartSearch extends StepPart {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'step_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'type', 'selector'], 'safe'],
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
    public function search($params)
    {
        $query = StepPart::find();

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
            'step_id' => $this->step_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'selector', $this->selector]);

        return $data_provider;
    }

}