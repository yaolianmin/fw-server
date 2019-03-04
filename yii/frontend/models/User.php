<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use frontend\models\Device;
use frontend\models\Remark;
use frontend\models\User_dev;
use frontend\models\Item_attribute_connect;
use frontend\models\User_item;
use frontend\models\Log;



/**
* 模块：用户管理的模型
* 作用：链接数据库表 函数库供用户控制器调用
* 时间：2018-01-10
*
*/

class User extends ActiveRecord{

	//连接user_management表
    public static function tableName(){
        return '{{user}}';
    }

    /**
     * 功能：查询用户查询数据库的用户信息（user,user_dev,device三张表）
     * 参数： 用户名  $name
     * 返回：含有个人信息的数组
     */
    public function find_user_infor($name){
        //获得此人的权限 
        $power = Yii::$app->session['power'];

        if($power == 15){ //表示超级用户的查询
            $sql = 'select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.power < 14';
        }elseif($power == 10){
            $sql = 'select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.power < 10';
        }else{ //表示非超级用户
            //获得此人的uid
            $uid = User::get_user_id($name);
            $uid = $uid[0]['id'];

            $sql = 'select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.belong='.$uid;
        }

        $user_infor = Yii::$app->db->createCommand($sql)->queryAll();
        //以下的操作是处理一个用户对应多个机种的关系
        $infor = [];
        $user_names = [];
        foreach ($user_infor as $val) {

        	if(count($infor)==0){

        		array_push($infor,$val);
                array_push($user_names,$val['user_name']);
        	}elseif (in_array($val['user_name'],$user_names)) {
                $index = array_keys ($user_names,$val['user_name']);
        		$infor[$index[0]]['name']=$infor[$index[0]]['name'].' '.$val['name'];	

        	}else{
        		array_push($infor,$val);
                array_push($user_names,$val['user_name']);
        	} 	
        }
        return $infor;  
    }

    /**
     * 功能：模糊查询用户的信息
     * 参数：用户名 $search_name
     * 返回：含有此名的所有用户信息
     */
    public function serach_user($search_name){
        //获得查询人的权限
        $power = Yii::$app->session['power'];
        if($power == 15){ //表示超级用户查询的
            
            $sql = "select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.user_name like '%".$search_name."%'";
        }elseif($power == 10){
            $sql = "select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.power <9 and user.user_name like '%".$search_name."%'";
        }elseif( $power == 5){ //非超级用户
            //搜索自己的id
            $user_name = Yii::$app->session['name'];
            $uid = User::get_user_id($user_name);
            $uid = $uid[0]['id'];

            $sql = "select user.id,user.user_name,user.power,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.belong='".$uid."'&&user.user_name like '%".$search_name."%'";
        }
        
        $user_infor = Yii::$app->db->createCommand($sql)->queryAll();
        return $user_infor;
        //以下的操作是处理一个用户对应多个机种的关系
        $infor = [];
        $user_names = [];
        foreach ($user_infor as $val) {
            if(count( $infor)==0){

                array_push($infor,$val);
                array_push($user_names,$val['user_name']);
            }elseif (in_array($val['user_name'],$user_names)) {

                $index = array_keys ($user_names,$val['user_name']);
                $infor[$index[0]]['name']=$infor[$index[0]]['name'].' '.$val['name'];  

            }else{
                array_push($infor,$val);
                array_push($user_names,$val['user_name']);
            }   
        }
        return $infor;  
    }


    /**
     * 功能：根据用户名查询这个人拥有的用户信息(备注信息除外)
     * 参数：用户名 $user_name
     * 返回：含有这个人的所有信息的数组
     */
    public function find_user_infor_by_name($user_name,$user_id=''){
        if($user_name){
            if($user_id){
                $uid =$user_id;
            }else{
                //获得此人的uid
                $uid = User::get_user_id($user_name);
                $uid = $uid[0]['id'];
            }
            $sql = 'select user.*,device.name from user left join user_dev on user.id=user_dev.uid left join device on user_dev.did=device.id where user.id='.$uid;   
        }

        $user_infor = Yii::$app->db->createCommand($sql)->queryAll();
        //以下的操作是处理一个用户对应多个机种的关系
        $infor = [];
        $length = 0;
        foreach ($user_infor as $val) {

            if(count( $infor)==0){

                array_push($infor,$val);

            }elseif (in_array($val['user_name'],$infor[$length])) {

                $infor[$length]['name']=$infor[$length]['name'].'@@@@@'.$val['name'];   

            }else{
                array_push($infor,$val);
                $length +=1;
            }   
        }
        return $infor;  
    }

    /**
     * 功能：查找用户的备注信息
     * 参数：用户名 $user_name 
     * 返回：含有这个人的备注信息数组
     */
    public function find_user_remarks($user_name,$user_id=''){
        if($user_name){
            if($user_id){
                $uid = $user_id;
            }else{
                //获得此人的uid
                $uid = User::get_user_id($user_name);
                $uid = $uid[0]['id'];
            } 
           
            $user_remarks = Remark::find()->select('remarks')->where(['uid'=>$uid])->asArray()->all();
            return $user_remarks;
        }
    }


    /**
     * 功能：根据用户信息查找自己的id
     * 参数：  
     * 返回：每个人的个人信息
     */
    public function get_user_id($name){
    	if($name){
    		$id = User::find()->select('id')->where(['user_name'=>$name])->asArray()->all();
    	}
    	return $id;
    }

    /**
     * 功能：根据用户名查看是否拥有增删修的权限
     * 参数：用户名 $name
     * 返回：
     */
    public function is_have_power($name){
    	if($name){
    		$is_have = User::find()->select('own_user_look,own_user_aud')->where(['user_name'=>$name])->asArray()->all();
    		return $is_have;
    	}
    } 

    /**
     * 功能：查找所有的机种名
     * 参数
     * 返回
     */ 
    public function find_device(){
    	$device = Device::find()->select('name')->asArray()->all();
    	return $device;
    }


    /**
     * 功能：查找此人拥有的机种名
     * 参数：用户名 $name
     * 返回: 此人的所有机种
     */ 
    public function find_device_some($name){
        if($name){
            //获得此人的id,
            $uid = User::get_user_id($name);
            $uid = $uid[0]['id'];

            $sql = "select device.name from user_dev left join device on user_dev.did=device.id where user_dev.uid='".$uid."' order by user_dev.common_used desc";

            $device = Yii::$app->db->createCommand($sql)->queryAll();
        }
        return $device;
    }

    
    /**
     * 功能：根据机种名查该机种的id
     * 参数：$device_name
     * 返回：含有机种id二位数组
     */
    public function find_device_id($device_name){
    	$dev_id = Device::find()->select('id')->where(['name'=>$device_name])->asArray()->all();
    	return $dev_id;
    }

    /**
     * 功能：根据用户id查找用户名
     * 参数：$uid 
     * 返回：该用户的用户名数组
     *
     */
    public function find_user_name_by_uid($uid){
        $user_name = User::find()->select('user_name')->where(['id'=>$uid])->asArray()->one();
        return $user_name;
    }


    /**
     * 功能：查找用户名是否已经存在用户表
     * 参数：$user_name
     * 返回：查询的结果
     */
    public function find_name_is_repeat($user_name){
    	if($user_name){
    		$repeat = User::find()->where(['user_name'=>$user_name])->all();
            return $repeat;
    	}
    }


    /**
     * 功能：验证添加用户的数据是否合理
     * 参数：表单的数据 $post
     * 返回： 
     */
    public function date_is_resonble($post){
    	if(!$post['user_name']) return Yii::t('yii','The username can not be empty');

    	if(!$post['password'])  return Yii::t('yii','Password can not be empty');
    
    	if(!$post['re_password']) return Yii::t('yii','Password can not be empty');

    	if(!$post['power']||$post['power']=='请选择') return Yii::t('yii','Level can not be empty');

    	if(strlen($post['user_name'])>12) return Yii::t('yii','username too long');

    	if(!preg_match('/^[a-zA-Z0-9]{6,15}$/',$post['password'])) return Yii::t('yii','Password setting is not reasonable');

    	if($post['password']!=$post['re_password']) return Yii::t('yii','two password is not the same');
    }


    /**
     * 功能：查看此人拥有多少权限设定
     * 参数：用户名  $name
     * 返回：带有此人的所有权限设定的数
     */
    public function have_all_power($name){
        $user_informa = User::find()->where(['user_name'=>$name])->asArray()->all();
        $power_have = [];

        //以下的顺序与页面的顺序相同 不可修改
        array_push($power_have, $user_informa[0]['own_dev_look']); // 机种查看权        0
        array_push($power_have, $user_informa[0]['own_dev_aud']); // 机种增修删权       1
        array_push($power_have, $user_informa[0]['own_item_look']); // 项目查看权       2
        array_push($power_have, $user_informa[0]['own_item_aud']); // 项目增修删权      3
        array_push($power_have, $user_informa[0]['own_file_look']); // 文件查看权       4
        array_push($power_have, $user_informa[0]['own_file_upload']); // 文件上传权     5
        array_push($power_have, $user_informa[0]['own_file_download']); // 文件下载权   6
        array_push($power_have, $user_informa[0]['own_user_look']); // 用户查看权       7
        array_push($power_have, $user_informa[0]['own_user_aud']); // 用户增修删权      8
        array_push($power_have, $user_informa[0]['own_log_look']); // 日志查看权        9
        array_push($power_have, $user_informa[0]['own_log_download']); // 日志导出权   10
        array_push($power_have, $user_informa[0]['own_log_update']); // 日志修改设定权 11
        array_push($power_have, $user_informa[0]['own_upgrade']); // 升级权            12

        return $power_have;
    }


    /**
     * 功能：post提交的表单信息存入数据库中
     * 参数：表单的数据 $post
     * 返回：true false
     */
    public function add_new_user($get){
    	//权限设定数据处理 
    	$own_dev_look      = ($get['own_dev_look']      == 'true')?1:0; // 机种查看权
    	$own_dev_aud	   = ($get['own_dev_aud']       == 'true')?1:0;  // 机种增修删权
    	$own_item_look     = ($get['own_item_look']     == 'true')?1:0; // 项目查看权
    	$own_item_aud      = ($get['own_item_aud']      == 'true')?1:0; // 项目增修删权
    	$own_file_look     = ($get['own_file_look']     == 'true')?1:0; // 文件查看权
    	$own_file_upload   = ($get['own_file_upload']   == 'true')?1:0; // 文件上传权
    	$own_file_download = ($get['own_file_download'] == 'true')?1:0; // 文件下载权
    	$own_user_look     = ($get['own_user_look']     == 'true')?1:0; // 用户查看权
    	$own_user_aud      = ($get['own_user_aud']      == 'true')?1:0; // 用户增修删权
    	$own_log_look      = ($get['own_log_look']      == 'true')?1:0; // 日志查看权
    	$own_log_download  = ($get['own_log_download']  == 'true')?1:0; // 日志导出权
    	$own_log_update    = ($get['own_log_update']    == 'true')?1:0; // 日志修改设定权
    	$own_upgrade       = ($get['own_upgrade']       == 'true')?1:0; // 升级权

    	//密码处理
    	$password = md5($get['password']); // md5加密处理

    	//级别处理
    	if($get['power'] == 'PM'){
    		$power = '10';
    	}elseif ($get['power'] == 'FAE') {
    		$power = '5';
    	}elseif ($get['power'] == '普通用户') {
    		$power = '1';
    	}elseif ($get['power'] == '其他') {
    		$power = '-1';
    	}
        try{
            $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

            //获得添加者的id
            $adder_id = User::get_user_id(Yii::$app->session['name']);

            //存入数据库user表
            $user = new User();
            $user->user_name         = $get['user_name'];
            $user->password          = $password;
            $user->phone             = $get['phone'];
            $user->email             = $get['email'];
            $user->power             = $power;
            $user->own_dev_look      = $own_dev_look;
            $user->own_dev_aud       = $own_dev_aud;
            $user->own_item_look     = $own_item_look;
            $user->own_item_aud      = $own_item_aud;
            $user->own_file_look     = $own_file_look;
            $user->own_file_upload   = $own_file_upload;
            $user->own_file_download = $own_file_download;
            $user->own_user_look     = $own_user_look;
            $user->own_user_aud      = $own_user_aud;
            $user->own_log_look      = $own_log_look;
            $user->own_log_download  = $own_log_download;
            $user->own_log_update    = $own_log_update;
            $user->own_upgrade       = $own_upgrade;
            $user->belong            = $adder_id[0]['id']; 
            $user->save();

            //查找新用户的id
            $uid = User::get_user_id($get['user_name']);

            //存入该用户机种关系表(PM与超级管理员默认拥有所有机种)
            if($power<9){
                if(isset($get['user_dev'])){
                    foreach ($get['user_dev'] as $val) {
                            $dev_id = User::find_device_id($val);
                            $user_dev = new User_dev();
                            $user_dev->uid = $uid[0]['id'];
                            $user_dev->did = $dev_id[0]['id'];
                            $user_dev->save();
                    }
                }
            }else{ //查询所有的机种id逐一添加
                $dev_ids = Device::find()->select('id')->asArray()->all();
                if($dev_ids){
                    foreach ($dev_ids as $val) {
                        $user_dev = new User_dev();
                        $user_dev->uid = $uid[0]['id'];
                        $user_dev->did = $val['id'];
                        $user_dev->save();
                    }
                }
            }
                
            //存入该用户的备注信息表
                $remark = new Remark();
                $remark->uid = $uid[0]['id'];
                $remark->remarks = $get['remark'];  
                $remark->save(); 

            // 添加一条记录至日志表当中
            Log::add_log(1,5,'add',$get['user_name'],'user');
            $transaction->commit();//提交事务会真正的执行数据库操作
            return 'success';
        }catch(\Exception $e){
            $transaction->rollback();//如果操作失败, 数据回滚
            print_r($e->getMessage());
            return Yii::t('yii','database error');
        }
    }


    /**
     * 功能：修改用户信息，存入数据库的表当中
     * 参数：$post 提交的数据
     * 返回：true false
     */
    public function update_user_information($post){
        //获得用户的id
        $uid = $post['user_id'];

        //将信息存入用户表中
        User::updateAll(['own_dev_look'=>$post['own_dev_look'],
                        'own_dev_aud'=>$post['own_dev_aud'],
                        'own_item_look'=>$post['own_item_look'],
                        'own_item_aud'=>$post['own_item_aud'],
                        'own_file_look'=>$post['own_file_look'],
                        'own_file_upload'=>$post['own_file_upload'],
                        'own_file_download'=>$post['own_file_download'],
                        'own_user_look'=>$post['own_user_look'],
                        'own_user_aud'=>$post['own_user_aud'],
                        'own_log_look'=>$post['own_log_look'],
                        'own_log_download'=>$post['own_log_download'],
                        'own_log_update'=>$post['own_log_update'],
                        'own_upgrade'=>$post['own_upgrade']],['id'=>$uid]);
        
        // //先修改这个表中此人的备注信息
        Remark::updateAll(['remarks'=>$post['remark']],['uid'=>$uid]);
        //添加一条日志至表中
        Log::add_log(1,5,'update',$post['user_name'],'user');
        return true;
    }


    /**
     * 功能：根据ajax提交的机种，添加给这个人
     * 参数: 机种 $device  用户id $uid
     * 返回  boole
     */
    public  function ajax_add_device($device,$uid){
        $did = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();

        $user_dev = new User_dev();
        $user_dev->uid =$uid;
        $user_dev->did =$did['id'];
        $user_dev->save(); 
    }
    


    /**
     * 功能：根据ajax提交的机种，删除这个人的机种
     * 参数: 机种 $device  用户id $uid
     * 返回  boole
     */
    public  function ajax_delete_device($device,$uid){
        $did = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();

        User_dev::deleteAll(['uid'=>$uid,'did'=>$did['id']]);
    }
    

    /**
     * 功能：删除提交过来的所有用户
     * 参数：含有用户名id 的字符串 $del_name
     * 返回：true false
     */
    public function delete_all_user($del_name){
        if($del_name){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                foreach ($del_name as $val) { 
                    $user_name = User::find()->select('user_name')->where(['id'=>$val])->asArray()->one();
                    // 1. 删除这个人的机种关系
                    User_dev::deleteAll("uid='".$val."'");

                    // 2. 删除这个人的备注信息
                    Remark::deleteAll("uid='".$val."'");

                    // 3. 删除这个人的用户信息
                    User::deleteAll("user_name='".$user_name['user_name']."'");

                    // 4. 删除项目与人的关系表
                    Item_attribute_connect::deleteAll(['vaid'=>$val]);

                    // 5. 删除user_item 表
                    User_item::deleteAll(['uid'=>$val]);

                    //添加一条记录至日志表当中
                    Log::add_log(1,5,'delete',$user_name['user_name'],'user');
                }    
                $transaction->commit();//提交事务会真正的执行数据库操作   
                return true;
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
            }
           
        }
    }


    /**
     *功能：用户中心的用户信息修改（用户名 邮箱 手机号）
     *参数：post提交的信息
     *返回：success 
     */
    public function update_center_user_infor($post){
        if($post){
           User::updateAll(['user_name'=>$post['user_name'],'email'=>$post['email'],'phone'=>$post['phone']],['user_name'=>$post['hidden_user_name']]);

            Yii::$app->session['name'] = $post['user_name'];
            return 'success';
        }
    }
}
