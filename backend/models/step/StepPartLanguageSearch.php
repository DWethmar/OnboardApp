<?php

namespace backend\models\step;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\step\StepPartLanguage;

/**
 * StepPartLanguageSearch represents the model behind the search form about `common\models\step\StepPartLanguage`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguageSearch extends StepPartLanguage {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['step_part_id', 'application_language_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['value'], 'safe'],
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
        $query = StepPartLanguage::find();

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
            'step_part_id' => $this->step_part_id,
            'application_language_id' => $this->application_language_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }

}