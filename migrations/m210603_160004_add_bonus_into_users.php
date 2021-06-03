<?php

use yii\db\Migration;

/**
 * Class m210603_160004_add_bonus_into_users
 */
class m210603_160004_add_bonus_into_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'bonus', $this->float()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'bonus');
    }

}
