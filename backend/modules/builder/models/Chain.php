<?php

namespace backend\modules\builder\models;

use common\models\application\CommonChain;
use common\models\step\StepPartPosition;
use common\models\step\StepPartType;
use common\models\step\StepType;
use Yii;
use common\models\application\Chain as ChainBase;
use yii\base\Exception;

/**
 * Chain represents the model behind the editor form about `common\models\application\Chain`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Chain extends ChainBase {

    /**
     * @var bool Create a step on insert.
     */
    public $create_step = true;

    /**
     * @var bool Create a new common chain.
     */
    public $new_common_chain = true;

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            'id',
            'page_id',
            'next_chain_id',
            'name',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'create_step',
            'continue_on_completion',
            'min_window_width',
            'max_window_width',
            'min_window_height',
            'max_window_height',
            'common_chain_id'
        ];
    }

    /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (empty($this->common_chain_id) && $this->new_common_chain) {
                $common_chain = new CommonChain();
                $common_chain->application_id = $this->application->id;
                if ($common_chain->save()) {
                    $this->common_chain_id = $common_chain->id;
                } else {
                    throw new Exception('Could not link common chain');
                }
            }
            return true;
        }
    }

    /**
     * Create default step and step part.
     *
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert && $this->create_step) {
            $step = new Step();
            $step->chain_id = $this->id;
            $step->sequence = 1;
            $step->type = StepType::getDefaultType()->type;
            $step->name = Yii::t('app', 'Step #{sequence} for Chain: {chain_name}', [
                'sequence' => $step->sequence,
                'chain_name' => $this->name,
            ]);

            if ($step->save()) {
                $step_part = new StepPart();
                $step_part->step_id = $step->id;
                $step_part->type = StepPartType::getDefaultType()->type;
                $step_part->position = StepPartPosition::DEFAULT_POSITION;
                $step_part->selector = 'body';
                $step_part->name = Yii::t('app', 'Step-part for Step #{step_sequence}', [
                    'step_sequence' => $step->sequence,
                ]);
                $step_part->stepPartLanguage->value = 'empty';
                $step_part->save();
            }
        }
    }

}