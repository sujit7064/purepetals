<?php

use yii\db\Migration;

/**
 * Class m241025_070016_inser_default_user_data
 */
class m241025_070016_inser_default_user_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    private $table_name = 'user';
    public function safeUp()
    {
        $admin_login_credential = [
            'username' => 'admin',
            'role_id' => 1,
            'password_hash' => '$2y$13$CA0UCNg7BBGtnJOYwL/Hs.SRvToS0zErDBSR/VLdxEB1snOptVF8S',
            'auth_key'=>'admin',
            'email'=>'admin@gmail.com',
            'status' => 10,
            'created_at'=>1686652395,
            'updated_at'=>1686652395
        ];
        $this->insert($this->table_name, $admin_login_credential);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241025_070016_inser_default_user_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241025_070016_inser_default_user_data cannot be reverted.\n";

        return false;
    }
    */
}
