<?php

namespace common\models\step;

use common\models\base\BaseModel;
use common\queries\step\StepPartTypeQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%step_part_type}}".
 *
 * @property string $type
 * @property string $full_name
 *
 * @property StepPart[] $stepParts
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartType extends ActiveRecord {

    /**
     * @var string The default type value.
     */
    const DEFAULT_TYPE = 'default';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_part_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 8],
            [['full_name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepParts() {
        return $this->hasMany(StepPart::className(), ['type' => 'type']);
    }

    /**
     * @return StepType The default stepType.
     */
    public static function getDefaultType() {
        $type = static::find()->where(['type' => static::DEFAULT_TYPE])->one();
        if (empty($type)) {
            $type = new static();
            $type->type = static::DEFAULT_TYPE;
            $type->save();
        }
        return $type;
    }

    /**
     * @inheritdoc
     * @return StepPartTypeQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepPartTypeQuery(get_called_class());
    }

}