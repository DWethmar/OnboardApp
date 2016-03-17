<?php

use yii\helpers\Html;
?>

<h2><?= $step->name ?></h2>

<h3><?= Yii::t('app', 'Listeners'); ?></h3>
<ul>
    <?php foreach($event_listeners as $event_listener): ?>
        <li class="editor">
            <span><?= $event_listener->name ?></span>
            <span><?= $event_listener->action ?></span>
            <span><?= $event_listener->selector ?></span>
            <?= Html::a(Yii::t('app', 'DELETE'),
                ['/builder/ajax-step-event/delete', 'id' => $event_listener->id],
                ['class' => 'delete-x']
            ) ?>
            <?= Html::a(Yii::t('app', 'EDIT'),
                ['/builder/ajax-step-event/update', 'id' => $event_listener->id],
                ['class' => 'edit-x']
            ) ?>
        </li>
    <?php endforeach; ?>
</ul>

<h3><?= Yii::t('app', 'Triggers'); ?></h3>
<ul>
    <?php foreach($event_triggers as $event_trigger): ?>
        <li class="editor">
            <span><?= $event_trigger->name ?></span>
            <span><?= $event_trigger->action ?></span>
            <i><?= $event_trigger->selector ?></i>
            <?= Html::a(Yii::t('app', 'DELETE'),
                ['/builder/ajax-step-event/delete', 'id' => $event_trigger->id],
                ['class' => 'delete-x']
            ) ?>
            <?= Html::a(Yii::t('app', 'EDIT'),
                ['/builder/ajax-step-event/update', 'id' => $event_trigger->id],
                ['class' => 'edit-x']
            ) ?>
        </li>
    <?php endforeach; ?>
</ul>
