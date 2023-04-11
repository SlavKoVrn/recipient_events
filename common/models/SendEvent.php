<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "send_event".
 *
 * @property int $id
 * @property string|null $event_name Название события
 * @property string|null $recipient_email Почтовый ящик получателя сообщения о событии
 * @property int|null $status Статус (1-включен, 2-заблокирован)
 * @property string|null $created_at Дата создания
 * @property string|null $updated_at Дата изменения
 */
class SendEvent extends \yii\db\ActiveRecord
{
    const SEND_EVENT_STATUS_ENABLED = 1;
    const SEND_EVENT_STATUS_DISABLED = 2;

    const SEND_EVENT_STATUS_NAME = [
        self::SEND_EVENT_STATUS_ENABLED => 'Нет',
        self::SEND_EVENT_STATUS_DISABLED => 'Да',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['event_name', 'recipient_email'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'event_name' => 'Событие',
            'recipient_email' => 'Получатель',
            'status' => 'Заблокирован',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
        ];
    }
}
