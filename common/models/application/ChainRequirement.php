<?php

namespace common\models\application;

use common\models\base\BaseModel;
use common\queries\step\ChainQuery;
use Yii;

/**
 * This is the model class for table "{{%chain_requirement}}".
 *
 * @property integer $parent_chain_id
 * @property integer $child_chain_id
 *
 * @property Chain $parentChain
 * @property Chain $childChain
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainRequirement extends BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%chain_requirement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_chain_id', 'child_chain_id'], 'required'],
            [['parent_chain_id', 'child_chain_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'parent_chain_id' => Yii::t('app', 'Parent Chain ID'),
            'child_chain_id' => Yii::t('app', 'Child Chain ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentChain() {
        return $this->hasOne(Chain::className(), ['id' => 'parent_chain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildChain() {
        return $this->hasOne(Chain::className(), ['id' => 'child_chain_id']);
    }

    /**
     * @inheritdoc
     * @return ChainQuery the active query used by this AR class.
     */
    public static function find() {
        return new ChainQuery(get_called_class());
    }

}