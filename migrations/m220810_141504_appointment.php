<?php

use yii\db\Migration;

/**
 * Class m220810_141504_appointment
 */
class m220810_141504_appointment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('appointment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'property_id' => $this->integer(11)->notNull(),
            'time' => $this->dateTime(),
            'name' => $this->string(255),
        ]);

        $this->addForeignKey('appointment_user', 'appointment', 'user_id', 'user', 'id');
        $this->addForeignKey('appointment_property', 'appointment', 'property_id', 'property', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('appointment_user', 'appointment');
        $this->dropForeignKey('appointment_property', 'appointment');
        $this->dropTable('appointment');
    }
}
