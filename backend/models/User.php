<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property string $accessToken
 * @property string $authKey
 *
 * @property Columns[] $columns
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'login', 'password'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['login'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 300],
            [['accessToken', 'authKey'], 'string', 'max' => 100],
            [['login'], 'unique'],
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
            'login' => 'Login',
            'password' => 'Password',
            'accessToken' => 'Access Token',
            'authKey' => 'Auth Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumns()
    {
        return $this->hasMany(Columns::className(), ['user_id' => 'id']);
    }

    /**
     * Localiza uma identidade pelo ID informado
     *
     * @param string|int $id o ID a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao ID informado
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Localiza uma identidade pelo token informado
     *
     * @param string $token o token a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao token informado
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @return int|string o ID do usuário atual
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string a chave de autenticação do usuário atual
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return bool se a chave de autenticação do usuário atual for válida
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert){
        if($insert || $this->isAttributeChanged('password')){
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }

        if($insert){
            $this->authKey = Yii::$app->getSecurity()->generateRandomString(100);
            $this->accessToken = Yii::$app->getSecurity()->generateRandomString(100);
        }

        return parent::beforeSave($insert);
    }

    public function validatePassword($password){
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function generateToken(){
        $this->accessToken = Yii::$app->getSecurity()->generateRandomString(100);
        return $this->save();
    }

    public static function findByLogin($login){
        return self::findOne(['login' => $login]);
    }

    public function fields(){
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }
}
