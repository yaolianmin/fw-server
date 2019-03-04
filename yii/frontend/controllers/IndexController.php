<?php
namespace  frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Upgrade;
use frontend\models\User;
use frontend\models\Common;
use frontend\models\Log;


/**
* 模块：网站整体结构，包括头部及左边 右边
* 功能：组合网站结构 提取CPU 磁盘等信息
* 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
*       里面的含有所有的翻译中文语言
*
* 时间：2108-01-19
* @auhor:
*/

class IndexController extends Controller{
	public function actionIndex(){
       //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
		return $this->renderPartial('index');
	}




	public function actionTop(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $language = Yii::$app->request->get('language');
        if($language){ // ajax请求切换语言
            Yii::$app->session['language'] = $language;
            $user_name  = Yii::$app->session['name'];
            User::updateAll(['language'=>$language],['user_name'=>$user_name]);

            return 'success';
        }
		return $this->renderPartial('top');
	}



	public function actionLeft(){
         //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $power = Yii::$app->session['power']; //权限
        $user_name = Yii::$app->session['name']; //用户名
        //获得此人的所有权限
        $power_have =User::have_all_power($user_name);
        if($power < 5){ //什么情况下都不给普通 用户管理的权限
            $power_have[7] = 0;
        }
		return $this->renderPartial('left',['power_have'=>$power_have,'power'=>$power]);
	}

    /**
     *模块：超管的主页
     *功能：显示网站CPU 磁盘的使用情况
     *
     */
	public function actionMain(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
             return $this->redirect(['login/quit']); 
        }
        if(Yii::$app->session['power']<14){
            return $this->redirect(['device/device']);
        }
        //系统版本
        $version = Upgrade::find_now_version();
        //获得系统运行时长
        $str = file("/proc/uptime");
        $str = trim($str[0]);
        $min = $str / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        $system_itme = [$days,$hours,$min];//系统运行的时长
        //CPU与内存的使用率
        exec('cat /etc/redhat-release',$centos_info,$bb);
        $fp = popen('top -b -n 1 | grep -E "(Cpu|Mem)"','r');//获取某一时刻系统cpu和内存使用情况 
        $rs = '';
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);
        $sys_info = explode("\n",$rs);   
        $cpu_info = explode(",",$sys_info[0]);
        $mem_info = explode(",",$sys_info[1]);

        //判断centos是6.x系列还是7.x系列
        $centos_version_6= substr($centos_info[0],15,1);
        $centos_version_7= substr($centos_info[0],21,1);
        if($centos_version_6 == 6){ //centos6.X系列的 $centos_info 是 CentOS release 6.x (Final)
            $cpu_usage = trim(trim($cpu_info[0],'Cpu(s): '),'%us');
            $mem_total = trim(trim($mem_info[0],'Mem: '),'k total'); 
            $mem_used = trim($mem_info[1],'k used');
        }elseif($centos_version_7 == 7){ //centos7.X系列的 $centos_info 是 CentOS Linux release 7.x.1804 (Core)
            $cpu_usage = trim(trim($cpu_info[0],'%Cpu(s): '),'%us');
            $mem_total = trim(trim($mem_info[0],'KiB Mem: '),'total');
            $mem_used = trim($mem_info[1],'used');
        }
        $mem_usage = round(100*intval($mem_used)/intval($mem_total),2);
        $mem = substr((($mem_used/$mem_total)*100), 0,4);
        $cup_mem = [$cpu_usage,$mem];//CPU与内存使用率
        //判断是否是语言切换的提交
        if(Yii::$app->request->isGet){
            $language = Yii::$app->request->get('lang');
            if($language){
                $result = Common::change_language($language);
                if($result == 'success'){
                    return $this->redirect(['index/main']);
                } 
            }          
        }
        //退出本次登陆，销毁session，并返回登录页面
        $exit = Yii::$app->request->get('action'); 
        if($exit){
            //添加一条日志
            Log::add_log(1,8,'sign out','FW_server');
           return $this->redirect(['login/index']);
        } 
        return $this->renderPartial('main',['system_itme' =>$system_itme,'cup_mem' =>$cup_mem,'version'=>$version]);
    }  

}