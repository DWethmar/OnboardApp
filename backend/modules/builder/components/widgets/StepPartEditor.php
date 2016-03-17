<?php

namespace backend\modules\builder\components\widgets;

/**
 * Render Step Part editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepPartEditor extends BaseEditor {

    /**
     * @var string The name of the child relation.
     */
    public $child_relation_name = 'step_parts_languages';

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('step_part_editor', ['data' => $this->data]);
    }

}