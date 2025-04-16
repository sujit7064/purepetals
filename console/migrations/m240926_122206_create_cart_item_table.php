<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_item}}`.
 */
class m240926_122206_create_cart_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart_item}}', [
            'id' => $this->primaryKey(),
            'buyer_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'product_quantity' => $this->float()->notNull(),
            'order_date' =>  $this->string()->notNull(),
            'product_price' => $this->float()->notNull(),
            'total_amount' => $this->float()->notNull(),
            'is_delete' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart_item}}');
    }
}
