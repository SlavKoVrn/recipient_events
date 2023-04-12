<?php

use common\models\SendEvent;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SendEvent $model */

$this->title = 'Изменить событие: '.SendEvent::SEND_EVENT_NAME[$model->event_name].' получателя '.$model->recipient_email;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Ид: '.$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="send-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
