<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_details}}`.
 */
class m250413_175748_create_order_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_details}}', [
            'id' => $this->primaryKey(),
            'buyer_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'paymentdetails_id' => $this->integer()->null(),
            'address_id' => $this->integer()->null(),
            'product_quantity' => $this->float(),
            'order_date' => $this->string(255)->null(),
            'total_amount' => $this->float(),
            'order_status' => $this->integer()->defaultValue(0),
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
        $this->dropTable('{{%order_details}}');
    }
}
