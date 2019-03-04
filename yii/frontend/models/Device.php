<?php

/*
* 说明：由于此网站中复杂的逻辑关系，几乎每个查询操作都需要
*      连接多表，由于对yii框架多表的查询不熟悉，故这个模型中
*      大量的使用了原生sql语句查询
*
* 时间：2018-03-07
* @author
*/


namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\User;
use frontend\models\User_dev;
use frontend\models\Dev_attribute;
use frontend\models\Dev_attribute_val;
use frontend\models\Dev_att_connect;
use frontend\models\Dev_remark;
use frontend\models\Item_device;
use frontend\models\Version_name;
use frontend\models\Log;

class Device extends ActiveRecord{

	//连接device表
    public static function tableName(){
        return '{{device}}';
    }
    
    /**
     * 功能：查找此人的机种以及机种的 卡类型 设备类型 应用场景 品牌四个信息信息
     * 参数：用户名 $name
     * 返回：所有的机种信息数组
     * 说明：由于网站的需求复杂，一般的查询都是几张表联合，故大部分都是用了联合
     *       查询，代码
     */
    public function get_user_devs($name){
        try{  
           //获得此人的id,
            $uid = User::get_user_id($name);
            $uid = $uid[0]['id']; 

            $sql = "select device.id,device.name,dev_attribute.*,dev_attribute_val.vname from user_dev  
            left join device on user_dev.did=device.id  
            left join dev_attribute_connect on device.id=dev_attribute_connect.did 
            left join dev_attribute_val on dev_attribute_connect.vaid=dev_attribute_val.id 
            left join dev_attribute on dev_attribute_val.aid=dev_attribute.aid where user_dev.uid='".$uid."' order by user_dev.common_used desc"; 
            $device = Yii::$app->db->createCommand($sql)->queryAll();
            //以下操作处理数据 使得数据可以在前端直接循环显示
            $device_chu = Device::handle_device($device);
            return $device_chu;
        }catch(\Exception $e) {  
            return false;
        } 
    }
    
    /**
     * 功能：根据机种名模糊查询机种
     * 参数：机种名 $dev_name 权限 $power
     * 返回：此些机种的以及机种的相关信息
     */
    public function search_dev_by_name($dev_name,$power){
    	if($dev_name){
            try{
                $sql = "select device.id,device.name,dev_attribute.*,dev_attribute_val.vname from device 
                left join dev_attribute_connect on device.id=dev_attribute_connect.did 
                left join dev_attribute_val on dev_attribute_connect.vaid=dev_attribute_val.id 
                left join dev_attribute on dev_attribute_val.aid=dev_attribute.aid where device.name like '%".$dev_name."%'";
            
                $device = Yii::$app->db->createCommand($sql)->queryAll();
                 
                if($power<9){ //(超级)管理员以下的用户
                    //获得此人的用户名
                    $user_name = Yii::$app->session['name'];
                    //获得此人的id,
                    $uid = User::get_user_id($user_name);
                    $uid = $uid[0]['id']; 

                    $owe_sql = "select device.name from device left join user_dev on device.id=user_dev.did where user_dev.uid='".$uid."'";

                    $own_device = Yii::$app->db->createCommand($owe_sql)->queryAll();
                    $device_have = []; //此人拥有的机种
                    foreach ($own_device as $val) {
                        array_push($device_have, $val['name']);
                    }

                    //循环查询的总机种 过滤不属于自己的机种
                    $dev_have = [];
                    foreach ($device as $val) {
                        if(in_array($val['name'], $device_have)){
                            array_push($dev_have, $val);
                        }
                    }
                    $device = $dev_have;    
                }
                //处理数据。可以直接显示在前端页面
                $device_chu = Device::handle_device($device);
                return $device_chu;
            }
            catch(\Exception $e){
                return false;
            }
    		
    	}
    }


    /**
     * 功能：处理上面两个函数的查询机种数据 可以直接显示在前端
     * 参数：数据库查询的机种数据 $device
     * 返回：处理后直接显示机种的数组
     * 说明： 这里的1 代表品牌  2 代表应用场景 3代表卡类型 4 代表设备类型（可看数据库的aid字段）
     */
    public function handle_device($device){
    	$arr_dev_all = []; //存储返回的数据
        $arr_devs = [];  //显示不重复的机种 
        foreach ($device as $val) {
        	if(count($arr_dev_all) == 0){
        		if($val['aid']== 1){

        			$arr_dev_all[0]=['id'=>$val['id'],'device'=>$val['name'],'attribute'=>$val['vname']];
                    array_push($arr_devs,$val['name']);
        		}elseif ($val['aid']== 3 ) {

        			$arr_dev_all[0]=['id'=>$val['id'],'device'=>$val['name'],'card_type'=>$val['vname']];
                    array_push($arr_devs,$val['name']);
        		}elseif ($val['aid']== 4) {

        			$arr_dev_all[0]=['id'=>$val['id'],'device'=>$val['name'],'dev_type'=>$val['vname']];
                    array_push($arr_devs,$val['name']);
        		}elseif ($val['aid']== 2) {

        			$arr_dev_all[0]=['id'=>$val['id'],'device'=>$val['name'],'sence'=>$val['vname']];
                    array_push($arr_devs,$val['name']); 	
        		}	

        	}elseif(in_array($val['name'], $arr_devs)){  //判断是否是原来数组中有的
        		$index = array_search($val['name'], $arr_devs);

        		if($val['aid']== 1 ){
        			if(isset($arr_dev_all[$index]['attribute'])){

        				$arr_dev_all[$index]['attribute'] = $arr_dev_all[$index]['attribute'].' '.$val['vname'];
        			}else{

        				$arr_dev_all[$index]['attribute'] = $val['vname'];
        			}
        		}elseif ($val['aid']== 3) {

        			$arr_dev_all[$index]['card_type'] = $val['vname'];

        		}elseif ($val['aid']== 4) {

        			$arr_dev_all[$index]['dev_type'] = $val['vname'];
        			
        		}elseif ($val['aid']==2) {

        			$arr_dev_all[$index]['sence'] = $val['vname'];
        		}
        	}elseif(!in_array($val['name'], $arr_devs)){
        		$index = count($arr_devs);

        		if($val['aid']== 1){

        			$arr_dev_all[$index]=['id'=>$val['id'],'device'=>$val['name'],'attribute'=>$val['vname']];

        		}elseif ($val['aid']== 3 ) {

        			$arr_dev_all[$index]=['id'=>$val['id'],'device'=>$val['name'],'card_type'=>$val['vname']];

        		}elseif ($val['aid']== 4) {

        			$arr_dev_all[$index]=['id'=>$val['id'],'device'=>$val['name'],'dev_type'=>$val['vname']];

        		}elseif ($val['aid']==2) {

        			$arr_dev_all[$index]=['id'=>$val['id'],'device'=>$val['name'],'sence'=>$val['vname']];	
        		}else{
                    $arr_dev_all[$index]=['id'=>$val['id'],'device'=>$val['name']];
                }

        		array_push($arr_devs,$val['name']);	
        	}	
        }
        return $arr_dev_all;
    }


    /**
     * 功能：查询某机种的所有属性（私有属性除外）
     * 参数：
     * 返回：属性对应的属性值数组
     */
    public function find_all_attribute_vals(){
    	$sql = "select dev_attribute.aname,dev_attribute.aid,dev_attribute_val.vname from dev_attribute left join dev_attribute_val on dev_attribute.aid=dev_attribute_val.aid where dev_attribute.statue=1";

    	$attribute_val = Yii::$app->db->createCommand($sql)->queryAll();
    	//将品牌去除并整理数据
    	$arr_att = [];
    	$arr_vals = []; //存储需要的数据
    	foreach ($attribute_val as $val) {
    		if($val['aid']!= 1){ //代表不是品牌
    			if(count($arr_att) == 0){
    				$arr_vals[0]= ['attribute'=>$val['aname'],"0"=>$val['vname']];

    				array_push($arr_att, $val['aname']);
    			}elseif(in_array($val['aname'],$arr_att)){
    				$index = array_search($val['aname'],$arr_att);

    				array_push($arr_vals[$index], $val['vname']);
    			}else{
    				$index = count($arr_att);

    				$arr_vals[$index]= ['attribute'=>$val['aname'],"0"=>$val['vname']];
    				array_push($arr_att, $val['aname']);
    			}
    		}
    	}
    	return $arr_vals;
    }

    /**
     * 功能：查询此机种是否已经存在
     * 参数：机种名 $dev_name
     * 返回：查询的结果 
     */
    public function is_have_device($dev_name){
        $rel = Device::find()->where(['name'=>$dev_name])->asArray()->one();
        return $rel;
    }


    /**
     * 功能：添加机种
     * 参数：表单提交的数据 $dev_infor
     * 返回：success false
     */
    public function add_device_infor($dev_infor){
        $dev_name      = trim($dev_infor['dev_name']); //机种名
        $dev_att       = $dev_infor['attribute'];  //公有属性
        $dev_remarks   = trim($dev_infor['dev_remarks']);// 备注
        $dev_siyou     = isset($dev_infor['arr_siyou'])?$dev_infor['arr_siyou']:0; //私有属性
        $dev_siyou_val = isset($dev_infor['arr_siyou_val'])?$dev_infor['arr_siyou_val']:0; //私有属性值
        try{
            $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

            $dev_rel = new Device();
            $dev_rel->name = $dev_name;
            $dev_rel->save();
            $did = Device::find()->select('id')->where(['name'=>$dev_name])->asArray()->one(); //获得刚存入机种的id

            //公有属性处理
            foreach ($dev_att as $val) {
                $vaid = Dev_attribute_val::find()->select('id')->where(['vname'=>$val])->asArray()->one(); //属性值的id

                //存入关系表中
                $connect = new Dev_att_connect();
                $connect->did = $did['id'];
                $connect->vaid = $vaid['id'];
                $connect->save();
            }

            //私有属性的添加
            if($dev_siyou){
                foreach ($dev_siyou as $key => $val) {
                    //查看是否已经有此属性，如有则不需要添加
                    $siyou = Dev_attribute::find()->where(['aname'=>$val,'statue'=>0])->asArray()->one();
                    if(!$siyou){
                        $dev_attribute = new Dev_attribute();
                        $dev_attribute->aname = $val;
                        $dev_attribute->statue = 0;
                        $dev_attribute->save();
                    }

                    $aid = Dev_attribute::find()->select('aid')->where(['aname'=>$val,'statue'=>0])->asArray()->one();//属性id
                    $dev_attribute_val = new Dev_attribute_val();
                    $dev_attribute_val->vname = $dev_siyou_val[$key];
                    $dev_attribute_val->statue = 0;
                    $dev_attribute_val->aid =$aid['aid'];
                    $dev_attribute_val->save();

                    $vaid = Dev_attribute_val::find()->select('id')->where(['vname'=>$dev_siyou_val[$key],'statue'=>0])->asArray()->one();
                   //存入关系表中
                    $connect = new Dev_att_connect();
                    $connect->did = $did['id'];
                    $connect->vaid = $vaid['id'];
                    $connect->save();
                } 
            }

            //机种备注的处理
                $dev_remark = new Dev_remark();
                $dev_remark->dev_re_name = $dev_remarks;
                $dev_remark->did = $did['id'];
                $dev_remark->save();
    
            //因（超级）管理员默认拥有所有机种，故需要把此机种添加给所有权限大于9的管理员
            $uid = User::find()->select('id')->where(['>','power',9])->asArray()->all();
            foreach ($uid as $val) {
               $user_dev = new User_dev();
               $user_dev->uid = $val['id']; 
               $user_dev->did = $did['id'];
               $user_dev->save();
            }

            //添加一天增加机种的日志至记录中
            Log::add_log(1,7,'add',$dev_name,'device');
            $transaction->commit();//提交事务会真正的执行数据库操作
            return 'success';
        }
        catch( \Exception $e){
            $transaction->rollback();//如果操作失败, 数据回滚
            return false;
        }
    	
    }

    /**
     * 功能：查询机种的所有属性
     * 参数：
     * 返回：所有属性的数组
     */
    public function find_attributes(){
    	$attribute = Dev_attribute::find()->where(['statue'=>1])->select('aname')->asArray()->all();
    	return $attribute;
    }


    /**
     * 功能：查询机种属性对应的属性值
     * 参数：
     * 返回：所有属性值的数组
     */
    public function find_attribute_val($attribute=''){
    	if($attribute){
    		$aid = Dev_attribute::find()->where(['aname'=>$attribute,'statue'=>1])->select('aid')->asArray()->one();

    	}else{ //默认查找属性值为1

    		$aid = Dev_attribute::find()->select('aid')->asArray()->one();
    	}
    	$attribute_val = Dev_attribute_val::find()->where(['aid'=>$aid])->select('vname')->asArray()->all();

    	return $attribute_val;
    }


    /**
     * 功能：根据用户名查看此人是否有权限增删属性（值）
     * 参数：用户名 $user_name
     * 返回：0或1的二维数组
     */
    public function power_is_have($user_name){
    	if($user_name){
    		$power = User::find()->select('own_dev_aud')->where(['user_name'=>$user_name])->asArray()->all();
    		return $power;
    	}
    }


    /**
     * 功能：添加机种的属性
     * 参数：属性名 $add_attribute
     * 返回：success or 提示信息
     */
    public function add_attribute($add_attribute){
    	if($add_attribute){
    		//查找此属性名是否存在
    		$isset = Dev_attribute::find()->where(['aname' =>$add_attribute])->asArray()->all();
    		if($isset){
    			return '该属性已经存在!';
    		}
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

                $dev_attribute = new Dev_attribute();
                $dev_attribute->aname = $add_attribute;
                $dev_attribute->save();

                //添加一条增加属性的日志值记录中
                Log::add_log(1,7,'add',$add_attribute,'attribute');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return  'success';
            }
            catch(\Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return 'delete false,please do it again';
            }
    		
    	}
    }


    /**
     * 功能：查询这个属性的属性值是否已经被机种使用，如果使用，则不给删除
     * 参数：属性 $attribute
     * 返回：空或null表示 没有被使用 
     */
    public function attribute_is_have_used($del_attribute){
        if($del_attribute){
            $aid = Dev_attribute::find()->select('aid')->where(['aname'=>$del_attribute])->asArray()->one();
            
            //查询是否有属性值
            $vaid = Dev_attribute_val::find()->select('id')->where(['aid'=>$aid['aid']])->asArray()->all(); 
            if($vaid){
                if(count($vaid)>1){
                    foreach ($vaid as $val) {
                        $rel = Dev_att_connect::find()->where(['vaid'=>$val['id']])->asArray()->one();
                        if($rel){
                            return $rel; 
                        }
                    }
                }else{
                    $rel = Dev_att_connect::find()->where(['vaid'=>$vaid[0]['id']])->asArray()->one();
                    return $rel;
                }
            }else{
                return  false;
            }
        }  
    }


    /**
     * 功能：删除机种的属性
     * 参数：属性名 $del_attribute
     * 返回：success or false 
     */   
    public function del_attribute($del_attribute){
    	if($del_attribute){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

                //查找这个属性的id
                $aid = Dev_attribute::find()->select('aid')->where(['aname'=>$del_attribute])->asArray()->one(); 

                //删除此属性的所有属性值
                $del_aval = Dev_attribute_val::deleteAll("aid='".$aid['aid']."'");

                $del_rel = Dev_attribute::deleteAll("aname='".$del_attribute."'");

                //添加一天删除属性的日志至记录中
                Log::add_log(1,7,'delete',$del_attribute,'attribute');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success';
            }
            catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return 'delete false,please do it again';
            }
           
    	}
    }
 
    /**
     * 功能：添加机种的属性值
     * 参数：属性 $add_attribute_val  属性值 $add_attribute_vals
     * 返回：success or 提示信息
     */
    public function add_attribute_val($add_attribute_val,$add_attribute_vals){
    	if($add_attribute_val&&$add_attribute_vals){
            if(strlen($add_attribute_vals)>20){
                return Yii::t('yii','The length of the property is too long');
            }
    		//判断属性值是否已经存在
    		$isset = Dev_attribute_val::find()->where(['vname'=>$add_attribute_vals])->asArray()->all();
    		if($isset){
    			return Yii::t('yii','Property values already exist');
    		}
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                //查询属性的id
                $id =  Dev_attribute::find()->select('aid')->where(['aname'=>$add_attribute_val])->asArray()->one();
                if($id){
                    $add_vals = new Dev_attribute_val();
                    $add_vals->vname = $add_attribute_vals;
                    $add_vals->aid = $id['aid'];
                    $add_vals->save();

                    //添加一条增加属性的日志值记录中
                    Log::add_log(1,7,'add',$add_attribute_vals,'attribute values');
                    $transaction->commit();//提交事务会真正的执行数据库操作
                    return 'success';
                }
            }catch(\Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return 'add false,please do it again';
            }
    		
    	}
    }


    /**
     * 功能：判断此属性值是否已经被使用过，若使用，则不给删除
     * 参数：属性名 $attribute_val
     * 返回：查询的结果 null or  array
     */
    public  function attribute_val_is_used($attribute_val){
        if($attribute_val){
            $vaid = Dev_attribute_val::find()->select('id')->where(['vname'=>$attribute_val])->asArray()->one();

            $rel = Dev_att_connect::find()->where(['vaid'=>$vaid['id']])->asArray()->one();

            return $rel;
        }
    }

    /**
     * 功能：删除已有的属性值
     * 参数：属性值 $del_attribute_val
     * 返回：success false
     */
    public function delete_attribute_val($del_attribute_vals){
    	if($del_attribute_vals){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                $del_rel = Dev_attribute_val::deleteAll("vname='".$del_attribute_vals."'");

                //添加一条删除属性值的日志至记录中
                Log::add_log(1,7,'delete',$del_attribute_vals,'attribute values');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success';
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return 'delete false,please do it again';
            }
    		
    	}
    }


    /**
     * 功能：添加常用机种
     * 参数：机种名 $device
     * 返回：success or false
     */
    public function add_common_dev($device){
    	//查找这个机种的id
    	$id = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();

    	//修改这个人关系表中的字段
    	$user_name = Yii::$app->session['name'];

    	$uid = User::find()->select('id')->where(['user_name'=>$user_name])->asArray()->one();

    	User_dev::updateAll(['common_used'=>'1'],['uid'=>$uid['id'],'did'=>$id['id']]);

    	return 'success';
    }


    /**
     * 功能：删除常用机种
     * 参数：机种名 $device
     * 返回：success or false
     */
    public function del_common_dev($device){
    	//查找这个机种的id
    	$id = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();

    	//修改这个人关系表中的字段
    	$user_name = Yii::$app->session['name'];

    	$uid = User::find()->select('id')->where(['user_name'=>$user_name])->asArray()->one();

    	User_dev::updateAll(['common_used'=>'0'],['uid'=>$uid['id'],'did'=>$id['id']]);

    	return 'success';
    }

    /**
     * 功能：根据用户名查询机种 品牌 文件三者之间的关系
     * 参数：用户名 $name 机种 $dev_name，品牌 $attribute
     * 返回：此人拥有的机种 品牌 文件数组
     */
    public function find_dev_attribute_file_by_name($name,$dev_name='',$attribute=''){
        if($name){
            $arr_dev = User::find_device_some($name); // 这个人拥有的机种  .................................1

            if(!$dev_name){//表示第一次进入页面
                if(isset($arr_dev[0]['name'])){
                     $dev_search = $arr_dev[0]['name']; //默认过得一个机中的品牌含有的所有属性值
                }else{
                    $dev_search ='';
                }
            }else{
                $dev_search = $dev_name;
            } 

            $did = Device::find()->select('id')->where(['name'=>$dev_search])->asArray()->one();

            $pid = Dev_attribute::find()->select('aid')->where(['aname'=>'品牌'])->asArray()->one(); //品牌的id
            //查询机种含有的品牌值
            $sql1 = "select dev_attribute_val.vname  from dev_attribute_val left join dev_attribute on dev_attribute.aid=dev_attribute_val.aid left join dev_attribute_connect on dev_attribute_val.id=dev_attribute_connect.vaid where dev_attribute.aid='".$pid['aid']."' and dev_attribute_connect.did='".$did['id']."'";

            $sql = "select dev_attribute_val.vname from dev_file_connect left join dev_attribute_val on dev_file_connect.pid=dev_attribute_val.id where dev_file_connect.did='".$did['id']."'";

            $attribute_vals = Yii::$app->db->createCommand($sql)->queryAll();

            $pinpaizhi = Yii::$app->db->createCommand($sql1)->queryAll();

            //以下的操作是去除重复的品属性值 
            $pin = []; //将要存储的品牌属性值     ...........................................................2
            if(count($pinpaizhi)>1){
                foreach ($pinpaizhi as $val) {
                    if(count($pin) == 0){

                        array_push($pin, $val['vname']);

                    }elseif(!in_array($val['vname'],$pin)) {

                        array_push($pin, $val['vname']);
                    }
                }
            }elseif(count($pinpaizhi) == 1){
                array_push($pin,$pinpaizhi[0]['vname']);
            }

            if(!$attribute){ //表示第一次显示品牌对应的文件 （没有change 品牌的下拉框）
                if(!$pin){ //表示没有品牌
                    $file_name = [];   //将要存储的文件名   ...............................................3
                }else{
                    $search_pin = $pin[0]; //将要搜索这个品牌值含有的文件

                    $pid = Dev_attribute_val::find()->select('id')->where(['vname'=>$search_pin])->asArray()->one();

                    $sql = "select dev_file.fname from dev_file_connect left join dev_file on dev_file_connect.fid=dev_file.id where dev_file_connect.did='".$did['id']."' and dev_file_connect.pid='".$pid['id']."'";

                    $file_name = Yii::$app->db->createCommand($sql)->queryAll();
                }
            }else{ //表示参数带有品牌来查询的

                $search_pin = $attribute; //将要搜索这个品牌值含有的文件

                $pid = Dev_attribute_val::find()->select('id')->where(['vname'=>$search_pin])->asArray()->one();

                $sql = "select dev_file.fname from dev_file_connect left join dev_file on dev_file_connect.fid=dev_file.id where dev_file_connect.did='".$did['id']."' and dev_file_connect.pid='".$pid['id']."'";

                $file_name = Yii::$app->db->createCommand($sql)->queryAll();
            }

            $arr_return  = [];
            array_push($arr_return, $arr_dev);
            array_push($arr_return, $pin);
            array_push($arr_return, $file_name);

            return $arr_return;
        }
    }


    /**
     * 功能：根据文件名，查找文件是否已经存在
     * 参数：文件名 $file_name
     * 返回：true or false
     */
    public function  find_is_have_doc_name($file_name){
        if($file_name){
            $rel = Dev_file::find()->where(['fname'=>$file_name])->asArray()->one();
            return $rel;
        }   
    }

    /**
     * 功能：获得某一个机种的全部属性属性值(除品牌外)
     * 参数：机种名 $dev_name
     * 返回：该机种的详细信息
     */
    public function find_dev_infor_by_dev($dev_name){
        $sql = "select device.name,dev_attribute.*,dev_attribute_val.vname,dev_attribute_connect.id,dev_attribute_val.statue from device 
                left join dev_attribute_connect on device.id=dev_attribute_connect.did 
                left join dev_attribute_val on dev_attribute_connect.vaid=dev_attribute_val.id 
                left join dev_attribute on dev_attribute_val.aid=dev_attribute.aid where device.name='".$dev_name."'";
            
        $device = Yii::$app->db->createCommand($sql)->queryAll(); 
        return $device;
    }


    /**
     * 功能：获得某一个机种的品牌 对应的品牌值
     * 参数：机种名 $dev_name
     * 返回：该机种的详细信息
     */
    public function find_dev_pinpai_by_dev($dev_name){
        $sql = "select device.name,dev_attribute.*,dev_attribute_val.vname from device 
                left join dev_attribute_connect on device.id=dev_attribute_connect.did 
                left join dev_attribute_val on dev_attribute_connect.vaid=dev_attribute_val.id 
                left join dev_attribute on dev_attribute_val.aid=dev_attribute.aid where device.name='".$dev_name."'";
            
        $device = Yii::$app->db->createCommand($sql)->queryAll(); 

        //以下的操作是处理数据库查询的数据，可以直接返回给前端
        $arr = [];
        foreach ($device as $val) {
            if($val['statue'] == 1){

                array_push($arr,$val['vname']);
            }     
        }
        return $arr;
    }


    /**
     * 功能：根据机种名获得机种的备注信息
     * 参数: 机种名 $dev_name
     * 返回: 该机种的备注信息 数组
     */
    public function get_device_remarks($dev_name){
        if($dev_name){
            $did = Device::find()->select('id')->where(['name'=>$dev_name])->asArray()->one();
            $remarks = Dev_remark::find()->where(['did'=>$did['id']])->asArray()->one();

            return $remarks;
        }
    }

    /**
     * 功能：根据属性获得该属性的所有属性值
     * 参数：属性 $attribute
     * 返回：每个属性以及该属性的所有属性值
     */
    public function get_all_attribute_vals($dev_attribute){
        if($dev_attribute){
           $aid = Dev_attribute::find()->select('aid')->where(['aname'=>$dev_attribute,'statue'=>1])->asArray()->one();
           $att_val = Dev_attribute_val::find()->select('vname')->where(['aid'=>$aid])->asArray()->all();
           return $att_val;
        }
    }

    /**
     * 功能：根据品牌值，查看数据库机种的品牌值是否改变
     * 参数: 机种名 $attribute 属性值 
     * 返回：success  false;
     */
    public function checked_attribute_is_change($dev_name,$attribute){
        //先找到该机种拥有的所有品牌值
        $pinpnpai_old = Device::find_dev_pinpai_by_dev($dev_name); 
        $did = Device::find()->select('id')->where(['name'=>$dev_name])->asArray()->one(); //机种id
        foreach($attribute as $val){
            if( !in_array($val,$pinpnpai_old)){
                $vaid =  Dev_attribute_val::find()->select('id')->where(['vname'=>$val,'statue'=>1])->asArray()->one(); 
                $connect = new Dev_att_connect();
                $connect->did = $did['id'];
                $connect->vaid = $vaid['id'];
                $connect->save();       
            }
        }
        foreach ($pinpnpai_old as $val) {
            if(! in_array($val, $attribute)){
                $vaid =  Dev_attribute_val::find()->select('id')->where(['vname'=>$val,'statue'=>1])->asArray()->one(); // 品牌值id
                $rel = Dev_att_connect::deleteAll('did = :did AND vaid = :vaid', [':did'=>$did['id'], ':vaid'=>$vaid['id']]);
                   
            }
        }
    }


    /**
     * 功能：根据post表单提交的其他品牌值，查看是否改变
     * 参数：$post
     * 返回：success false
     */
    public function checked_other_attribute_is_change($post){
       foreach ($post['attribute_val'] as $key => $val) {

        $vaid = Dev_attribute_val::find()->select('id')->where(['vname'=>$val])->asArray()->one(); //查找这个属性值的id

        Dev_att_connect::updateAll(['vaid'=>$vaid['id']],['id'=>$post['att_id'][$key]]);  
       }
    }


    /**
     * 功能：新增机种的私有属性 属性值
     * 参数：机种名 $dev_name 属性 $attribute  属性值 $sttribute_val
     * 返回：success
     */
    public function add_new_attribute_val($dev_id,$attribute,$sttribute_val){
        if($attribute && $sttribute_val){
            $rel = Dev_attribute::find()->where(['aname'=>$attribute])->asArray()->all();
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                if(!$rel){
                    //增加属性 (状态为0 表示私有)
                    $dev_attribute = new Dev_attribute();
                    $dev_attribute->aname =$attribute;
                    $dev_attribute->statue = 0;
                    $dev_attribute->save();
                }
                //增加属性值
                $aid = Dev_attribute::find()->select('aid')->where(['aname'=>$attribute])->asArray()->one(); //该属性的id
                $dev_attribute_val = new Dev_attribute_val();
                $dev_attribute_val->vname = $sttribute_val;
                $dev_attribute_val->aid = $aid['aid'];
                $dev_attribute_val->statue = 0;
                $dev_attribute_val->save();

                //添加关系表
                $vaid = Dev_attribute_val::find()->select('id')->where(['vname'=>$sttribute_val])->asArray()->one();

                $connect = new Dev_att_connect();
                $connect->did = $dev_id;
                $connect->vaid = $vaid['id'];
                $connect->save();
                $transaction->commit();//提交事务会真正的执行数据库操作
            }catch(\Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return false;
            }
        return 'success';  
        }
    }


    /**
     * 功能：删除机种的私有属性属性值
     * 参数: 关系的id $att_id
     * 返回：success  false
     */
    public function del_dev_siyou_attribute($att_id){
        if($att_id){
            $ids = Dev_att_connect::find()->where(['id'=>$att_id])->asArray()->one();
          
            $aid = Dev_attribute_val::find()->select('aid')->where(['id'=>$ids['vaid']])->asArray()->one();

            $count = Dev_attribute_val::find()->where(['aid'=>$aid['aid']])->asArray()->all();
            if(count($count)<2){
                //删除属性表
                Dev_attribute::deleteAll(['aid'=>$aid['aid']]);
            }

            //删除 关系表
            Dev_att_connect::deleteAll(['id'=>$att_id]);
            
            //删除属性值表
            Dev_attribute_val::deleteAll(['id'=>$ids['vaid']]);

            return  'success';
        }
    }

    /**
     * 功能: 删除机种的备注信息
     * 参数：机种名 $dev_name 备注信息 $remark
     * 返回：success false
     */
    public function handle_dev_remarks($dev_name,$remark){
        if($dev_name){
            $did = Device::find()->select('id')->where(['name'=>$dev_name])->asArray()->one(); //机种id
            
            //先删除备注该机种的所有备注信息
            Dev_remark::updateAll(['dev_re_name'=>$remark[0]],['did'=>$did['id']]);

        }
    }


    /**
     * 功能：批量删除机种
     * 参数：机种id
     * 返回：success false
     */
    public function delete_all_devices($del_devices){
        if($del_devices){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

                foreach ($del_devices as $val) {
                    $device = Device::find()->select('name')->where(['id'=>$val])->asArray()->one(); //机种id
                    // 1.删除机种表
                    Device::deleteAll(['id'=>$val]);
                    // 2.删除机种属性值关系表
                    Dev_att_connect::deleteAll(['did'=>$val]);

                    // 3. 1 删除机种下的所有文件
                    $version_id = Version_name::find()->select('id')->where(['did'=>$val])->asArray()->all();
                    if($version_id){
                        foreach ($version_id as $vals){
                            $file_path = Dev_file::find()->select('path')->where(['vid'=>$vals['id']])->asArray()->all();
                            foreach ($file_path as $value) {
                                Dev_file::deleteAll(['path'=>$value['path']]);
                                unlink($value['path']);
                            } 
                        }
                    }
                    // 3.2 删除版本表
                    Version_name::deleteall(['did'=>$val]);
                    // 4.删除机种备注表
                    Dev_remark::deleteAll(['did'=>$val]);

                    // 5.删除人与机种的关系表
                    User_dev::deleteAll(['did'=>$val]);

                    // 6. 删除项目与机种的关系表
                    Item_device::deleteAll(['did'=>$val]);
                    
                    //添加一条删除记录至日志当中
                    Log::add_log(1,7,'delete',$device['name'],'device');
                }
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success'; 
            }
            catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return false;
            }
            
        }   
    }

    public function curlGetData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $header = array();
        
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 0);
        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }
}