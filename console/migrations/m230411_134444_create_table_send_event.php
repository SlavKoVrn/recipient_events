<?php

use yii\db\Migration;

/**
 * Class m230411_134444_create_table_send_event
 */
class m230411_134444_create_table_send_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%send_event}}', [
            'id' => $this->primaryKey(),
            'event_name' => $this->string(255)->null()->comment('Название события'),
            'recipient_email' => $this->string(255)->null()->comment('Почтовый ящик получателя сообщения о событии'),
            'status'      => $this->tinyInteger(1)->defaultValue(1)->comment('Статус (1-включен, 2-заблокирован)'),
            'created_at' => $this->dateTime()->null()->comment('Дата создания'),
            'updated_at' => $this->dateTime()->null()->comment('Дата изменения'),
        ], $tableOptions);


        $this->createIndex(
            'idx-event_name',
            '{{%send_event}}',
            'event_name'
        );

        $this->createIndex(
            'idx-recipient_email',
            '{{%send_event}}',
            'recipient_email'
        );

        $this->createIndex(
            'idx-status',
            '{{%send_event}}',
            'status'
        );

        $this->createIndex(
            'idx-created_at',
            '{{%send_event}}',
            'created_at'
        );

        $this->createIndex(
            'idx-updated_at',
            '{{%send_event}}',
            'updated_at'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%send_event}}');
    }

}
