<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart_item".
 *
 * @property int $id
 * @property int $buyer_id
 * @property int $product_id
 * @property float $product_quantity
 * @property string $order_date
 * @property float $product_price
 * @property float $total_amount
 * @property int $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class CartItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_delete'], 'default', 'value' => 0],
            [['buyer_id', 'product_id', 'product_quantity', 'order_date', 'product_price', 'total_amount'], 'required'],
            [['buyer_id', 'product_id', 'is_delete'], 'integer'],
            [['product_quantity', 'product_price', 'total_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_id' => 'Buyer ID',
            'product_id' => 'Product ID',
            'product_quantity' => 'Product Quantity',
            'order_date' => 'Order Date',
            'product_price' => 'Product Price',
            'total_amount' => 'Total Amount',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
