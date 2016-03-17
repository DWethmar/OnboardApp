<?php

namespace backend\modules\builder\components\widgets;

/**
 * Render Application editor.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ApplicationEditor extends BaseEditor {

    /**
     * @var string The name of the child relation.
     */
    public $child_relation_name = 'pages';

    /**
     * @var string The application version as string. Example: 1.0.0
     */
    private $_version;

    public function init() {
        parent::init();
        $this->_version = $this->data['version']['major_version'] . '.' . $this->data['version']['minor_version'] . '.' . $this->data['version']['patch_version'];
    }

    /** @inheritdoc */
    public function run() {
        return empty($this->data) ? '' : $this->render('application_editor', [
            'version' => $this->_version,
            'data' => $this->data
        ]);
    }

}