<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produc}}`.
 */
class m250312_060129_create_produc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->null(),
            'product_name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'price' => $this->float()->notNull(),
            'quantity' => $this->integer()->null(),
            'status' => $this->integer()->defaultValue(0),
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
        $this->dropTable('{{%produc}}');
    }
}
