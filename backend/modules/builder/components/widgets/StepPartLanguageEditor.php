<?php

namespace backend\modules\builder\components\widgets;

/**
 * Render Step Part Langauge editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartLanguageEditor extends BaseEditor {

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('step_part_language_editor', ['data' => $this->data]);
    }

}