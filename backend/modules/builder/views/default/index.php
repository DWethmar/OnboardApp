<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php foreach($applications as $application): ?>
    <div class="applications">
        <?= Html::a($application->name, Url::to(['/builder/default/edit', 'application_id' => $application->id])) ?>
    </div>
<?php endforeach; ?>