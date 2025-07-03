<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m250703_092857_add_description_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'description', 'TEXT AFTER quantity');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {}
}
