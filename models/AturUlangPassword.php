<?php
namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\User;

/**
 * Password reset form
 */
class AturUlangPassword extends Model
{
    public $password;
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','confirmPassword'],'required','message'=>'{attribute} tidak boleh kosong'],
            ['password', 'string', 'min' => 6,'tooShort'=>'Panjang Password Minimal 6 Karakter'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'password','message'=>'Password Harus Sama'],
        ];
    }

    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token tidak ditemukan.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Token Tidak Valid, Silahkan Coba Lagi');
        }
        parent::__construct($config);
    }
    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}