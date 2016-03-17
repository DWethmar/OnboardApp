<?php

namespace backend\modules\builder\models;

use common\models\application\ApplicationVersion;
use Yii;
use common\models\application\Page as PageBase;

/**
 * Page represents the model behind the search form about `common\models\application\Page`.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class Page extends PageBase {

    /**
     * @var string The application version.
     */
    public $application_version;

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            'id',
            'name',
            'application_id',
            'application_version_id',
            'url',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'ignore_url_query',
        ];
    }

    /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (empty($this->application_version_id)) {
                $application_version = ApplicationVersion::find()->byStringVersion($this->application_id, $this->application_version)->one();
                $this->application_version_id = $application_version->id;
            }
            return true;
        }
    }

    /**
     * Check access violation for application.
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     * @return void
     */
    public function checkAccess($attribute, $params) {
        if (!Application::find()->checkAccess(Yii::$app->user->id)->exists()) {
            $this->addError($attribute, Yii::t('app', 'ACCESS_VIOLATION'));
        }
    }

}