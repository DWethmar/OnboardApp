<?php

namespace common\models\translation;

use common\queries\translation\SourceMessageQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\swiftmailer\Message;

/**
 * This is the model class for table "tbl_source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class SourceMessage extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbl_source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'message' => 'Message',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages() {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\queries\SourceMessageQuery the active query used by this AR class.
     */
    public static function find() {
        return new SourceMessageQuery(get_called_class());
    }

}