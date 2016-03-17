<?php

namespace backend\modules\builder\components\widgets;
use backend\models\step\ApplicationIdentityProgressLogSearch;

/**
 * Render Chain editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ChainEditor extends BaseEditor {

    /**
     * @var string The name of the child relation.
     */
    public $child_relation_name = 'steps';

    /**
     * @var ApplicationIdentityProgressLogSearch The progress search model. Used to link to a search result.
     */
    public $progress_search_model;

    /** @inheritdoc */
    public function init() {
        parent::init();

        // Order steps on sequence.
        usort($this->data[$this->child_relation_name], function($a, $b) {
            return $a['sequence'] - $b['sequence'];
        });

        if (empty($this->progress_search_model)) {
            $this->progress_search_model = new ApplicationIdentityProgressLogSearch();
            $this->progress_search_model->chain_id = $this->data['id'];
        }
    }

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('chain_editor', [
            'data' => $this->data,
            'progress_search_model' => $this->progress_search_model
        ]);
    }

}