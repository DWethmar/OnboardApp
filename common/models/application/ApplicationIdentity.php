<?php

namespace common\models\application;

use common\models\base\OnboardModel;
use common\models\step\ApplicationIdentityProgressLog;
use common\queries\application\ApplicationIdentityQuery;
use Yii;

/**
 * This is the model class for table "tbl_application_identity".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $name
 * @property string $identifier
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Application $application
 * @property User $createdBy
 * @property User $updatedBy
 * @property StepApplicationIdentity[] $stepApplicationIdentities
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationIdentity extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_identity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application_id', 'identifier'], 'required'],
            [['application_id'], 'integer'],
            [['name', 'identifier', 'email'], 'string', 'max' => 128]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'application_id' => Yii::t('app', 'Application ID'),
            'name' => Yii::t('app', 'Name'),
            'identifier' => Yii::t('app', 'Identifier'),
            'email' => Yii::t('app', 'Email'),
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
    public function getApplicationIdentityProgressLogs() {
        return $this->hasMany(ApplicationIdentityProgressLog::className(), ['application_identity_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ApplicationIdentityQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApplicationIdentityQuery(get_called_class());
    }

}