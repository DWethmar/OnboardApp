<?php

namespace common\models\base;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Defines commonly used methods. Merge other
 * behaviours with the BaseModel behaviours.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
abstract class BaseModel extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return  [
            [['created_at', 'updated_at', 'created_by', 'updated_by', ], 'integer'],
            [['created_at', 'updated_at'], 'required', 'when' => function($model) {
                return !$model->isNewRecord;
            }],
        ];
    }

    /**
     * @return string The formatted created_at attribute.
     */
    public function getCreatedDateTime() {
        return date('d-m-y H:i:s', $this->created_at);
    }

    /**
     * @return string The formatted created_at attribute.
     */
    public function getUpdatedDateTime() {
        return date('d-m-y  H:i:s', $this->updated_at);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

}