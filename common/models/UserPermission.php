<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * User permissions model
 *
 * @const string MANAGE_TENANTS
 * @const string MANAGE_APPLICATIONS
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class UserPermission extends model {

    /** @var string The permission name for editing Tenant. */
    const MANAGE_TENANTS = 'manage_tenants';

    /** @var string The permission name for editing Applications. */
    const MANAGE_APPLICATIONS = 'manage_applications';

}
