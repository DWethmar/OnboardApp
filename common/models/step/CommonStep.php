<?php

namespace common\models\step;

use common\models\application\Application;
use common\models\base\OnboardModel;
use common\queries\step\CommonStepQuery;
use Yii;

/**
 * This is the model class for table "{{%common_step}}".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $code
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ApplicationIdentityProgressLog[] $applicationIdentityProgressLogs
 * @property Application $application
 * @property User $createdBy
 * @property User $updatedBy
 * @property Step[] $steps
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class CommonStep extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%common_step}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application_id', 'code'], 'required'],
            [['application_id'], 'integer'],
            [['code'], 'string', 'max' => 16],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationIdentityProgressLogs() {
        return $this->hasMany(ApplicationIdentityProgressLog::className(), ['common_step_id' => 'id']);
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
    public function getSteps() {
        return $this->hasMany(Step::className(), ['common_step_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CommonStepQuery the active query used by this AR class.
     */
    public static function find() {
        return new CommonStepQuery(get_called_class());
    }


    /**
     * Set random string for code if empty.
     */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (empty($this->code)) {
                $this->setCode();
            }
            return true;
        }
    }

    /**
     * Set new unique code
     */
    public function setCode() {
        do {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 16; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $this->code = $randomString;
        } while(CommonStep::find()->where(['code' => $this->code])->exists());
    }

}