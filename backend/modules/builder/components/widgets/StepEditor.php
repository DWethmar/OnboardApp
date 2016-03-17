<?php

namespace backend\modules\builder\components\widgets;
use backend\models\step\ApplicationIdentityProgressLogSearch;

/**
 * Render Step editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class StepEditor extends BaseEditor {

    /**
     * @var string The name of the child relation.
     */
    public $child_relation_name = 'step_parts';

    /**
     * @var ApplicationIdentityProgressLogSearch The progress search model. Used to link to a search result.
     */
    public $progress_search_model;

    /** @inheritdoc */
    public function init() {
        parent::init();

        if (empty($this->progress_search_model)) {
            $this->progress_search_model = new ApplicationIdentityProgressLogSearch();
            $this->progress_search_model->step_id = $this->data['id'];
        }
    }

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('step_editor', [
            'data' => $this->data,
            'progress_search_model' => $this->progress_search_model
        ]);
    }

}