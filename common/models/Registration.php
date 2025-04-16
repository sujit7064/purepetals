<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "registration".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $phone_number
 * @property string $email
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
            [['user_id', 'name', 'phone_number', 'email'], 'required'],
            [['user_id', 'phone_number', 'is_delete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'is_delete' => 'Is Delete',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
