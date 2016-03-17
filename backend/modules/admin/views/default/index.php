<?php

use yii\widgets\Menu;

?>

<h1><?= Yii::t('app', 'Admin') ?></h1>
<?= Menu::widget([
    'items' => [
        ['label' => 'Admin panel', 'url' => ['/admin/default/index'], 'items' => [
            ['label' => 'Tenant', 'url' => ['/admin/tenant']],
            ['label' => 'user', 'url' => ['/admin/user']],
        ]],
    ],
]); ?>