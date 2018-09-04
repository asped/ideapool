<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blacklist".
 *
 * @property int $id
 * @property string $token
 * @property string $timestamp
 */
class Blacklist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blacklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'timestamp' => 'Timestamp',
        ];
    }
}
