<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m250312_055923_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'category_name' => $this->string()->notNull(),
            'image' => $this->string()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
            'is_delete' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
