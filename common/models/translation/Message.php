<?php

namespace common\models;

use common\models\translation\SourceMessage;
use common\queries\MessageQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property SourceMessage $id0
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Message extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'language', 'translation'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'language' => 'Language',
            'translation' => 'Translation',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getId0() {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find() {
        return new MessageQuery(get_called_class());
    }

}