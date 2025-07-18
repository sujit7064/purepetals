<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m250718_045857_add_multiple_image_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'multiple_image', $this->string()->after('image'));
        $this->addColumn('product', 'final_price', $this->float()->notNull()->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {}
}
