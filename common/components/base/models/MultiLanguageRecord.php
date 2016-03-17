<?php
namespace common\components\base\models;

/**
 * Trait for the multi language ActiveRecords.
 *
 * @author Jap Mul <jap@branchonline.nl>
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
trait MultiLanguageRecord {

    /**
     * @var LanguageModelInterface The language model.
     */
    protected $_lang;

    /**
     * Returns the language model for this object.
     *
     * @return LanguageModelInterface The language model.
     */
    public function getLang() {
        if (!empty($this->_lang)) {
            return $this->_lang;
        } else if (empty($this->language)) {
            $model_class = $this->getLanguageModelName();
            return new $model_class();
        } else {
            return $this->language;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage() {
        $model_name = $this->getLanguageModelName();
        return $this->hasOne($model_name, [
            $model_name::getForeignKeyToMainModel() => 'id'
        ])->where([
            'application_language_id' => $this->getSelectedLanguageId()
        ]);
    }

    /**
     * Implementations should return selected application Language id.
     *
     * @return integer The application language id.
     */
    protected abstract function getSelectedLanguageId();

    /**
     * Sets the language model.
     *
     * @param LanguageModelInterface $language_model The language model.
     *
     * @return void
     */
    public function setLang(LanguageModelInterface $language_model) {
        $this->_lang = $language_model;
    }

    /**
     * Implementations should return the language model class.
     *
     * @return string the model name.
     */
    protected abstract static function getLanguageModelName();

}