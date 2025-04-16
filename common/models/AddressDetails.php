<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address_details".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property string|null $dist
 * @property string|null $city
 * @property string|null $state
 * @property int $pincode
 * @property string|null $status
 * @property int $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class AddressDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'dist', 'city', 'state', 'status'], 'default', 'value' => null],
            [['is_delete'], 'default', 'value' => 0],
            [['user_id', 'pincode'], 'required'],
            [['user_id', 'pincode', 'is_delete'], 'integer'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['dist', 'city', 'state', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'dist' => 'Dist',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode',
            'status' => 'Status',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
