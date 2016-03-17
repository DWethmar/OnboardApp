<?php

namespace backend\modules\builder\models;

use common\models\application\ApplicationLanguage;
use Yii;
use common\models\step\StepPart as StepPartBase;

/**
 * StepPart represents the model behind the editor form about `common\models\step\StepPart`.
 *
 * @property StepPartLanguage $stepPartLanguage
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPart extends StepPartBase {

    /**
     * @var StepPartLanguage The selected step part translation.
     */
    public $step_part_language;

    /** @inheritdoc */
    public function attributes() {
        return [
            'id',
            'step_id',
            'name',
            'type',
            'position',
            'selector',
            'show_next_step_controls',
            'show_previous_step_controls',
            'show_skip_chain_controls',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'offset_x',
            'offset_y',
        ];
    }

    /**
     * Getter for $step_part_language;
     *
     * @return StepPartLanguage The value.
     */
    public function getStepPartLanguage() {
        if (empty($this->step_part_language)) {
            $this->setTranslation();
        }
        return $this->step_part_language;
    }

    /** @inheritdoc */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            $step_part_language = new StepPartLanguage();
            $step_part_language->load(Yii::$app->request->post());

            if (!$insert) { // Check if new or exists
                $existing_step_part_language = StepPartLanguage::find()->where([
                    'step_part_id' => $step_part_language->step_part_id,
                    'application_language_id' => $step_part_language->application_language_id
                ])->one();
                if (!empty($existing_step_part_language)) {
                    $existing_step_part_language->load(Yii::$app->request->post()); // Apply new values.
                    $step_part_language = $existing_step_part_language;
                }
            }

            $this->step_part_language = $step_part_language;
            return true;
        } else {
            return false;
        }

    }

    /**
     * Set a new StepPartLanguage if there is no translation available.
     *
     * return void
     */
    protected function setTranslation() {
        $application = $this->step->chain->page->application;
        $application_language = ApplicationLanguage::find()->where([
            'application_id' => $application->id
        ])->one();

        if (empty($application_language)) {
            return;
        }

        $step_part_language = StepPartLanguage::find()->where([
            'step_part_id' => $this->id,
            'application_language_id' => $application_language->id
        ])->one();

        if (empty($step_part_language)) {
            $step_part_language = new StepPartLanguage();
            $step_part_language->step_part_id = $this->id;
            $step_part_language->application_language_id = $application_language->id;
        }

        $this->step_part_language = $step_part_language;
    }

    /** @inheritdoc */
    public function save($runValidation = true, $attributeNames = null) {
        if ($runValidation && !$this->validate()) {
            return false;
        }
        if (parent::save()) {
            // Save translation.
            if (!empty($this->step_part_language)) {
                $step_part_language = $this->step_part_language;
                $step_part_language->step_part_id = $this->id; // Just to be sure.
                if (($runValidation && $step_part_language->validate()) && $step_part_language->save()) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

}