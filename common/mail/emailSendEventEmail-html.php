<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var $event */
?>
<div class="verify-email">

    <p>Пользователь: <?= Html::encode($user->username) ?></p>
    <p>Событие: <?= Html::encode($event) ?></p>

</div>
