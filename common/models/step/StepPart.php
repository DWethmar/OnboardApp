<?php

namespace common\models\step;

use common\models\base\Application;
use common\models\base\OnboardModel;
use common\queries\step\StepPartQuery;
use Yii;

/**
 * This is the model class for table "{{%step_part}}".
 *
 * @property integer $id
 * @property integer $step_id
 * @property string $name
 * @property string $type
 * @property string $position
 * @property string $selector
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $show_next_step_controls
 * @property boolean $show_previous_step_controls
 * @property boolean $show_skip_chain_controls
 * @property integer $offset_x
 * @property integer $offset_y
 *
 * @property Step $step
 * @property StepPartType $type0
 * @property User $createdBy
 * @property User $updatedBy
 * @property StepPartLanguage[] $stepPartLanguages
 * @property ApplicationLanguage[] $applicationLanguages
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPart extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_part}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['step_id', 'name', 'type'], 'required'],
            [['step_id', 'offset_x', 'offset_y'], 'integer'],
            [['show_next_step_controls', 'show_previous_step_controls', 'show_skip_chain_controls'], 'boolean'],
            [['show_next_step_controls', 'show_previous_step_controls', 'show_skip_chain_controls'], 'default', 'value' => true],
            [['name'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 8],
            [['position'], 'string', 'max' => 16],
            [['selector'], 'string', 'max' => 1024]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'step_id' => Yii::t('app', 'Step ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'position' => Yii::t('app', 'Position'),
            'selector' => Yii::t('app', 'Selector'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'show_next_step_controls' => Yii::t('app', 'Show next step controls'),
            'show_previous_step_controls' => Yii::t('app', 'Show previous step controls'),
            'show_skip_chain_controls' => Yii::t('app', 'Show skip chain controls'),
            'offset_x' => Yii::t('app', 'Offset X'),
            'offset_y' => Yii::t('app', 'Offset Y'),
        ];
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
    public function getType0() {
        return $this->hasOne(StepPartType::className(), ['type' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition0() {
        return $this->hasOne(StepPartPosition::className(), ['position' => 'position']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepPartLanguages() {
        return $this->hasMany(StepPartLanguage::className(), ['step_part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationLanguages() {
        return $this->hasMany(ApplicationLanguage::className(), ['id' => 'application_language_id'])->viaTable('{{%step_part_language}}', ['step_part_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return StepPartQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepPartQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->step->application;
    }

}