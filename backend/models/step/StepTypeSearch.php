<?php

namespace backend\models\step;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\step\StepType;

/**
 * StepTypeSearch represents the model behind the search form about `common\models\step\StepType`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepTypeSearch extends StepType {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'safe'],
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
        $query = StepType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }

}