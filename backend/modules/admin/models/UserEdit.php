<?php

namespace backend\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserEdit represents the model behind the edit form about `common\models\User`.
 *
 * @author Dennnis Wethmar <dennis@branchonline.nl>
 */
class UserEdit extends User {

    /** @var string The new password for this user. */
    public $new_password;
    /** @var string The new repeated password for this user. */
    public $new_password_repeat;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['new_password', 'new_password_repeat'], 'string'],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password'],
            [['new_password', 'new_password_repeat'], 'string', 'min' => 6],
        ]);
    }

    /**
     * @inheritdoc
     */
    function beforeValidate() {
        if (parent::beforeValidate()) {
            if (!empty($this->new_password)) {
                $this->setPassword($this->new_password);
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

}