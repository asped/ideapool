<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */

use yii\db\ActiveRecord;

class BlacklistedToken extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blacklisted_tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'], 'string', 'max' => 1000],
            [['token'], 'unique'],
            [['expiration'], 'date', 'format' => 'yyyy-M-d H:m:s'],
        ];
    }

    public function beforeSave($insert)
    {
        $this->expiration = date("Y-m-d H:i:s", time() + 3600 * 24);
        return parent::beforeSave($insert);
    }

}
