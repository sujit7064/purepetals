<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_details".
 *
 * @property int $id
 * @property int $buyer_id
 * @property float|null $total_product_amount
 * @property float|null $delivery_charges
 * @property float|null $total_amount
 * @property string|null $payment_method
 * @property string|null $payment_status
 * @property string|null $transaction_id
 * @property int|null $status
 * @property int|null $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class PaymentDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_product_amount', 'delivery_charges', 'total_amount', 'payment_method', 'payment_status', 'transaction_id', 'status'], 'default', 'value' => null],
            [['is_delete'], 'default', 'value' => 0],
            [['buyer_id'], 'required'],
            [['buyer_id', 'status', 'is_delete'], 'integer'],
            [['total_product_amount', 'delivery_charges', 'total_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['payment_method', 'payment_status', 'transaction_id'], 'string', 'max' => 255],
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
            'total_product_amount' => 'Total Product Amount',
            'delivery_charges' => 'Delivery Charges',
            'total_amount' => 'Total Amount',
            'payment_method' => 'Payment Method',
            'payment_status' => 'Payment Status',
            'transaction_id' => 'Transaction ID',
            'status' => 'Status',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
