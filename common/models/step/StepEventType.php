<?php

namespace common\models\step;

use common\queries\step\StepEventTypeQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_step_event_type".
 *
 * @property string $type
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEventType extends ActiveRecord {

    /* @var string Listener type */
    const TYPE_LISTENER = 'listener';

    /* @var string Trigger type */
    const TYPE_TRIGGER =  'trigger';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_event_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 16]
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
     * Get all Types
     *
     * @return array Collection of all Step Event Types.
     */
    public static function getAllTypes() {
        return [
            static::TYPE_LISTENER,
            static::TYPE_TRIGGER,
        ];
    }
}
