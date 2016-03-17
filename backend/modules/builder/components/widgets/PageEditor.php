<?php

namespace backend\modules\builder\components\widgets;

/**
 * Render Page editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class PageEditor extends BaseEditor {

    /**
     * @var string The name of the child relation.
     */
    public $child_relation_name = 'chains';

    /** @inheritdoc */
    public function init() {
        parent::init();
        // Order Chains on Next chain id.
        usort($this->data[$this->child_relation_name], function($a, $b) {
            if ($a['next_chain_id'] == 0) return 1;
            if ($b['next_chain_id'] == 0) return -1;

            if ($a['id'] == $b['next_chain_id']) return 1;
            if ($b['id'] == $a['next_chain_id']) return -1;
            return 0;
        });
    }

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('page_editor', ['data' => $this->data]);
    }

}