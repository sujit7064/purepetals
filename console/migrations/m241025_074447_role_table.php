<?php

use yii\db\Migration;

/**
 * Class m241025_074447_role_table
 */
class m241025_074447_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'role_name' => $this->string()->notNull(),
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
        echo "m241025_074447_role_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241025_074447_role_table cannot be reverted.\n";

        return false;
    }
    */
}
