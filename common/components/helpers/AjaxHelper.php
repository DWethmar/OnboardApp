<?php
namespace common\components\helpers;

use Yii;
use yii\web\Response;

/**
 * The AjaxHelper is meant to be used to simplify common Ajax tasks.
 *
 * @author Jap Mul <jap@branchonline.nl>
 */
class AjaxHelper {

    /**
     * @var string The status invalid key.
     */
    const STATUS_INVALID = 'invalid';
    /**
     * @var string The status success key.
     */
    const STATUS_SUCCESS = 'success';
    /**
     * @var string The status failed key.
     */
    const STATUS_FAILED = 'failed';

    /**
     * Sets the format to JSON and checks if the data is an array.
     *
     * @param array $data The data collection.
     *
     * @return array The data collection.
     */
    public static function response(array $data) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    /**
     * Gives a success response. Extra key-value pairs can be added with
     * the $data parameter.
     *
     * @param array $data Some optional extras to be added to the response data.
     *
     * @return array all key-value pairs
     */
    public static function success(array $data = []) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array_merge([
            'status' => static::STATUS_SUCCESS,
        ], $data);
    }

    /**
     * Gives a failed response. Extra key-value pairs can be added with
     * the $data parameter.
     *
     * @param array $data Some optional extras to be added to the response data.
     *
     * @return array all key-value pairs
     */
    public static function failed(array $data = []) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array_merge([
            'status' => static::STATUS_FAILED,
        ], $data);
    }

    /**
     * Gives an invalid data response. Extra key-value pairs can be added with
     * the $data parameter.
     *
     * @param array $data Some optional extras to be added to the response data.
     *
     * @return array all key-value pairs
     */
    public static function invalid(array $data = []) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array_merge([
            'status' => static::STATUS_INVALID,
        ], $data);
    }

    /**
     * Renders ajax content with script/css registration.
     *
     * @param string $content The page content.
     *
     * @return string The complete output.
     */
    public static function render($content) {
        $view = Yii::$app->getView();
        ob_start();
        ob_implicit_flush(false);
        $view->beginPage();
        $view->head();
        $view->beginBody();
        echo $content;
        $view->endBody();
        $view->endPage(true);
        return ob_get_clean();
    }

}