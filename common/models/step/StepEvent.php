<?php

namespace common\models\step;

use common\models\base\Application;
use common\models\base\OnboardModel;
use common\queries\step\StepEventQuery;
use Yii;

/**
 * This is the model class for table "{{%step_event}}".
 *
 * @property integer $id
 * @property integer $step_id
 * @property string $name
 * @property string $type
 * @property string $action
 * @property string $event
 * @property string $selector
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Step        $step
 * @property User        $createdBy
 * @property User        $updatedBy
 * @property Application $application
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEvent extends OnboardModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%step_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['step_id', 'name', 'type', 'action', 'event'], 'required'],
            [['step_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['type', 'action'], 'string', 'max' => 16],
            [['event'], 'string', 'max' => 64],
            [['selector'], 'string', 'max' => 1024]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'step_id' => Yii::t('app', 'Step ID'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'action' => Yii::t('app', 'Action'),
            'event' => Yii::t('app', 'Event'),
            'selector' => Yii::t('app', 'Selector'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStep() {
        return $this->hasOne(Step::className(), ['id' => 'step_id']);
    }

    /**
     * @inheritdoc
     * @return StepEventQuery the active query used by this AR class.
     */
    public static function find() {
        return new StepEventQuery(get_called_class());
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    function getApplication() {
        return $this->step->application;
    }

}
