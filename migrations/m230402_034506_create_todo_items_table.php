<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%todo_items}}`.
 */
class m230402_034506_create_todo_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%todo_item}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'priority' => $this->integer()->notNull()->defaultValue(0),
            'done' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(new Expression('NOW()')),
            'version' => $this->integer()->notNull()->defaultValue(0),
        ]);

        // Create index on priority column
        $this->createIndex('idx-todo_item-priority', '{{%todo_item}}', 'priority');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%todo_items}}');
    }
}
