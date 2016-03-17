<?php

namespace common\components\utilities;

use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;

/**
 * This util handles generic model logic.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class ActiveRecordUtil extends Object {

    /**
     * Save Active records in transaction.
     *
     * @param array $models Models to save.
     * @return boolean The success of the transaction.
     */
    public static function saveModelsInTransaction(array $models) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($models as $model) {
                if ($model instanceof ActiveRecord) {
                    $model->save();
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }

}
