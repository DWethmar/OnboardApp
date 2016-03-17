<?php
namespace backend\modules\builder\models;

use common\models\steps\StepEvent as BaseStepEvent;
use Yii;

/**
 * This is the designer model  for table "{{%step_event}}".
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEvent extends BaseStepEvent {

    /** @inheritdoc */
    public function attributes() {
        return [
            'id',
            'name',
            'step_id',
            'name',
            'type',
            'action',
            'selector',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by'
        ];
    }

}
