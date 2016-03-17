<?php

namespace backend\models\application;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\application\ApplicationLanguage;

/**
 * ApplicationLanguageSearch represents the model behind the search form about `common\models\application\ApplicationLanguage`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationLanguageSearch extends ApplicationLanguage {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'application_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name'], 'safe'],
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
        $query = ApplicationLanguage::find();

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
            'application_id' => $this->application_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $data_provider;
    }

}