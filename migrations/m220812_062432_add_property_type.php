<?php

use yii\db\Migration;

/**
 * Class m220812_062432_add_property_type
 */
class m220812_062432_add_property_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('property', 'type', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('property', 'type');
    }
}
