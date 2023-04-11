<?php

use yii\db\Migration;

/**
 * Class m230411_133606_add_admin
 */
class m230411_133606_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}',[
            'id' => 1,
            'username' => 'admin',
            'auth_key' => md5(time()),
            'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
            'password_reset_token' => '',
            'email' => 'pochta@mail.ru',
            'verification_token' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}',['id' => 1]);
    }

}
