<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%registration}}`.
 */
class m250308_172753_create_registration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%registration}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'company_name' => $this->string(255)->notNull(),
            'phone_number' => $this->bigInteger(20)->notNull(),
            'email' => $this->string(255)->notNull(),
            'logo' => $this->string(255)->notNull(),
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
        $this->dropTable('{{%registration}}');
    }
}
