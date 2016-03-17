<?php
namespace common\components\interfaces;

/**
 * The interface for language models.
 *
 * @author Jap Mul <jap@branchonline.nl>
 */
interface LanguageModelInterface {

    /**
     * Returns the column to the main record.
     *
     * @return string
     */
    public static function getForeignKeyToMainModel();

    /**
     * Returns the column to the language record.
     *
     * @return string
     */
    public static function getForeignKeyToLanguageModel();

}