<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%win_history}}`.
 */
class m210603_084414_create_win_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%win_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'prize_type' => $this->string(10)->notNull(),
            'prize_amount' => $this->string(20),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('now()'),
            'updated_at' => $this->timestamp()
        ]);
        $this->addForeignKey('win_history_user_fk', '{{%win_history}}', 'user_id',
            '{{%users}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('win_history_user_fk', '{{%win_history}}');
        $this->dropTable('{{%win_history}}');
    }
}
