<?php

use yii\db\Migration;

/**
 * Class m220726_134528_user_table
 */
class m220726_134528_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'token' => $this->string(255),
            'type' => $this->integer(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('user');
    }
}
