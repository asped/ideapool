<?php

namespace app\models;

use alfarioekaputra\JWT\UserTrait;
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
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

class User extends ActiveRecord implements IdentityInterface
{
    use UserTrait {
        findIdentityByAccessToken as public findId;
    }
    const JWT_EXPIRE_TIME = 30; // 10 minutes

    // Override this method
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 50],
            [['name', 'email', 'password'], 'required'],
            [['password'], 'string', 'max' => 255, 'min' => 8],
            [['password'], 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(.+)$/', 'message' => 'Password must be at least 8 characters, including 1 uppercase letter, 1 lowercase letter, and 1 number'],
            [['email'], 'email'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'refresh_token' => 'Refresh token',
        ];
    }

    protected static function getSecretKey()
    {
        return 'codementor2018';
    }

    // And this one if you wish

    protected static function getHeaderToken()
    {
        return [
            'exp' => time() + self::JWT_EXPIRE_TIME * 60
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $black = BlacklistedToken::findOne(['token' => $token]);
        if ($black) {
            throw new UnauthorizedHttpException('Invalid token');
        }
        return static::findId($token, $type);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $authKey == $this->id;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return parent::beforeSave($insert);
    }

    public function getGravatar()
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email)));

    }
}
