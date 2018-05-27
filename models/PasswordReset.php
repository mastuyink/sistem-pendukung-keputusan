<?php
namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class PasswordReset extends Model
{
    public $password;
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','confirmPassword'],'required'],
            ['password', 'string', 'min' => 6,'tooShort'=>'Panjang Password Minimal 6 Karakter'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'password','message'=>'Password Harus Sama'],
        ];
    }

    

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if ($this->validate()) {
            $userModel = User::findOne($id);
            $userModel->setPassword($this->password);
            $userModel->generateAuthKey();
            if ($userModel->save()) {
                return true;
            }
        }

        return null;
    }

    public static function getUser($id){
        return User::findOne($id);
    }

    
}
