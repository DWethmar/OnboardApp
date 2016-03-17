<?php

namespace common\models\step;

use common\queries\step\StepTypeQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%step_type}}".
 *
 * @property string $type
 *
 * @property Step[] $steps
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepType extends ActiveRecord {

    const DEFAULT_TYPE = 'default';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 8]
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
    public function getSteps() {
        return $this->hasMany(Step::className(), ['type' => 'type']);
    }

    /**
     * @return StepType The default stepType.
     */
    public static function getDefaultType() {
        $type = StepType::find()->where(['type' => static::DEFAULT_TYPE])->one();
        if (empty($type)) {
            $type = new StepType();
            $type->type = static::DEFAULT_TYPE;
            $type->save();
        }
        return $type;
    }

    /**
     * @inheritdoc
     * @return StepTypeQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepTypeQuery(get_called_class());
    }

}