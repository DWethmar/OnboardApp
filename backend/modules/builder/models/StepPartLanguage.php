<?php

namespace backend\modules\builder\models;

use common\components\interfaces\LanguageModelInterface;
use Yii;
use common\models\step\StepPartLanguage as StepPartLanguageBase;

/**
 * StepPartLanguage represents the model behind the editor form about `common\models\step\StepPartLanguage`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguage extends StepPartLanguageBase {

    /** @inheritdoc */
    public function attributes() {
        return [
            'step_part_id',
            'application_language_id',
            'title',
            'value',
            'selector',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'application',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['step_part_id', 'application_language_id', 'value'], 'required'],
            [['step_part_id', 'application_language_id'], 'integer'],
            [['value', 'title'], 'string'],
        ];
    }

}