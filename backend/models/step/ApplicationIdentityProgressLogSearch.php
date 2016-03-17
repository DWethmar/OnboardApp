<?php

namespace backend\models\step;

use backend\modules\builder\models\Chain;
use common\models\application\Application;
use common\models\step\Step;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\step\ApplicationIdentityProgressLog;

/**
 * ApplicationIdentityProgressLogSearch represents the model behind the search form about `common\models\step\ApplicationIdentityProgressLog`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationIdentityProgressLogSearch extends ApplicationIdentityProgressLog {

    /**
     * @var string The application identity id
     */
    public $identifier;

    /**
     * @var string The chain name.
     */
    public $chain_name;

    /**
     * @var string The step name.
     */
    public $step_name;

    /**
     * @var string The step sequence.
     */
    public $step_sequence;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'application_identity_id', 'chain_id', 'step_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['state', 'identifier', 'chain_name', 'step_name', 'step_sequence', 'common_chain_id', 'common_step_id'], 'safe'],
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
        $query = ApplicationIdentityProgressLogSearch::find();

        $data_provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $data_provider->sort->attributes['identifier'] = [
            'asc' => ['{{%application_identity}}.identifier' => SORT_ASC],
            'desc' => ['{{%application_identity}}.identifier' => SORT_DESC],
            'label' => 'identifier'
        ];

        $data_provider->sort->attributes['chain_name'] = [
            'asc' => ['{{%chain}}.name' => SORT_ASC],
            'desc' => ['{{%chain}}.name' => SORT_DESC],
            'label' => 'Chain'
        ];

        $data_provider->sort->attributes['step_name'] = [
            'asc' => ['{{%step}}.name' => SORT_ASC],
            'desc' => ['{{%step}}.name' => SORT_DESC],
            'label' => 'Step'
        ];

        $data_provider->sort->attributes['step_sequence'] = [
            'asc' => ['{{%step}}.sequence' => SORT_ASC],
            'desc' => ['{{%step}}.sequence' => SORT_DESC],
            'label' => 'Sequence'
        ];

        if (!$this->load($params) && !$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $data_provider;
        }

        $query->joinWith([
            'applicationIdentity',
            'chain',
            'step',
        ]);

        $query->andFilterWhere([
            parent::tableName() . '.id' => $this->id,
            parent::tableName() . '.application_identity_id' => $this->application_identity_id,
            parent::tableName() . '.chain_id' => $this->chain_id,
            parent::tableName() . '.step_id' => $this->step_id,
            parent::tableName() . '.created_at' => $this->created_at,
            parent::tableName() . '.updated_at' => $this->updated_at,
            parent::tableName() . '.created_by' => $this->created_by,
            parent::tableName() . '.updated_by' => $this->updated_by,
            parent::tableName() . '.common_chain_id' => $this->common_chain_id,
            parent::tableName() . '.common_step_id' => $this->common_step_id,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state]);

        $query->andFilterWhere(['like', '{{%application_identity}}.identifier', $this->identifier]);
        $query->andFilterWhere(['like', '{{%chain}}.name', $this->chain_name]);
        $query->andFilterWhere(['like', '{{%step}}.name',  $this->step_name]);
        $query->andFilterWhere(['{{%step}}.sequence' =>  $this->step_sequence]);

        return $data_provider;
    }

}