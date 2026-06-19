<?php

use yii\db\Migration;

class m260515_101810_add_otp_fields_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%user}}',
            'otp',
            $this->string(10)->null()->after('email')
        );

        $this->addColumn(
            '{{%user}}',
            'otp_expire_time',
            $this->dateTime()->null()->after('otp')
        );

        $this->addColumn(
            '{{%user}}',
            'is_otp_verified',
            $this->tinyInteger(1)->defaultValue(0)->after('otp_expire_time')
        );

        $this->addColumn(
            '{{%user}}',
            'otp_attempt',
            $this->integer()->defaultValue(0)->after('is_otp_verified')
        );

        $this->addColumn(
            '{{%user}}',
            'email_verified_at',
            $this->dateTime()->null()->after('otp_attempt')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'otp');

        $this->dropColumn('{{%user}}', 'otp_expire_time');

        $this->dropColumn('{{%user}}', 'is_otp_verified');

        $this->dropColumn('{{%user}}', 'otp_attempt');

        $this->dropColumn('{{%user}}', 'email_verified_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260515_101810_add_otp_fields_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
