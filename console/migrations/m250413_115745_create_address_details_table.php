<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address_details}}`.
 */
class m250413_115745_create_address_details_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address_details}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'address' => $this->text()->null(),
            'dist' => $this->string()->null(),
            'city' =>  $this->string()->null(),
            'state' => $this->string()->null(),
            'pincode' => $this->integer()->notNull(),
            'status' => $this->string()->null(),
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
        $this->dropTable('{{%address_details}}');
    }
}
