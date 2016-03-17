<?php

namespace backend\modules\builder\components\widgets;
use yii\base\Widget;

/**
 * Base Editor widget.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
abstract class BaseEditor extends Widget {

    /**
     * the data to be use to render the editor.
     *
     * @see \backend\modules\builder\components\utilities\ApplicationUtil::getApplicationTree
     * @var array The Editor data.
     */
    public $data = [];

    /**
     * @var string The name of the child relation.
     * It needs to be empty, so we can set the children relation index.
     */
    public $child_relation_name;

    /** @inheritdoc */
    public function init() {
        if (!empty($this->child_relation_name) && empty($this->data[$this->child_relation_name])) {
            $this->data[$this->child_relation_name] = [];
        }
    }

}