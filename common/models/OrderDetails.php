<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $buyer_id
 * @property int $product_id
 * @property int|null $paymentdetails_id
 * @property int|null $address_id
 * @property float|null $product_quantity
 * @property string|null $order_date
 * @property float|null $total_amount
 * @property int|null $order_status
 * @property int $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class OrderDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentdetails_id', 'address_id', 'product_quantity', 'order_date', 'total_amount'], 'default', 'value' => null],
            [['is_delete'], 'default', 'value' => 0],
            [['buyer_id', 'product_id'], 'required'],
            [['buyer_id', 'product_id', 'paymentdetails_id', 'address_id', 'order_status', 'is_delete'], 'integer'],
            [['product_quantity', 'total_amount'], 'number'],
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
            'paymentdetails_id' => 'Paymentdetails ID',
            'address_id' => 'Address ID',
            'product_quantity' => 'Product Quantity',
            'order_date' => 'Order Date',
            'total_amount' => 'Total Amount',
            'order_status' => 'Order Status',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getBuyer()
    {
        return $this->hasOne(Registration::className(), ['user_id' => 'buyer_id']);
    }
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    public function getAddress()
    {
        return $this->hasOne(AddressDetails::className(), ['id' => 'address_id']);
    }
    public function getPayment()
    {
        return $this->hasOne(PaymentDetails::className(), ['id' => 'paymentdetails_id']);
    }

    const STATUSES = [
        0 => 'Pending',
        1 => 'Confirmed',
        2 => 'Processing',
        3 => 'Shipped',
        4 => 'Out for Delivery',
        5 => 'Delivered',
        6 => 'Return Requested',
        7 => 'Return Approved',
        8 => 'Return Initiated',
        9 => 'Return In Transit',
        10 => 'Return Received',
        11 => 'Refund Processed',
        12 => 'Cancelled by Customer',
        13 => 'Cancelled by Admin',
        14 => 'Failed Delivery',
    ];
}
