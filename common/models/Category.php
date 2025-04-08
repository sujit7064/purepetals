<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $category_name
 * @property string|null $image
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $is_delete
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'updated_at'], 'default', 'value' => null],
            [['is_delete'], 'default', 'value' => 0],
            [['category_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_delete'], 'integer'],
            [['category_name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_delete' => 'Is Delete',
        ];
    }

}
