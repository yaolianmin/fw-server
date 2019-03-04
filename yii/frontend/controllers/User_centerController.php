<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Log;



/**
* 模块：用户个人信息页面
* 功能：仅显示用户的信息
*
* 时间:2018-20-02-26
*/
class User_centerController extends Controller{
    public function actionUser_center(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
	    $name = Yii::$app->session['name']; //用户名
	    $power = Yii::$app->session['power']; //权限
        $dev_infor = User::find_user_infor_by_name($name); //查询这个人的用户信息
        $own_dev = explode('@@@@@',$dev_infor[0]['name']);
        //post提交的信息
        $post_infor = Yii::$app->request->post();
        if($post_infor){
        	if(!$post_infor['user_name']){
        		return $this->renderPartial('user_center',['post'=>$dev_infor[0],'own_dev'=>$own_dev]);
        	}
        	//修改用户的信息
        	$rel = User::update_center_user_infor($post_infor);
        	if($rel){
                Log::add_log(1,5,'update','personal information');
        		return $this->redirect(['user_center/success']);
        	}
        }
	    return $this->renderPartial('user_center',['post'=>$dev_infor[0],'own_dev'=>$own_dev]);
    }


    public function actionSuccess(){

        return $this->renderPartial('success');
    }
}