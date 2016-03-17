<?php

namespace common\models\step;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%step_event_action}}".
 *
 * @property string $action
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEventAction extends ActiveRecord {

    /* @var string The next action name */
    const ACTION_NEXT     = 'next';
    /* @var string The previous action name */
    const ACTION_PREVIOUS = 'previous';
    /* @var string The show action name */
    const ACTION_SHOW     = 'show';
    /* @var string The hide action name */
    const ACTION_HIDE     = 'hide';
    /* @var string The finish action name */
    const ACTION_FINISH   = 'finish';
    /* @var string The skip action name */
    const ACTION_SKIP     = 'skip';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_event_action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['action'], 'required'],
            [['action'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'action' => Yii::t('app', 'Action'),
        ];
    }

    /**
     * Get all Actions
     *
     * @return array Collection of all Step Event Actions.
     */
    public static function getAllActions() {
        return [
            static::ACTION_NEXT,
            static::ACTION_PREVIOUS,
            static::ACTION_SHOW,
            static::ACTION_HIDE,
            static::ACTION_FINISH,
            static::ACTION_SKIP,
        ];
    }

}
