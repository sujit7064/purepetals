<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $product_name
 * @property int $price
 * @property int|null $quantity
 * @property int|null $status
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $is_delete
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'quantity', 'description', 'updated_at'], 'default', 'value' => null],
            [['is_delete', 'status'], 'default', 'value' => 0],
            [['category_id', 'quantity', 'status', 'is_delete'], 'integer'],

            [['product_name', 'price', 'final_price'], 'required'],
            [['image'], 'required', 'on' => 'create'], // only required on create
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['multiple_image'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],

            [['created_at', 'updated_at'], 'safe'],
            [['product_name'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['category_id', 'quantity', 'description', 'price', 'image', 'product_name', 'multiple_image', 'final_price'];
        $scenarios['update'] = ['category_id', 'quantity', 'description', 'price', 'image', 'product_name', 'multiple_image', 'final_price'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'product_name' => 'Product Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_delete' => 'Is Delete',
        ];
    }
}
