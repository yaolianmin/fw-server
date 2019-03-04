<?php


namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Log;
use frontend\models\User;
use frontend\models\Common;
use yii\data\Pagination;

/**
* 日志管理显示控制器
* 功能 查看日志 导出日志
* 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
*       里面的含有所有的翻译中文语言
*
*
*
*  @copyright Copyright (c) 2017 – www.zwaveasia.com.cn
*  @author yaolianmin
*  @version 1.0 2017/10/26 14:06
*/


class LogController extends Controller{
    /**
     * 模块：日志管理页面
     * 作用：显示用户的日常记录
     */
    public function actionLog(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限

        // 1.1 判断此人是否拥有查看日志的权限
        $power_have =User::have_all_power($user_name); 
        if(!$power_have[9]){
            return $this->redirect(['device/device']);
        }
        // 1.2 获得这个人该看到的日志信息
        $time_be = Yii::$app->request->get('time_begin');
        $time_en = Yii::$app->request->get('time_end');
        $time_begin = strtotime($time_be); //查询的起始时间戳
        $time_end = strtotime($time_en);   // 查询的截止时间戳
        $page_now = Yii::$app->request->get('page'); // 获得当前的页数 
        $log_infor = Log::get_user_log_infor($user_name,$power,$page_now,$time_begin,$time_end); //每一页的详细内容
        $count = Log::get_user_count($user_name,$power,$time_begin,$time_end); // 总记录数
        $page  = new Pagination(['totalCount' =>$count[0]['count(id)'], 'pageSize' =>10]);  // yii 框架的分页组件
       
        // 1.3 搜索功能
        $search_log_infor = Yii::$app->request->get('search_user_name');
        if($search_log_infor){
            $log_infor = Log::get_this_user_log_infor($search_log_infor,$power,$user_name,$page_now); 
            $count = Log::get_this_user_log_infor_count($search_log_infor,$power,$user_name); // 总记录数
            $page  = new Pagination(['totalCount' =>$count[0]['count(id)'], 'pageSize' =>10]);  // yii 框架的分页组件 
        }
        // 1.4 下载功能
        $export = Yii::$app->request->get('export'); 
        if($export){
            $filename = '/var/www/fw-server/downloadExcel/'.$user_name.time().'.csv';//物理路径
            $new_path = substr($filename,33);
            $upload = fopen($filename,'w');
            //头部名称
            $ss = iconv('utf-8', 'gbk',Yii::t('yii','order').','.Yii::t('yii','user name').','.Yii::t('yii','log level').','.Yii::t('yii','log type').','.'IP'.','.Yii::t('yii','operation').','.Yii::t('yii','information')."\n"); //每一行都需要更换数据库的编码
            fwrite($upload, $ss);
            $i = 1;
            foreach ($log_infor as  $val) { 
                $bb = iconv('utf-8','gbk', $i.','.Yii::t('yii',$val['user_name']).','.Yii::t('yii',$val['log_level']).','.Yii::t('yii',$val['log_type']).','.Yii::t('yii',$val['login_ip']).','.date('Y-m-d H:i:s',$val['log_time']).','.Yii::t('yii',$val['action_info']).' '.Yii::t('yii',$val['info']).' '.Yii::t('yii',$val['item_info'])."\n");
                fwrite($upload, $bb);//写入每行内容
                $i++;
            } 
            if($filename){   
                $size = filesize($filename);
                Header('Content-Type:text/html;charset=utf-8'); //发送指定文件MIME类型的头信息
                Header("Content-type: application/octet-stream");
                Header("Accept-Ranges: bytes");
                Header("Content-Length:".$size); //发送指定文件大小的信息，单位字节
                Header("Content-Disposition:attachment; filename=".$new_path); //发送描述文件的头信息，附件和文件名     
                readfile($filename);      
            }   
            unlink($filename);// 删除刚才下载的日志
            //添加一条日志至数据库中
            Log::add_log(1,8,'download','log','');
            exit();
        }
        return $this->renderPartial('log',[
                                    'log_infor'=>$log_infor,
                                    'power_have'=>$power_have,
                                    'page'=>$page,
                                    'search_name'=>$search_log_infor,
                                    'time_be'=>$time_be,
                                    'time_en'=>$time_en
                                ]);
    }


    /**
     * 模块：日志设定模块
     * 作用：决定哪些日志需要存储
     */
    public function actionLog_set(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        // 1.1 搜索与这个人的日志设定
        $log_set = User::find()->select(['log_type','log_tips','log_warn','log_dev','log_file','log_item','log_system','log_user','log_upgrade'])->where(['user_name'=>$user_name])->asArray()->one();
        if(Yii::$app->request->get('log_set')){
            $log_type         = Yii::$app->request->get('log_type','0'); //日志操作
            $log_warn         = Yii::$app->request->get('log_warn','0'); //日至警告
            $log_tips         = Yii::$app->request->get('log_tips','0'); //日志提示
            $log_item         = Yii::$app->request->get('log_item','0'); //项目类
            $log_user         = Yii::$app->request->get('log_user','0'); // 用户类
            $log_file         = Yii::$app->request->get('log_file','0'); // 文件类
            $log_dev          = Yii::$app->request->get('log_dev','0'); // 机种类
            $log_system       = Yii::$app->request->get('log_system','0'); // 系统类
            $log_upgrade      = Yii::$app->request->get('log_upgrade','0'); // 升级类
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                User::updateALL(['log_type' =>$log_type,'log_warn' =>$log_warn,'log_tips' =>$log_tips,'log_item' =>$log_item,'log_user' =>$log_user,'log_file' =>$log_file,'log_dev' =>$log_dev,'log_system' =>$log_system,'log_upgrade' =>$log_upgrade],['user_name' =>$user_name]);
                //添加一条日志记录
                Log::add_log(1,8,'update','log setting');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return $this->redirect(['log/log']);
            }
            catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return false;
            }    
        } 
        return $this->renderPartial('log_set',['log_set'=>$log_set]);
    }

}



 