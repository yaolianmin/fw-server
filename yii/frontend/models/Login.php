<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use Yii;
/**
* 登录页面操作模型
* 功能：供登录控制器调用函数
*
*
*
*  @copyright Copyright (c) 2017 – www.zhiweiya.com
*  @author yaolianmin
*  @version 1.0 2017/10/18 14:06
*/
class Login extends ActiveRecord{
    
    
    //连接user表
    public static function tableName(){
        return '{{user}}';
    }


	/**
     *  初始化登数据
     *  判断各项是否为空
     *  @param 
     *  @return 
     */
    public function chech_isempty($post){

       $user_name = isset($post['user_name'])?$post['user_name']:''; //过滤用户名
       $passwords = isset($post['passwords'])?$post['passwords']:''; //密码（已经加密）
       $verify = isset($post['verify'])?$post['verify']:'';  //验证码

       if(!$user_name){
            return Yii::t('yii','The username can not be empty');
       }
       if(!$passwords){
            return Yii::t('yii','Password can not be empty');
       }
       if(!$verify){
            return Yii::t('yii','The verifying code can not be empty');
       }

       return 'success';

    }

    /**
     * 初始化登录信息
     * @param：$post
     * @return 
     */
    public function check_login($post){
        //判断验证码是否超时
        if(isset($_COOKIE['verify'])){
            //检验验证码
            if(strtolower($post['verify']) == strtolower($_COOKIE['verify'])) {
                //查找个人信息
                $remember_information = Login::find()->where(['user_name' => $post['user_name']])->asArray()->one();
                if($remember_information){
                    if($post['passwords'] == $remember_information['password']){
                        Yii::$app->session['language']  = $remember_information['language']; //存入语种
                        Yii::$app->session['name'] = $post['user_name']; //存入名字
                        Yii::$app->session['power']     = $remember_information['power']; //存入权限
                    }else{
                        return Yii::t('yii','password error');
                    }   
                }else{
                    return Yii::t('yii','username error');
                }
            }else{
                return Yii::t('yii','verfity code error'); 
            } 
        }else{
            return Yii::t('yii','verfity code timeout');  
        }   

    }

    
   
}