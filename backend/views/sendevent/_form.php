<?php
use common\models\SendEvent;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SendEvent $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="send-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(SendEvent::SEND_EVENT_STATUS_NAME) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
