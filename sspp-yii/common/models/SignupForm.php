<?php


namespace common\models;


class SignupForm extends BaseModel
{
    public $username;
    public $password;
    public $email = '';

    public function rules()
    {
        return [
            ['username', 'required'],
            ['password', 'required'],
            ['email', 'safe'],
        ];
    }

    public function signup()
    {
        // 调用validate方法对表单数据进行验证，验证规则参考上面的rules方法
        if (!$this->validate()) {
            print_r($this->errors);die();
            return $this->errors;
        }

        // 实现数据入库操作
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        // 生成 "remember me" 认证key
        $user->generateAuthKey();
        return $user->save(false);
    }
}