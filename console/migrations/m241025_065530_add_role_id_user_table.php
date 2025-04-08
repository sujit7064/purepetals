<?php

use yii\db\Migration;

/**
 * Class m241025_065530_add_role_id_user_table
 */
class m241025_065530_add_role_id_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role_id', $this->integer()->notNull()->after('id'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241025_065530_add_role_id_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241025_065530_add_role_id_user_table cannot be reverted.\n";

        return false;
    }
    */
}
