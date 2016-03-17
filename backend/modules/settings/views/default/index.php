<?php

use yii\widgets\Menu;

?>

<h1>Settings</h1>
<?= Menu::widget([
    'items' => [
        ['label' => 'Step Types', 'url' => ['settings/step-type/index'], 'items' => [
            ['label' => 'Create', 'url' => ['settings/step-type/create']],
        ]],
    ],
]); ?>