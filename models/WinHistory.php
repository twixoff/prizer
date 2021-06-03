<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%win_history}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $prize_type
 * @property string|null $prize_amount
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class WinHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%win_history}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prize_type'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prize_type'], 'string', 'max' => 10],
            [['prize_amount'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'prize_type' => 'Prize Type',
            'prize_amount' => 'Prize Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
