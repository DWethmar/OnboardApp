<?php

namespace common\models\application;

use common\models\base\OnboardModel;
use common\queries\application\ApplicationVersionQuery;
use Yii;

/**
 * This is the model class for table "{{%application_version}}".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $name
 * @property integer $major_version
 * @property integer $minor_version
 * @property integer $patch_version
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Application $application
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationVersion extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_version}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application_id', 'name'], 'required'],
            [['application_id', 'major_version', 'minor_version', 'patch_version'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['application_id', 'major_version', 'minor_version', 'patch_version'], 'unique', 'targetAttribute' => ['application_id', 'major_version', 'minor_version', 'patch_version'], 'message' => 'The combination of Application ID, Major Version, Minor Version and Patch Version has already been taken.']
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
            'major_version' => Yii::t('app', 'Major Version'),
            'minor_version' => Yii::t('app', 'Minor Version'),
            'patch_version' => Yii::t('app', 'Patch Version'),
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
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     * @return ApplicationVersionQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApplicationVersionQuery(get_called_class());
    }

    /**
     * @return string The version as string.
     */
    public function getVersion() {
        return $this->major_version . '.' . $this->minor_version . '.' . $this->patch_version;
    }

}