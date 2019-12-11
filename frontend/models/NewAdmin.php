<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use backend\models\Admin;
/**
 * Signup form
 */
class NewAdmin extends Model
{
    public $username;
    public $email;
    public $password;
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'Ovaj username je vec u upotrebi.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'Ovaj e-mail je vec u upotrebi.'],
         
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
        
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        if((!Admin::find()->all())){
        $admin = new Admin();
        $admin->username = $this->username;
        $admin->email = $this->email;
        $admin->generateAuthKey();
        $admin->setPassword($this->password);
        return $admin->save();
        }
    
    }



}
