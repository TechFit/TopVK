<?php
/**
 * SignUpForm class
 * @author Maxym Barvinok
 */

namespace app\models;


use yii\base\Model;

class SignUpForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var string */
    public $repeat_password;

    /** @var string */
    public $token;

    /** @var string */
    public $created_at;

    public function rules()
    {
        return[
            [['email', 'username', 'password', 'repeat_password'], 'required',],
            ['email', 'email'],
            ['username', 'string', 'min' => 3,],
            ['email', 'unique', 'targetClass' => 'app\models\Users',],
            ['password', 'string', 'min' => 2, 'max' => 10,],
            [
                'repeat_password',
                'compare',
                'compareAttribute'=>'password',
                'skipOnEmpty' => false,
                'message'=>"Пароли не совпадают",
            ],
        ];
    }

    public function signUp(){

        $user = new Users();

        $user->email = $this->email;
        $user->username = $this->username;
        $user->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->save();
    }
}