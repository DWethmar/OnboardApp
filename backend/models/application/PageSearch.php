<?php

namespace backend\models\application;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\application\Page;

/**
 * PageSearch represents the model behind the search form about `common\models\application\Page`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class PageSearch extends Page {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'application_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'url'], 'safe'],
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

        $query = Page::find();

        $data_provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->with(['application']);
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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $data_provider;
    }

}