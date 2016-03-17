<?php

namespace common\models\application;

use common\models\base\OnboardModel;
use common\models\step\ApplicationIdentityProgressLog;
use common\models\step\Step;
use common\queries\step\ChainQuery;
use Yii;

/**
 * This is the model class for table "tbl_chain".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $next_chain_id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $continue_on_completion
 * @property integer $min_window_width
 * @property integer $max_window_width
 * @property integer $min_window_height
 * @property integer $max_window_height
 * @property integer $common_chain_id
 *
 * @property Chain $nextChain
 * @property Chain[] $chains
 * @property Page $page
 * @property User $createdBy
 * @property User $updatedBy
 * @property ChainRequirement[] $chainRequirements
 * @property ChainRequirement[] $chainRequirements0
 * @property Step[] $steps
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Chain extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%chain}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [[
                'next_chain_id',
                'page_id',
                'min_window_width',
                'max_window_width',
                'min_window_height',
                'max_window_height',
                'common_chain_id',
            ], 'integer'],
            [['name', 'page_id', 'continue_on_completion', 'common_chain_id'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['continue_on_completion'], 'boolean'],
            [['continue_on_completion'], 'default', 'value' => true],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_id' => Yii::t('app', 'Page ID'),
            'next_chain_id' => Yii::t('app', 'Next Chain ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'min_window_width' => Yii::t('app', 'Minimum Window Width'),
            'max_window_width' => Yii::t('app', 'Maximum Window Width'),
            'min_window_height' => Yii::t('app', 'Minimum Window Height'),
            'max_window_height' => Yii::t('app', 'Maximum Window height'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage() {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNextChain() {
        return $this->hasOne(Chain::className(), ['id' => 'next_chain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonChain() {
        return $this->hasOne(CommonChain::className(), ['id' => 'common_chain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviousChains() {
        return $this->hasMany(Chain::className(), ['next_chain_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentChainRequirements() {
        return $this->hasMany(ChainRequirement::className(), ['parent_chain_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildChainRequirements() {
        return $this->hasMany(ChainRequirement::className(), ['child_chain_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSteps() {
        return $this->hasMany(Step::className(), ['chain_id' => 'id']);
    }

    /**
     * Checks if a user has finished this chain.
     *
     * @param integer $application_identity_id The user to check.
     *
     * @return boolean The success of the check.
     */
    public function isFinished($application_identity_id) {
        return ApplicationIdentityProgressLog::find()->where([
            'common_chain_id' => $this->common_chain_id,
            'application_identity_id' => $application_identity_id,
            'state' => [
                ApplicationIdentityProgressLog::STATE_FINISHED_CHAIN,
                ApplicationIdentityProgressLog::STATE_SKIPPED_CHAIN,
            ]
        ])->exists();
    }

    /**
     * @inheritdoc
     * @return ChainQuery the active query used by this AR class.
     */
    public static function find() {
        return new ChainQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->page->application;
    }

}