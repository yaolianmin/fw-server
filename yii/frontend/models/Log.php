<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Login;
use yii\data\Pagination;
use frontend\models\Item;

/**
* Log 模型
* 日志管理模块
* 功能：供日志控制器调用
* 说明：此模块中有很多复杂的条件sql语句查询
*      由于对yii框架的分装的多条件函数查询不是十分熟悉
*      因此，大量的使用了联和原生条件语句查询
*
* @copyright Copyright (c) 2017 – www.zhiweiya.com
* @author yaolianmin
* @version 1.0 2017/10/26 10:06
*/

class Log extends ActiveRecord{

    //连接dev_attribute_val表
    public static function tableName(){
        return '{{log_information}}';
    }


    /**
     * 功能：根据用户的级别查询日志信息
     * 参数：用户名 $user_name  用户级别 $power  当前显示的页数 $page 时间 $time
     * 返回： 数组
     */
    public function get_user_log_infor($user_name,$power,$page,$time_begin,$time_end){
    	if(!$time_begin){
			$time_begin  = time()-604800; //一个星期之前的时间戳;
			$time_end = time();
    	}else {
    		$time_end = $time_end+86400;
    	}
    	if($page<2){
    		$begin = 0; //起始值
    	}else{
    		$begin = ($page-1)*10;
    	}
    	if($power == '15'){
    		$sql = "select * from log_information where log_time between ".$time_begin." and ".$time_end." order by log_time desc limit ".$begin.",10"; //每一页显示的数据

    	}elseif($power == '10'){
    		$sql = "select * from log_information where user_name='".$user_name."' and log_time between ".$time_begin." and ".$time_end." order by log_time desc limit ".$begin.",10";

    		$sql_other = "select * from log_information where log_power < '10' and log_time between ".$time_begin." and ".$time_end." order by log_time desc limit ".$begin.",10";

    		$log_infor_other = Yii::$app->db->createCommand($sql_other)->queryAll();

    	}elseif($power == '5'){
    		$uid = Item::get_user_id_by_name($user_name); //自己的id
    		$sql = "select * from log_information where belong='".$uid['id']."' and log_time between ".$time_begin." and ".$time_end." order by log_time desc limit ".$begin.",10";

    	}elseif($power<'5'){
    		$sql = "select * from log_information where user_name='".$user_name."' and log_time between ".$time_begin." and ".$time_end." order by log_time desc limit ".$begin.",10";

    	}

		$log_infor = Yii::$app->db->createCommand($sql)->queryAll();
    	if(isset($log_infor_other)){
    		if(count($log_infor)<10){ //判断查询自己的数量是否已经等于10个 
    			$length = count($log_infor_other);
    			for ($i=0; $i < $length; $i++) { 
    				array_push($log_infor,$log_infor_other[$i]);
    				if(count($log_infor) == 10){
    					break;
    				}
    			}
    		}
    	}
    	return $log_infor;
    }


    /**
     * 功能：获得条件查询的总记录数
     * 参数：用户名 $user_name  用户级别 $power 开始时间 $time_begin  结束时间 $time_end
     * 返回：array
     */
    public function get_user_count($user_name,$power,$time_begin,$time_end){
    	if(!$time_begin){
			$time_begin  = time()-604800; //一个星期之前的时间戳;
			$time_end = time();
    	}else {
    		$time_end = $time_end+86400;
    	}
    	if($power == '15'){
    		$count = "select count(id) from log_information where log_time between ".$time_begin." and ".$time_end; //查询的总记录数
    	}elseif($power == '10'){
			$count_self = "select count(id) from log_information where user_name='".$user_name."' and log_time between ".$time_begin." and ".$time_end;

    		$count = "select count(id) from log_information where log_power < '10' and log_time between ".$time_begin." and ".$time_end;

    		$self = Yii::$app->db->createCommand($count_self)->queryAll();
    		
    	}elseif($power == '5'){
    		$uid = Item::get_user_id_by_name($user_name); //自己的id
    		$count = "select count(id) from log_information where belong='".$uid['id']."' and log_time between ".$time_begin." and ".$time_end;
    		
    	}elseif($power<'5'){
    		$count = "select count(id) from log_information where user_name='".$user_name."' and log_time between ".$time_begin." and ".$time_end;
    	}

    	$count_arr = Yii::$app->db->createCommand($count)->queryAll();
    	if(isset($self)){
    			$count_arr[0]['count(id)'] = $self[0]['count(id)']+$count_arr[0]['count(id)'];
    	}

    	return $count_arr;
    }


    /**
     * 功能：根据用户名模糊查询这个人的所有日志信息 (这里写了一个漏洞，就是管理员的模糊查询 查不到自己的)
     * 参数：用户名 $search_name  查询人权限  $power
     * 返回：数组
     */
    public function get_this_user_log_infor($search_name,$power,$user_name,$page){
        if($page<2){
            $begin = 0; //起始值
        }else{
            $begin = ($page-1)*10;
        }
    	$uid = Item::get_user_id_by_name($user_name); //自己的id
    	if($power == '15'){
    		$sql = "select * from log_information where user_name like'%".$search_name."%' order by log_time desc limit ".$begin.",10";
    	}elseif($power == '10'){

			$sql = "select * from log_information where user_name like'%".$search_name."%' and log_power < '10' order by log_time desc limit ".$begin.",10";
    		
    	}elseif($power == '5'){

    		$sql = "select * from log_information where user_name like'%".$search_name."%' and belong='".$uid['id']."' order by log_time desc limit ".$begin.",10";
    	}elseif($power<'5'){
 
    		$sql = "select * from log_information where user_name='".$user_name."' order by log_time desc limit ".$begin.",10";
    	}

    	$user_log = Yii::$app->db->createCommand($sql)->queryAll();

    	return $user_log;
    }

    /**
     * 功能：根据用户名模糊查询这个人的所有日志信息的总记录数 (这里写了一个漏洞，就是管理员的模糊查询 查不到自己的)
     * 参数：用户名 $search_name  查询人权限  $power
     * 返回：数组
     */
    public function get_this_user_log_infor_count($search_name,$power,$user_name){
    	$uid = Item::get_user_id_by_name($user_name); //自己的id
    	if($power == '15'){
    		$sql = "select count(id) from log_information where user_name like'%".$search_name."%'";
    	}elseif($power == '10'){

			$sql = "select count(id) from log_information where user_name like'%".$search_name."%' and log_power < '10'";
    		
    	}elseif($power == '5'){

    		$sql = "select count(id) from log_information where user_name like'%".$search_name."%' and belong='".$uid['id']."'";

    	}elseif($power<'5'){

    		$sql = "select count(id) from log_information where user_name='".$user_name."'";
    	}

    	$user_log = Yii::$app->db->createCommand($sql)->queryAll();

    	return $user_log;
    }


    /**
     * 检测用户日志数量是否超过 1000条
     * 并导出、删除超过的部分
     * 参数：$user_name
     */  
    public function check_log_numbers($user_name){
        if($user_name){
            $count = Log::find()->where(['user_name' =>$user_name])->count();
            if($count>=1000){//代表超过规定数量

                $log_info = Log::find()->where(['user_name' =>$user_name])->orderBy('log_time asc')->limit(999)->asArray()->all();

                $filename = '/var/www/fw-server/downloadExcel/'.$user_name.time().'.csv';//物理路径
                $upload = fopen($filename,'w');
                $ss = iconv('utf-8', 'gbk',Yii::t('yii','order').','.Yii::t('yii','user name').','.Yii::t('yii','log level').','.Yii::t('yii','log type').','.'IP'.','.Yii::t('yii','operation').','.Yii::t('yii','information')."\n"); //每一行都需要更换数据库的编码
                fwrite($upload, $ss);
                $bb = '';
                foreach ($log_info as  $val) {   
                    $bb = iconv('utf-8','gbk', $i.','.Yii::t('yii',$val['user_name']).','.Yii::t('yii',$val['log_level']).','.Yii::t('yii',$val['log_type']).','.Yii::t('yii',$val['login_ip']).','.date('Y-m-d H:i:s',$val['log_time']).','.Yii::t('yii',$val['action_info']).' '.Yii::t('yii',$val['info']).' '.Yii::t('yii',$val['item_info'])."\n");
                     fwrite($upload, $bb);
                }

                $last_time = $log_info[998]['log_time'];//找到第999条日志所在的时间
                //删除数据库规定数量之前的日志
                Log::deleteAll('log_time < :log_time AND user_name = :user_name',[':log_time' =>$last_time,':user_name' =>$user_name]);
             
            }
        }
            
    }

    /**
     * 根据参数添加一条日志信息 
     * 参数 $log_level(日志级别) $log_type(日志类型) $action(行为) 信息 模块 
     * 说明： 添加动作请用 add   修改请用 update  删除 请用 delete 
     * @return true
     */
    public function add_log($log_level,$log_type,$action,$info,$item=''){
        //定义日志级别和类型
        $log_number = [
            //以下三个是日志级别
            1   => 'log_type', //日志操作    
            2   => 'log_warn', //日志警告    
            3   => 'log_tips', //日志提示    
            
            //以下六个是日志类型
            4   => 'log_item', //日志项目    
            5   => 'log_user', //日志用户    
            6   => 'log_file', //日志文件    
            7   => 'log_dev', //日志机种    
            8   => 'log_system', //日志系统    
            9   => 'log_upgrade' //日志升级    
        ];
    
        //用户管理模块信息
        /**
         * add 名字 user             例如 add zhangsan user
         * update 名字 information   例如 update zhangsan information
         * delete 名字 user          例如 delete zhangsan user
         */

        //对应的名称 这里到时需要更改成英文
        $chinese_names = [
            'log_type'      => 'operation', //操作
            'log_warn' => 'warning', //警告
            'log_tips'  => 'tips', //提示
            'log_item'      => 'item', //项目
            'log_user'         => 'user', //用户
            'log_file'         => 'file', //文件
            'log_dev'       => 'device', //机种
            'log_system'       => 'system', //系统
            'log_upgrade'      => 'upgrade'  //升级
        ];

        $power = Yii::$app->session['power']; //权限
        $user_name = Yii::$app->session['name']; //用户名
        if($user_name){
            //查询此用户的日志设定(判断该日志是否需要存储)
            if($power==5){
            	$log_set_option = Login::find()->select([$log_number[$log_level],$log_number[$log_type],'power','id'])->where(['user_name' =>$user_name])->asArray()->one();
            }else{
            	$log_set_option = Login::find()->select([$log_number[$log_level],$log_number[$log_type],'power','belong'])->where(['user_name' =>$user_name])->asArray()->one();
            }
            
            //判断用户日志设定是否需要存储 
            if($log_set_option[$log_number[$log_level]] && $log_set_option[$log_number[$log_type]]) {

                $time = time();//获得当前日志操作时间
                $IP = $_SERVER['REMOTE_ADDR'];//获得当前日志操作的IP
                $log_l = $chinese_names[$log_number[$log_level]]; //日志级别
                $log_t = $chinese_names[$log_number[$log_type]]; //日志类型
      
                //存入日志表当中
                $log_insert = new Log();
                $log_insert->user_name = $user_name;
                $log_insert->log_level = $log_l;
                $log_insert->log_type  = $log_t;
                $log_insert->login_ip  = $IP;
                $log_insert->log_time  = $time;
                $log_insert->action_info  = $action;
                $log_insert->item_info = $item;
                $log_insert->info      = $info;
                $log_insert->log_power = $log_set_option['power'];
                if($power==5){
                	$log_insert->belong = $log_set_option['id'];
                }else{
                	$log_insert->belong = $log_set_option['belong'];
                }
                $log_insert->save();

                return true;
            } 
        }
    }
}