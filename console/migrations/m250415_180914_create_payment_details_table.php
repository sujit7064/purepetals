<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_details}}`.
 */
class m250415_180914_create_payment_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_details}}', [
            'id' => $this->primaryKey(),
            'buyer_id' => $this->integer()->notNull(),
            'total_product_amount' => $this->float()->null(),
            'delivery_charges' => $this->float()->null(),
            'total_amount' => $this->float()->null(),
            'payment_method' => $this->string()->null(),
            'payment_status' => $this->string()->null(),
            'transaction_id' => $this->string()->null(),
            'status' => $this->integer()->null(),
            'is_delete' => $this->Integer()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('current_timestamp'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('current_timestamp')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_details}}');
    }
}
