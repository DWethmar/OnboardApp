<?php

namespace common\models\step;

use common\models\application\Page;
use common\models\application\Chain;
use common\models\base\OnboardModel;
use common\queries\step\StepQuery;
use Yii;

/**
 * This is the model class for table "{{%step}}".
 *
 * @property integer $id
 * @property integer $chain_id
 * @property integer $sequence
 * @property string $type
 * @property string $name
 * @property boolean $highlight
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $show
 * @property integer $common_step_id
 *
 * @property ApplicationIdentityProgressLog[] $applicationIdentityProgressLogs
 * @property Chain $chain
 * @property StepType $type0
 * @property CommonStep $commonStep
 * @property User $createdBy
 * @property User $updatedBy
 * @property StepEvent[] $stepEvents
 * @property StepPart[] $stepParts
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Step extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['chain_id', 'sequence', 'type', 'name'], 'required'],
            [['chain_id', 'sequence'], 'integer'],
            [['highlight', 'show'], 'boolean'],
            [['type'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 32],
            [
                ['chain_id', 'sequence'],
                'unique',
                'targetAttribute' => [
                    'chain_id',
                    'sequence'
                ],
                'when' => function($model) { // Don't do this check in an tranaction.
                    return Yii::$app->db->getTransaction() ? false : true;
                },
                'message' => 'The combination of Chain ID and Sequence has already been taken.'
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'chain_id' => Yii::t('app', 'Chain ID'),
            'sequence' => Yii::t('app', 'Sequence'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChain() {
        return $this->hasOne(Chain::className(), ['id' => 'chain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0() {
        return $this->hasOne(StepType::className(), ['type' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonStep() {
        return $this->hasOne(CommonStep::className(), ['id' => 'common_step_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationIdentityProgressLogs() {
        return $this->hasMany(ApplicationIdentityProgressLog::className(), ['step_id' => 'id']);
    }

    /** @return \yii\db\ActiveQuery */
    public function getStepEvents() {
        return $this->hasMany(StepEvent::className(), ['step_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepParts() {
        return $this->hasMany(StepPart::className(), ['step_id' => 'id']);
    }

    /**
     * Checks if this is the last step in a chain.
     *
     * @return boolean Is last step.
     */
    public function isLastStep() {
        $highest_step = $this->chain->getSteps()->orderBy('sequence DESC')->one();
        return $highest_step->id === $this->id;
    }

    /**
     * get highest sequence number.
     *
     * @return integer The highest sequence.
     */
    public static function getHighestSequence($chain_id) {
        $sequence = Step::find()->select(['MAX(sequence)'])->where(['chain_id' => $chain_id])->scalar();
        return empty($sequence) ? 0 : $sequence;
    }

    /**
     * @inheritdoc
     * @return StepQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->chain->application;
    }

}
