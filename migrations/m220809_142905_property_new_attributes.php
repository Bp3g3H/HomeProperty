<?php

use yii\db\Migration;

/**
 * Class m220809_142905_property_new_attributes
 */
class m220809_142905_property_new_attributes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('property', 'lat', $this->decimal(20,10));
        $this->addColumn('property', 'lng', $this->decimal(20,10));
        $this->alterColumn('property', 'area', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('property', 'lat');
        $this->dropColumn('property', 'lng');
        $this->alterColumn('property', 'area', $this->string(50));
    }
}
