<?php

use yii\db\Migration;

/**
 * Class m220908_111042_add_comments
 */
class m220908_111042_add_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'property_id' => $this->integer(11)->notNull(),
            'message' => $this->text()
        ]);

        $this->addForeignKey('comment_user', 'comment', 'user_id', 'user', 'id');
        $this->addForeignKey('comment_property', 'comment', 'property_id', 'property', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('comment_user', 'comment');
        $this->dropForeignKey('comment_property', 'comment');
        $this->dropTable('comment');
    }
}
