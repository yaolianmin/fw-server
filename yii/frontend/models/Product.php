<?php
 namespace frontend\models;
 use Yii;
 use yii\base\Model;
 
 class Product extends Model
 {




     public $verifyCode;
     public function rules()
     {
         return [
             ['verifyCode', 'captcha','message'=>'验证码输入错误了，傻是不是？'],
         ];
     }


     public function attributeLabels()
    {
        return [
            'verifyCode' => '请在右面输入验证码  懂不？',
        ];
    }
}
?>
}