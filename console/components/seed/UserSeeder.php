<?php

namespace console\components\seed;

use common\models\Tenant;
use common\models\User;
use common\models\UserPermission;
use frontend\models\SignupForm;
use Yii;
use yii\helpers\Console;

/**
 * Seed System with SYSTEM users.
 *
 * @author Dennis Wethmar <dennis@branchonline.nl>
 */
class UserSeeder {

    /**
     * Start  seeding user.
     *
     * @return void
     */
    public static function go() {
        $user = self::_insertUserAndtentant();
        self::_initRBAC($user);
    }

    /**
     * Create Default user and tenant.
     *
     * @return User the newly created system user.
     */
    private function _insertUserAndtentant() {
        echo "\n----------------------------------------\n";
        echo Console::ansiFormat('Seeding default user & tenant', [Console::FG_CYAN]);
        echo "\n----------------------------------------\n";

        $system_tenant = Tenant::find()->where(['name' => 'SYSTEM'])->one();
        if (empty($system_tenant)) {
            $system_tenant = new Tenant();
            $system_tenant->name = 'SYSTEM';
            $system_tenant->save();
        } else {
            $log = Console::ansiFormat('SYSTEM', [Console::FG_RED]);
            echo "\nSystem Tenant already exist: $log \n";
        }
        $user_exists = User::find()->where(['username' => 'SYSTEM'])->exists();
        if ($user_exists) {
            $log = Console::ansiFormat('SYSTEM', [Console::FG_RED]);
            echo "\nSystem User already exist: $log \n";
        } else {
            $system_sign_up = new SignupForm();
            $system_sign_up->username = 'SYSTEM';
            $system_sign_up->email = 'no-reply@test.nl';
            $system_sign_up->password = 'system';
            $system_sign_up->tenant_id = $system_tenant->id;
            if (!$system_sign_up->signup()) {
                echo Console::ansiFormat('Error has occurred while saving the user!', [Console::FG_RED]) . "\n";
                if (count($system_tenant->errors)) {
                    print_r($system_tenant->errors);
                }
                return null;
            } else {
                $credentials = Console::ansiFormat('SYSTEM/system', [Console::FG_YELLOW]);
                echo "\nSystem user created (Login: $credentials) \n";
            }
        }

        return User::find()->where(['username' => 'SYSTEM'])->one();
    }


    /**
     * Initialize RBAC.
     *
     * @param User $system_user The user to add RBAC to.
     *
     * @return void
     */
    private function _initRBAC(User $system_user) {
        $auth = Yii::$app->authManager;

        echo "\n----------------------------------------\n";
        echo Console::ansiFormat('Seeding RBAC', [Console::FG_CYAN]);
        echo "\n----------------------------------------\n";

        // Create Application permission
        $manage_app = $auth->getPermission(UserPermission::MANAGE_APPLICATIONS);
        if ($manage_app == null) {
            $manage_apps = $auth->createPermission(UserPermission::MANAGE_APPLICATIONS);
            $manage_apps->description = 'Global permission for editing Applications within Onboard';
            $auth->add($manage_apps);
            $manage_app = $auth->getPermission(UserPermission::MANAGE_APPLICATIONS);

            $log = Console::ansiFormat(UserPermission::MANAGE_APPLICATIONS, [Console::FG_GREEN]);
            echo "\nCreated permission: $log \n";
        } else {
            $log = Console::ansiFormat(UserPermission::MANAGE_APPLICATIONS, [Console::FG_RED]);
            echo "\nPermission already exist: $log \n";
        }

        // Create Tenant permission
        $manage_tenants = $auth->getPermission(UserPermission::MANAGE_TENANTS);
        if ($manage_tenants == null) {
            $manage_tenants = $auth->createPermission(UserPermission::MANAGE_TENANTS);
            $manage_tenants->description = 'Global permission for editing Tenants within Onboard';
            $auth->add($manage_tenants);
            $manage_tenants = $auth->getPermission(UserPermission::MANAGE_TENANTS);

            $log = Console::ansiFormat(UserPermission::MANAGE_TENANTS, [Console::FG_GREEN]);
            echo "\nCreated permission: $log \n";
        } else {
            $log = Console::ansiFormat(UserPermission::MANAGE_TENANTS, [Console::FG_RED]);
            echo "\nPermission already exist: $log \n";
        }

        // Create Admin role.
        $admin_role = $auth->getRole(User::ROLE_ADMIN);
        if ($admin_role == null) {
            $admin_role = $auth->createRole(User::ROLE_ADMIN);
            $auth->add($admin_role);
            $auth->addChild($admin_role, $manage_app);
            $auth->addChild($admin_role, $manage_tenants);

            $auth->assign($admin_role, $system_user->id); // Assign to System user.

            $log1 = Console::ansiFormat(User::ROLE_ADMIN, [Console::FG_CYAN]);
            echo "\nCreated role: $log1 \n";

            $log2 = Console::ansiFormat($system_user->username, [Console::FG_PURPLE]);
            echo "\nAssigned $log1 to : $log2 \n";
        } else {
            $log = Console::ansiFormat(User::ROLE_ADMIN, [Console::FG_RED]);
            echo "\nRole already exist: $log \n";
        }

        // Create User role.
        $user_role = $auth->getRole(User::ROLE_USER);
        if ($user_role == null) {
            $user_role = $auth->createRole(User::ROLE_USER);
            $auth->add($user_role);
            $auth->addChild($user_role, $manage_app);

            $log = Console::ansiFormat(User::ROLE_USER, [Console::FG_CYAN]);
            echo "\nCreated role: $log \n";
        } else {
            $log = Console::ansiFormat(User::ROLE_USER, [Console::FG_RED]);
            echo "\nRole already exist: $log \n";
        }
    }

}