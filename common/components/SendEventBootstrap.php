<?php

namespace common\components;

use common\models\User;
use common\models\SendEvent;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\web\User as WebUser;
use yii\mail\BaseMailer;

/**
 * Class SendEvent
 *
 * @package common\components
 */
class SendEventBootstrap implements BootstrapInterface {

    private function sendEmailEvent($event_name, $recipient_emails = [], $subject = '')
    {
        if ($event_name == SendEvent::SEND_EVENT_SEND_EMAIL){
            Event::off(BaseMailer::class, BaseMailer::EVENT_AFTER_SEND, [$this, 'mailSendEvent']);
        }
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailSendEventEmail-html', 'text' => 'emailSendEventEmail-text'],
                [
                    'user' =>  Yii::$app->user->identity,
                    'event' => 'событие: '.SendEvent::SEND_EVENT_NAME[$event_name],
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($recipient_emails)
            ->setSubject($subject)
            ->send();
        if ($event_name == SendEvent::SEND_EVENT_SEND_EMAIL){
            Event::on(BaseMailer::class, BaseMailer::EVENT_AFTER_SEND, [$this, 'mailSendEvent']);
        }
    }

    private function getRecipientEmails($event_name)
    {
        return SendEvent::find()
            ->select('recipient_email')
            ->where(['event_name' => $event_name])
            ->andWhere(['status' => SendEvent::SEND_EVENT_STATUS_ENABLED])
            ->column();
    }

    public function bootstrap($app)
    {
        Event::on(WebUser::class, WebUser::EVENT_AFTER_LOGIN, [$this, 'loginEvent']);
        Event::on(WebUser::class, WebUser::EVENT_BEFORE_LOGOUT, [$this, 'logoutEvent']);
        Event::on(BaseMailer::class, BaseMailer::EVENT_AFTER_SEND, [$this, 'mailSendEvent']);
        Event::on(User::class, User::EVENT_AFTER_SIGNUP, [$this, 'signupEvent']);
        Event::on(User::class, User::EVENT_AFTER_VERIFY, [$this, 'verifyEvent']);
    }

    public function loginEvent(Event $event)
    {
        $recipient_emails = $this->getRecipientEmails(SendEvent::SEND_EVENT_USER_AFTER_LOGIN);
        $this->sendEmailEvent(SendEvent::SEND_EVENT_USER_AFTER_LOGIN,$recipient_emails,'');
    }

    public function logoutEvent(Event $event)
    {
        $recipient_emails = $this->getRecipientEmails(SendEvent::SEND_EVENT_USER_BEFORE_LOGOUT);
        $this->sendEmailEvent(SendEvent::SEND_EVENT_USER_BEFORE_LOGOUT,$recipient_emails,'');
    }

    public function mailSendEvent(Event $event)
    {
        $recipient_emails = $this->getRecipientEmails(SendEvent::SEND_EVENT_SEND_EMAIL);
        $this->sendEmailEvent(SendEvent::SEND_EVENT_SEND_EMAIL,$recipient_emails,'');
    }

    public function signupEvent(Event $event)
    {
        $recipient_emails = $this->getRecipientEmails(SendEvent::SEND_EVENT_SIGNUP_USER);
        $this->sendEmailEvent(SendEvent::SEND_EVENT_SIGNUP_USER,$recipient_emails,'');
    }

    public function verifyEvent(Event $event)
    {
        $recipient_emails = $this->getRecipientEmails(SendEvent::SEND_EVENT_VERIFY_USER);
        $this->sendEmailEvent(SendEvent::SEND_EVENT_VERIFY_USER,$recipient_emails,'');
    }

}