<?php

namespace common\models\step;

use common\models\base\BaseModel;
use common\queries\step\StepPartTypeQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%step_part_position}}".
 *
 * @property string $position
 * @property string $full_name
 *
 * @property StepPart[] $stepParts
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartPosition extends ActiveRecord {

    /** @var string The default type value. */
    const DEFAULT_POSITION      = 'top';

    /** @var string The middle value. */
    const MIDDLE_POSITION       = 'middle';

    /** @var string The top value. */
    const TOP_POSITION          = 'top';

    /** @var string The top right value. */
    const TOP_RIGHT_POSITION    = 'top-right';

    /** @var string The right value. */
    const RIGHT_POSITION        = 'right';

    /** @var string The top left value. */
    const BOTTOM_RIGHT_POSITION = 'bottom-right';

    /** @var string The bottom value. */
    const BOTTOM_POSITION       = 'bottom';

    /** @var string The bottom left value. */
    const BOTTOM_LEFT_POSITION  = 'bottom-left';

    /** @var string The left value. */
    const LEFT_POSITION         = 'left';

    /** @var string The top left value. */
    const TOP_LEFT_POSITION     = 'top-left';

    /** @inheritdoc */
    public static function tableName() {
        return '{{%step_part_position}}';
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['position'], 'required'],
            [['position'], 'string', 'max' => 16],
            [['full_name'], 'string', 'max' => 32]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'position' => Yii::t('app', 'Position'),
            'full_name' => Yii::t('app', 'Full Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepParts() {
        return $this->hasMany(StepPart::className(), ['position' => 'position']);
    }

    /**
     * @return StepPartPosition The default StepPartPosition.
     */
    public static function getDefaultPosition() {
        $position = static::find()->where(['position' => static::DEFAULT_POSITION])->one();
        if (empty($position)) {
            $position = new static();
            $position->type = static::DEFAULT_POSITION;
            $position->save();
        }
        return $position;
    }

    /**
     * @inheritdoc
     * @return StepPartTypeQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepPartTypeQuery(get_called_class());
    }

    /** @return array All positions. */
    public static function getAllPosition() {
        return [
            static::MIDDLE_POSITION,
            static::TOP_POSITION,
            static::TOP_RIGHT_POSITION,
            static::RIGHT_POSITION,
            static::BOTTOM_RIGHT_POSITION,
            static::BOTTOM_POSITION,
            static::BOTTOM_LEFT_POSITION,
            static::LEFT_POSITION,
            static::TOP_LEFT_POSITION,
        ];
    }

}
