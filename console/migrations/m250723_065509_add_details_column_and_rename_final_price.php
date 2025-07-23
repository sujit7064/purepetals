<?php

use yii\db\Migration;

class m250723_065509_add_details_column_and_rename_final_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'details', $this->text()->after('description'));
        $this->renameColumn('product', 'final_price', 'cut_price');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250723_065509_add_details_column_and_rename_final_price cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250723_065509_add_details_column_and_rename_final_price cannot be reverted.\n";

        return false;
    }
    */
}
