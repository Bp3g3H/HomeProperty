<?php

use yii\db\Migration;

/**
 * Class m220805_141002_property_table
 */
class m220805_141002_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('property', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(11)->notNull(),
            'headline' => $this->string(255),
            'area' => $this->string(50),
            'price' => $this->decimal(11,2),
            'city' => $this->string(255),
            'street' => $this->string(255),
            'description' => $this->text()
        ]);

        $this->createTable('property_image', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(11)->notNull(),
            'image' => $this->text(),
        ]);

        $this->addForeignKey('property_image_property', 'property_image', 'property_id', 'property', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('property_image_property', 'property_image');
        $this->dropTable('property_image');
        $this->dropTable('property');
    }
}
