<?php

namespace common\models\application;

use common\models\base\OnboardModel;
use common\models\User;
use common\queries\application\PageQuery;
use Yii;

/**
 * This is the model class for table "tbl_page".
 *
 * @property integer $id
 * @property string $name
 * @property integer $application_id
 * @property integer $application_version_id
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $ignore_url_query
 *
 * @property Application $application
 * @property User $createdBy
 * @property User $updatedBy
 * @property Step[] $steps
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Page extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['name', 'application_id', 'application_version_id', 'url', 'ignore_url_query'], 'required'],
            [['application_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['url'], 'string', 'max' => 1024],
            [['ignore_url_query'], 'required'],
            [['ignore_url_query'], 'default', 'value' => true],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'application_id' => Yii::t('app', 'Application ID'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ignore_url_query' => Yii::t('app', 'Ignore URL query'),
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
    public function getApplicationVersion() {
        return $this->hasOne(ApplicationVersion::className(), ['id' => 'application_version_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChains() {
        return $this->hasMany(Chain::className(), ['page_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find() {
        return new PageQuery(get_called_class());
    }

}