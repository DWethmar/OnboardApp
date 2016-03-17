<?php

namespace backend\modules\builder\models;


use common\components\utilities\ActiveRecordUtil;
use common\components\utilities\ChainUtil;
use common\models\step\CommonStep;
use Yii;
use common\models\step\Step as StepBase;

/**
 * Step represents the model behind the editor form about `common\models\step\Step`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Step extends StepBase {

    /**
     * @var bool Create a new common step.
     */
    public $new_common_step = true;

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            'id',
            'chain_id',
            'sequence',
            'highlight',
            'type',
            'name',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'show',
            'common_step_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'name'], 'required'],
            [['highlight', 'show'], 'boolean'],
            [['common_step_id'], 'integer'],
            [['type'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepParts() {
        return $this->hasMany(StepPart::className(), ['step_id' => 'id']);
    }

    /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (empty($this->common_step_id) && $this->new_common_step) {
                $common_step = new CommonStep();
                $common_step->application_id = $this->application->id;
                if ($common_step->save()) {
                    $this->common_step_id = $common_step->id;
                } else {
                    throw new Exception('Could not link common step!');
                }
            }
            return true;
        }
    }

    /**
     * This method is called at the beginning of inserting or updating a record.
     *
     * @param bool $insert is insert save.
     * @return boolean Whether the insertion or updating should continue.
     * If false, the insertion or updating will be cancelled.
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (empty($this->sequence)) {
                $this->sequence = Step::getHighestSequence($this->chain_id) + 1;
            }
            return true;
        } else {
            return false;
        }
    }

}
