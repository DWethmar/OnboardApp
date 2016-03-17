<?php

namespace common\models;

use common\models\application\Application;
use common\models\base\BaseModel;
use common\queries\TenantQuery;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%tenant}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property User[] $users
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Tenant extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%tenant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['tenant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications() {
        return $this->hasMany(Application::className(), ['tenant_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TenantQuery the active query used by this AR class.
     */
    public static function find() {
        return new TenantQuery(get_called_class());
    }

}