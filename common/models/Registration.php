<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "registration".
 *
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string $phone_number
 * @property string $email
 * @property string $password
 * @property int $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class Registration extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_delete'], 'default', 'value' => 0],
            [['user_id', 'company_name', 'phone_number', 'email', 'logo'], 'required'],
            [['user_id', 'is_delete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_name', 'email', 'logo'], 'string', 'max' => 255],
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
            'company_name' => 'Company Name',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'logo' => 'logo',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
