<?php

use yii\db\Migration;

class m170709_054736_add_phone_to_user_table extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170709_054736_add_phone_to_user_table cannot be reverted.\n";

        return false;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%user}}', 'phone', $this->string(255)->notNull());
        $this->createIndex('{{%user_unique_phone}}', '{{%user}}', 'phone', true);
    }

    public function down()
    {
        $this->dropIndex('{{%user_unique_phone}}', '{{%user}}');
        $this->dropColumn('{{%user}}', 'phone');
    }
    
}
