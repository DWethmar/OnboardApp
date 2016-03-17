<?php

namespace common\models\step;

use common\models\application\ApplicationIdentity;
use common\models\application\Chain;
use common\models\application\CommonChain;
use common\models\base\Application;
use common\models\base\OnboardModel;
use common\queries\step\ApplicationIdentityProgressLogQuery;
use Yii;

/**
 * This is the model class for table "{{%application_identity_progress_log}}".
 *
 * @property integer $id
 * @property integer $application_identity_id
 * @property integer $chain_id
 * @property integer $step_id
 * @property string  $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $common_chain_id
 * @property integer $common_step_id
 *
 * @property ApplicationIdentity $applicationIdentity
 * @property Step $step
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationIdentityProgressLog extends OnboardModel {

    /**
     * @var string The finished step state.
     */
    const STATE_FINISHED_CHAIN = 'FINISHED_CHAIN';

    /**
     * @var string The skipped step state.
     */
    const STATE_SKIPPED_CHAIN = 'SKIPPED_CHAIN';

    /**
     * @var string The started step state.
     */
    const STATE_START_STEP = 'START_STEP';

    /**
     * @var string The started step state.
     */
    const STATE_COMPLETED_STEP = 'COMPLETED_STEP';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_identity_progress_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application_identity_id', 'chain_id', 'step_id', 'common_chain_id', 'common_step_id'], 'required'],
            [['application_identity_id', 'chain_id', 'step_id', 'common_chain_id', 'common_step_id'], 'integer'],
            [['state'], 'string', 'max' => 32],
            ['state', 'default', 'value' => static::STATE_START_STEP],
            ['state', 'checkState'],
            [
                ['application_identity_id', 'chain_id', 'step_id', 'state'],
                'unique',
                'targetAttribute' => [
                    'application_identity_id',
                    'chain_id',
                    'step_id',
                    'state'
                ],
                'message' => Yii::t('app', 'duplicate log')
            ]
        ]);
    }

    /**
     * Check if the state is valid.
     *
     * @return boolean The succes of the check.
     */
    public function checkState() {
        return in_array($this->state, $this->getAllStates());
    }

    /**
     * Get available states.
     *
     * @return array Collection of available states.
     */
    public function getAllStates() {
        return [
            static::STATE_FINISHED_CHAIN,
            static::STATE_SKIPPED_CHAIN,
            static::STATE_START_STEP,
            static::STATE_COMPLETED_STEP,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'application_identity_id' => Yii::t('app', 'Application Identity ID'),
            'chain_id' => Yii::t('app', 'Chain ID'),
            'step_sequence' => Yii::t('app', 'Step Sequence'),
            'finished' => Yii::t('app', 'finished'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Set state to Finished Chain.
     * @return void
     */
    public function setStateFinishedChain() {
        $this->state = static::STATE_FINISHED_CHAIN;
    }

    /**
     * Set state to Skipped Chain.
     * @return void
     */
    public function setStateSkippedChain() {
        $this->state = static::STATE_SKIPPED_CHAIN;
    }

    /**
     * Set state to Started step.
     * @return void
     */
    public function setStateStartStep() {
        $this->state = static::STATE_START_STEP;
    }

    /**
     * Set state to Completed Step.
     * @return void
     */
    public function setStateCompletedStep() {
        $this->state = static::STATE_COMPLETED_STEP;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationIdentity() {
        return $this->hasOne(ApplicationIdentity::className(), ['id' => 'application_identity_id']);
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
    public function getStep() {
        return $this->hasOne(Step::className(), ['id' => 'step_id']);
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
    public function getCommonChain() {
        return $this->hasOne(CommonChain::className(), ['id' => 'common_chain_id']);
    }

    /**
     * @inheritdoc
     * @return StepApplicationIdentityQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApplicationIdentityProgressLogQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->applicationIdentity->application;
    }

}
