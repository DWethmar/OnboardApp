<?php

namespace common\models\application;

use common\models\base\BaseModel;
use common\models\Tenant;
use common\queries\application\ApplicationQuery;

/**
 * This is the model class for table "{{%application}}".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $access_key
 * @property string  $base_url
 * @property integer $default_application_language_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $tenant_id
 *
 * @property Tenant $tenant
 * @property User $createdBy
 * @property User $updatedBy
 * @property ApplicationIdentity[] $applicationIdentities
 * @property ApplicationLanguage[] $applicationLanguages
 * @property Page[] $pages
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Application extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['name', 'access_key', 'tenant_id'], 'required'],
            [['tenant_id', 'default_application_language_id'], 'integer'],
            [['access_key'], 'unique'],
            [['name'], 'string', 'max' => 32],
            [['access_key'], 'string', 'max' => 8],
            [['base_url'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'access_key' => 'Access Key',
            'base_url' => 'base Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'tenant_id' => 'Tenant ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenant() {
        return $this->hasOne(Tenant::className(), ['id' => 'tenant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationIdentities() {
        return $this->hasMany(ApplicationIdentity::className(), ['application_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationLanguage() {
        return $this->hasOne(ApplicationLanguage::className(), ['id' => 'default_application_language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationLanguages() {
        return $this->hasMany(ApplicationLanguage::className(), ['application_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationVersions() {
        return $this->hasMany(ApplicationVersion::className(), ['application_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages() {
        return $this->hasMany(Page::className(), ['application_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\queries\application\ApplicationQuery the active query used by this AR class.
     */
    public static function find() {
        return new ApplicationQuery(get_called_class());
    }

}