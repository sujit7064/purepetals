<?php

use yii\db\Migration;

class m260115_081825_add_is_cart_offer_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%product}}',
            'is_cart_offer',
            $this->smallInteger(1)->defaultValue(0)->after('status')
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260115_081825_add_is_cart_offer_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260115_081825_add_is_cart_offer_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
