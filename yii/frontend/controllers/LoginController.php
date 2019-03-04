<?php


namespace  frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Login;
use frontend\models\User;
use frontend\models\Common;
use frontend\models\Log;
use frontend\models\Upgrade;

/**
*  登录控制器显示
*  功能1 登录主页页面显示
*  功能2 忘记密码页面显示
*  说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
*       里面的含有所有的翻译中文语言
*
*
*  @copyright Copyright (c) 2017 –www.zwaveasia.com.cn
*  @author yaolianmin
*  @version 1.0 2017/10/18 14:06
*
*/

class LoginController extends Controller{
	/**
     * 登录页面显示 
     * 验证登陆信息
     */
	public function actionIndex(){
        $action = Yii::$app->request->get('action');
        if($action && isset((Yii::$app->session['name']))){
            Log::add_log(1,8,'sign out','FW_server');
        }
        $rel = Common::exit_system();
        // 1.0 初始化验证登陆信息
        if(Yii::$app->request->isPost){
           $post = Yii::$app->request->post();
           $is_empty = Login::chech_isempty($post); //判断各项是否为空 
            if($is_empty!='success'){ 
                return $this->renderPartial('index',['information' =>$is_empty,'post'=>$post]);
            }else{
                $re = Login::check_login($post); //验证各项数据的正确
                if($re){ //表示数据有错
                    return $this->renderPartial('index',['information' =>$re,'post'=>$post]);
                }else{
                    //添加一条日志记录
                    Log::add_log(1,8,'login','FW_server','');
                    //检测该用户日志数量是否超过规定数量1000
                    Log::check_log_numbers(Yii::$app->session['name']);
                    return $this->redirect(['index/index']);  
                }
            } 
        }
        return $this->renderPartial('index');
	} 



    /**
     *  登录主页忘记密码模块
     *  验证表单提交信息
     */
    public function actionForget(){
        //获得超管的电话以及邮箱
        $infor = User::find()->select(['phone','email'])->where(['power'=>'15'])->asArray()->one();
        return $this->renderPartial('forget',['infor'=>$infor]);
    }
    


     /**
     *  登录主页忘记密码模块
     *  验证表单提交信息
     */
    public function actionFind_password(){
        if(Yii::$app->request->isAjax){
            //验证身份第一步
            $email = trim(Yii::$app->request->post('ajax_email'));
            if($email){
                $user_name = Yii::$app->request->post('ajax_user_name');
                $select_email = Login::find()->select('email')->where(['user_name'=>$user_name])->asArray()->one();
                if(!$select_email){
                    return '用户名不存在!请重新填写';
                }
                if( $select_email['email'] != $email){
                    return '邮箱错误，请重新填写';
                }
                return 'success';
            }
            //发送验证码
            $ajax_post_email = trim(Yii::$app->request->post('ajax_post_email'));
            if($ajax_post_email){
                $string = '0123456789';
                $ver='';//验证码
                for($i=0;$i<6;$i++){
                    $index = rand(0,9);
                    $tmp   = $string[$index];
                    $ver.=$tmp;
                }
                $mail = Yii::$app->mailer->compose();
                $mail->setTo($ajax_post_email);
                $mail->setSubject('ZWA后台管理系统');
                $mail->setHtmlBody('Hi,你好,您次此的验证码为'.'<p style="color:blue;">'.$ver.'</p>'.'请妥善保管！');
                if($mail->send()){
                    setcookie("email_code",$ver,time()+115);
                    return 'success';
                }else{
                    return '系统升级，请稍后';
                }
            }
            //效验邮箱验证码，并重置密码
            $post_code = trim(Yii::$app->request->post('ajax_post_code'));
            if($post_code){
                if(isset($_COOKIE['email_code'])){
                    if($_COOKIE['email_code'] == $post_code){
                        $post_pass = trim(Yii::$app->request->post('ajax_pass'));
                        $post_repass = trim(Yii::$app->request->post('ajax_repass'));
                        $post_user = trim(Yii::$app->request->post('ajax_post_user'));
                        if($post_pass == $post_repass){
                            $md5_pass = md5($post_pass);
                            $sql = 'update user set password="'.$md5_pass.'" where user_name="'.$post_user.'"';
                            $rel = Yii::$app->db->createCommand($sql)->execute();
                            if($rel){
                               return 'success'; 
                            }else{
                                return '系统升级,请稍后';
                            }
                        }else{
                            return '两次密码不一样，请重新填写';
                        }
                    }else{
                        return '验证码错误，请重新填写';
                    }
                }else{
                    return '验证码已过期，请重新获取';
                }         
            }
        }
        return $this->renderPartial('find_password');
    }



    public function actionQuit(){
        return $this->renderPartial('quit');
    }

}