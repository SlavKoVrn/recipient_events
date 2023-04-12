<?php

use common\models\SendEvent;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\SendEventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'События подписчиков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="send-event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout'=>0]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'event_name',
                'filter'=>SendEvent::SEND_EVENT_NAME,
                'content'=> function($model){
                    return SendEvent::SEND_EVENT_NAME[$model->event_name];
                }
            ],
            'recipient_email:email',            [
                'attribute'=>'status',
                'filter'=>SendEvent::SEND_EVENT_STATUS_NAME,
                'content'=> function($model){
                    return SendEvent::SEND_EVENT_STATUS_NAME[$model->status];
                }
            ],
            [
                'attribute'=>'created_at',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created_at',
                    'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]),
                'content'=> function($model){
                    return date('d.m.Y H:i',strtotime($model->created_at));
                }
            ],
            [
                'attribute'=>'updated_at',
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'updated_at',
                    'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]),
                'content'=> function($model){
                    return date('d.m.Y H:i',strtotime($model->updated_at));
                }
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SendEvent $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
