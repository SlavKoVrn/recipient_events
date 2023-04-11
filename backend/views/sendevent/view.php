<?php

use common\models\SendEvent;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SendEvent $model */

$this->title = 'Событие '.$model->event_name.' получателя '.$model->recipient_email;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="send-event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы хотите удалить событие ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'event_name',
            'recipient_email:email',
            [
                'attribute'=>'status',
                'filter'=>SendEvent::SEND_EVENT_STATUS_NAME,
                'value'=> function($model){
                    return SendEvent::SEND_EVENT_STATUS_NAME[$model->status];
                }
            ],
            [
                'attribute'=>'created_at',
                'value'=> function($model){
                    return date('d.m.Y H:i',strtotime($model->created_at));
                }
            ],
            [
                'attribute'=>'updated_at',
                'value'=> function($model){
                    return date('d.m.Y H:i',strtotime($model->updated_at));
                }
            ],
        ],
    ]) ?>

</div>
