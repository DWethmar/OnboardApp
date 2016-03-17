<?php

namespace common\models\step;

use common\models\base\Application;
use common\models\base\OnboardModel;
use common\queries\step\StepPartLanguageQuery;
use Yii;

/**
 * This is the model class for table "{{%step_part_language}}".
 *
 * @property integer $step_part_id
 * @property integer $application_language_id
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string  $title
 *
 * @property ApplicationLanguage $applicationLanguage
 * @property StepPart $stepPart
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguage extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_part_language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['step_part_id', 'application_language_id', 'value'], 'required'],
            [['step_part_id', 'application_language_id'], 'integer'],
            [['value', 'title'], 'string']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'step_part_id' => Yii::t('app', 'Step Part ID'),
            'application_language_id' => Yii::t('app', 'Application Language ID'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationLanguage() {
        return $this->hasOne(ApplicationLanguage::className(), ['id' => 'application_language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepPart() {
        return $this->hasOne(StepPart::className(), ['id' => 'step_part_id']);
    }

    /**
     * @inheritdoc
     * @return StepPartLanguageQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepPartLanguageQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->stepPart->application;
    }

}