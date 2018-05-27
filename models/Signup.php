<?php
namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $password;
    public $level;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','email','password','level'],'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Username Sudah Digunakan'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Email Sudah Terdaftar.'],
            ['level','integer'],
            ['level','in','range'=>[1,2,3,4]],
            ['password', 'string', 'min' => 6,'tooShort'=>'Panjang Password Minimal 6 Karakter'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->level = $this->level;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    
}
