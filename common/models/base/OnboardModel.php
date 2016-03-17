<?php

namespace common\models\base;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Defines Onboard specific model logic and data. For a Basic model
 * logic use baseModel.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
abstract class OnboardModel extends BaseModel {

    /** @inheritdoc */
    public function rules() {
        return array_merge(parent::rules(), [
            [['application'], 'safe']
        ]);
    }

    /**
     * The getter for $application.
     *
     * @return Application The application linked to this model.
     */
    abstract function getApplication();

}