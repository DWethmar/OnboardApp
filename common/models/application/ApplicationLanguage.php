<?php

namespace common\models\application;

use common\models\base\OnboardModel;
use common\queries\application\ApplicationLanguageQuery;
use Yii;

/**
 * This is the model class for table "tbl_application_language".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $code
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Application $application
 * @property User $createdBy
 * @property User $updatedBy
 * @property StepPartLanguage[] $stepPartLanguages
 * @property StepPart[] $stepParts
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationLanguage extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_language}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application_id', 'code', 'name'], 'required'],
            [['application_id'], 'integer'],
            [['code'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 32],
            [['application_id', 'code'], 'unique', 'targetAttribute' => ['application_id', 'code'], 'message' => 'The combination of Application ID and Code has already been taken.']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'application_id' => Yii::t('app', 'Application ID'),
            'code' => Yii::t('app', 'Code'),
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
    public function getApplication() {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepPartLanguages() {
        return $this->hasMany(StepPartLanguage::className(), ['application_language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepParts() {
        return $this->hasMany(StepPart::className(), ['id' => 'step_part_id'])->viaTable('tbl_step_part_language', ['application_language_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ApplicationLanguageQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApplicationLanguageQuery(get_called_class());
    }

}