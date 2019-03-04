<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use frontend\models\User;
use frontend\models\User_dev;
use frontend\models\Device;
use frontend\models\Item_attribute;
use frontend\models\Item_attribute_val;
use frontend\models\Item_attribute_connect;
use frontend\models\User_item;
use frontend\models\Item_remarks;
use frontend\models\Item_device;
use frontend\models\Item_siyou;
use frontend\models\Item_file;
use frontend\models\Log;

class Item extends ActiveRecord{

    //连接item表
    public static function tableName(){
        return '{{item}}';
    }

    /**
     * 功能：获得用户的id
     * 参数：用户名 $user_name
     * 返回: 该用户的id数组
     */
    public function get_user_id_by_name($user_name){
        if($user_name){
            $id = User::find()->select('id')->where(['user_name'=>$user_name])->asArray()->one();
            return $id;
        }
    }

    /**
     * 功能：FAE获得自己的用户
     * 参数：用户名 $user_name
     * 返回：所有用户用户名的数组
     */
    public function get_self_user($user_name){
        if($user_name){
            $id = Item::get_user_id_by_name($user_name);
            $user = User::find()->select('user_name')->where(['belong'=>$id['id']])->asArray()->all();
            return $user;
        }
    }

    /**
     * 功能：（超级）管理员获得普通的用户
     * 参数：
     * 返回：所有用户用户名的数组
     */
    public function get_all_user(){
        $user = User::find()->select('user_name')->where(['<','power',5])->asArray()->all();
        return $user;
    }

    /**
     * 功能：获得自己拥有的机种
     * 参数：用户名 $user_name
     * 返回：所有机种的机种名
     */
    public function get_self_device($user_name){
        if($user_name){
            $id = Item::get_user_id_by_name($user_name);
            $sql = "select device.name from user_dev left join device on user_dev.did=device.id where user_dev.uid='".$id['id']."'";
            $device = Yii::$app->db->createCommand($sql)->queryAll(); 
            return $device;
        }   
    }

    /**
     * 功能：新增项目，存入数据库 （项目管理者 项目所属客户 项目所需机种 三者的名字固定，整个网站不可随意更改）
     * 参数：get表单提交的信息 $get
     * 返回：success false
     * 说明：用户大约有四个级别的用户（管理员、PM FAE 普通用户）其中，FAE创建的项目可以看到的有 所有的pm 管理员
     *       和与项目有关的普通用户，PM创键的项目 看到项目的有 管理员 自己 与项目有关的fae和普通用户
     *       管理员创建的项目 能看到的有 与项目相关的pm 或fae或普通用户
     */
    public function store_item_inforamtion($get){
        if($get){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                // 1.1 查询三个属性的id
                $att_fae = Item_attribute::find()->select('aid')->where(['aname'=>'项目管理者','statue'=>1])->asArray()->one(); //管理者属性id
                $att_user = Item_attribute::find()->select('aid')->where(['aname'=>'项目所属客户','statue'=>1])->asArray()->one();//所属客户id
                $att_dev = Item_attribute::find()->select('aid')->where(['aname'=>'项目所需机种','statue'=>1])->asArray()->one(); //所属机种id
                if(!$att_fae['aid']||!$att_user['aid']||!$att_dev['aid']){
                    return Yii::t('yii','Error of database information');
                }
                // 1.2 添加项目至项目表
                $item = new Item();
                $item->item_name = $get['item_name'];
                $item->save();

                $iid = Item::find()->select('id')->where(['item_name'=>$get['item_name']])->asArray()->one(); //项目id
                // 1.3 添加项目的属性值至项目管理表中 并把这个项目的权利分给该fae用户
                $pm_id = [];
                foreach ($get['user_manage'] as $val) {
                    $uid = Item::get_user_id_by_name($val);
                    if(!$uid){
                        return Yii::t('yii','item managers do not exist');
                    }
                    $item_att_val = new Item_attribute_connect();
                    $item_att_val->iid = $iid['id'];
                    $item_att_val->vaid = $uid['id'];
                    $item_att_val->aid = $att_fae['aid'];
                    $item_att_val->save();

                    $user_item = new User_item();
                    $user_item->uid = $uid['id']; 
                    $user_item->iid = $iid['id'];
                    $user_item->save();

                    array_push($pm_id,$uid['id']);
                }
                if(isset($get['user_client'])){ //项目所属客户存入关系表中
                    foreach ($get['user_client'] as $val) {
                        $uid = Item::get_user_id_by_name($val);
                        $item_att_val = new Item_attribute_connect();
                        $item_att_val->iid =$iid['id'];
                        $item_att_val->vaid =$uid['id'];
                        $item_att_val->aid =$att_user['aid'];
                        $item_att_val->save();

                        $user_item = new User_item();
                        $user_item->uid = $uid['id']; 
                        $user_item->iid = $iid['id'];
                        $user_item->save();
                    }
                }
                foreach ($get['user_device'] as $val) {
                    $did = Device::find()->select('id')->where(['name'=>$val])->asArray()->one();
                    $item_att_val = new Item_device();
                    $item_att_val->iid =$iid['id'];
                    $item_att_val->did =$did['id'];
                    $item_att_val->save();
                }
                
                // 1.4 查询每个fae的用户是否都有管理员添加的机种，若没有，自行添加
                if($get['user_manage']){
                    foreach ($get['user_manage'] as $val) {
                        $uid = Item::get_user_id_by_name($val);
                        foreach ($get['user_device'] as $dev_val) {
                            $did = Device::find()->select('id')->where(['name'=>$dev_val])->asArray()->one(); 
                            $rel = User_dev::find()->where(['uid'=>$uid['id'],'did'=>$did['id']])->asArray()->one();
                            if(empty($rel)){
                                $user_dev = new User_dev();
                                $user_dev->uid = $uid['id'];
                                $user_dev->did = $did['id'];
                                $user_dev->save();
                            }
                        }
                    }
                }
                // 1.5 是否存在私有属性和属性值
                if(isset($get['user_siyou'])){
                    foreach ($get['user_siyou'] as $key => $val) {
                        $rel = Item_attribute::find()->where(['aname'=>$val,'statue'=>0])->asArray()->one();
                        if(!$rel){
                            $item_attribute = new Item_attribute();
                            $item_attribute->aname = $val;
                            $item_attribute->statue = 0;
                            $item_attribute->save();
                        }
                        $aid = Item_attribute::find()->select('aid')->where(['aname'=>$val,'statue'=>0])->asArray()->one();
                        $item_attribute_val = new Item_attribute_val();
                        $item_attribute_val->vname =$get['user_siyou_val'][$key]; 
                        $item_attribute_val->aid = $aid['aid'];
                        $item_attribute_val->statue = 0;
                        $item_attribute_val->save();

                        $vaid = Item_attribute_val::find()->select('id')->where(['vname'=>$get['user_siyou_val'][$key]])->asArray()->one(); 
                        $item_siyou_connect = new Item_siyou();
                        $item_siyou_connect->iid = $iid['id'];
                        $item_siyou_connect->vaid = $vaid['id'];
                        $item_siyou_connect->save();
                    }
                }
                // 1.6 添加项目备注值备注表中
                $item_reamrks = new Item_remarks();
                $item_reamrks->iname = $get['remark'];
                $item_reamrks->iid = $iid['id'];
                $item_reamrks->save();
                // 1.7 将这个项目默认添加给超级管理员
                $sup_user = User::find()->select('id')->where(['power'=>15])->asArray()->one();
                $user_dev = new User_item();
                $user_dev->uid = $sup_user['id']; 
                $user_dev->iid = $iid['id'];
                $user_dev->save();

                // 1.8 检测添加项目的人是否是fae,如果是，则把这个项目自动添加给所有的pm用户 
                if(Yii::$app->session['power'] == 5){
                    $pm_uids = User::find()->select('id')->where(['power' =>'10'])->asArray()->all();
                    if($pm_uids){
                        foreach ($pm_uids as $val) {
                            $user_dev = new User_item();
                            $user_dev->uid = $val['id']; 
                            $user_dev->iid = $iid['id'];
                            $user_dev->save();
                        }
                    } 
                }
                /**
                 * 说明：1.9 此处应该判断添加的人是否为 PM  
                 *     因pm创建的项目只有 admin 自己和项目相关人员能看到
                 *     因此，此处如果不判断，则PM会看不见自己创建的项目
                 */
                if( Yii::$app->session['power'] == 10){
                    // 检测是否把自己添加到项目中
                    $pm_name = Item::get_user_id_by_name(Yii::$app->session['name']);
                    $rel = User_item::find()->where(['uid'=>$pm_name['id'],'iid'=>$iid['id']])->asArray()->one();
                    if(!$rel){ //代表这个项目没有自己
                        $user_dev = new User_item();
                        $user_dev->uid = $pm_name['id']; 
                        $user_dev->iid = $iid['id'];
                        $user_dev->save();  
                    }
                }
                    
                //添加一条日志至数据库中
                Log::add_log(1,4,'add',$get['item_name'],'item');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success';   
            }catch(\Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return Yii::t('yii','database error');   
            }
        }
    }

    /**
     * 功能：修改项目的信息 
     * 参数@param:$item_infor
     * 返回@return：success 或者提示
     */
     public function update_item_information($item_infor){
        $find_item_name = Item::find()->select('item_name')->where(['id'=>$item_infor['item_id']])->asArray()->one();
        if(!$find_item_name) return Yii::t('yii','this item does not exist in the database');
        if($find_item_name['item_name'] != $item_infor['item_name']){ //检测此次是否更换项目名称
            $item_is_have = Item::find()->where(['item_name'=>$item_infor['item_name']])->asArray()->one();
            if($item_is_have)  return Yii::t('yii','The name of the item has already existed. Please rename it again');
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                Item::updateAll(['item_name'=>$item_infor['item_name']],['id'=>$item_infor['item_id']]);
                $transaction->commit();//提交事务会真正的执行数据库操作
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return Yii::t('yii','database error');
            }
        }
        $find_item_remark = Item_remarks::find()->where(['iid'=>$item_infor['item_id']])->asArray()->one();
        if(!isset($find_item_remark['iid'])){
            $item_remark = new Item_remarks();
            $item_remark->iname = $item_infor['remark'];
            $item_remark->iid = $item_infor['item_id'];
            $item_remark->save();
        }elseif($find_item_remark['iname'] != $item_infor['remark']){
            Item_remarks::updateAll(['iname'=>$item_infor['remark']],['iid'=>$item_infor['item_id']]);
        }
        if(isset($item_infor['item_siyou'])){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                foreach ($item_infor['item_siyou'] as $key => $val) {
                    $is_have_att = Item_attribute::find()->where(['aname'=>$val,'statue'=>0])->asArray()->one();
                    if(!$is_have_att){
                        $item_attirbute = new Item_attribute();
                        $item_attirbute->aname = $val;
                        $item_attirbute->statue = 0;
                        $item_attirbute->save();
                    }
                    $aid = Item_attribute::find()->select('aid')->where(['aname'=>$val])->asArray()->one();
                    $item_val = new Item_attribute_val();
                    $item_val->vname = $item_infor['item_siyou_val'][$key];
                    $item_val->aid = $aid['aid'];
                    $item_val->statue = 0;
                    $item_val->save();

                    $vaid = Item_attribute_val::find()->select('id')->where(['vname'=>$item_infor['item_siyou_val'][$key]])->asArray()->one();
                    $item_siyou = new Item_siyou();
                    $item_siyou->iid = $item_infor['item_id']; 
                    $item_siyou->vaid =  $vaid['id'];
                    $item_siyou->save();  
                }
                $transaction->commit();//提交事务会真正的执行数据库操作  
                Log::add_log(1,5,'update',$item_infor['item_name'],'item');
                return 'success';
            }catch(\Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                print $e->getMessage();
                return Yii::t('yii','database error');
            }
        }
        return 'success';
     }

    /**
     *功能：查询每个人拥有的项目名
     *参数：用户名
     *@return：项目信息的数组
     */
    public function get_item_information_by_name($user_name){
        $uid = Item::get_user_id_by_name($user_name); 
        // 1.1 查询项目管理者 项目所属客户
        $sql1 = "select item.id,item.item_name,user.user_name,item_attribute.* from user_item 
        left join item on user_item.iid=item.id 
        left join item_attribute_connect on item.id=item_attribute_connect.iid 
        left join user on item_attribute_connect.vaid=user.id 
        left join item_attribute on item_attribute_connect.aid=item_attribute.aid
        where user_item.uid='".$uid['id']."'  order by user_item.common_used desc";
        $item1 = Yii::$app->db->createCommand($sql1)->queryAll(); //项目管理者 项目所属客户
        // 1.2  查询项目所需机种
        $sql2 = "select item.item_name,device.name from user_item left join item on user_item.iid=item.id 
        left join item_device on item.id=item_device.iid left join device on item_device.did=device.id where user_item.uid='".$uid['id']."'";
        $item2 = Yii::$app->db->createCommand($sql2)->queryAll(); //项目所需机种
        
        /*******不知为何，为pm的时候，会出现查询重复的数据，因此需要去重处理*****/
        // if(Yii::$app->session['power'] == '10'){
        //     $arr = [];
        //     foreach ($item1 as $key1 => $val) {
        //         foreach ($item1 as $key2 => $val2) {
        //             if($key1 != $key2){
        //                 if(!array_diff($val,$val2)){
        //                     array_push($arr,$key2);
        //                 }
        //             }
        //        }
        //     }
        //     if($arr){
        //         foreach ($arr as $val) {
        //             array_splice($item1, $val,1); // 去除$item1中的重复
        //         }
        //     }
        //     $arr1 = [];
        //     // 去除$item2中的重复数组
        //     foreach ($item2 as $key3 => $val3) {
        //         foreach ($item2 as $key4 => $val4) {
        //             if( $key3 != $key4){
        //                 if($val3['item_name'] ==$val4['item_name']){
        //                     array_push($arr1, $key3);
        //                 }
        //             }
        //        }
        //     }
        //     if($arr1){
        //         foreach ($arr1 as $val) {
        //             array_splice($item2, $val,1); // 去除$item1中的重复
        //         }
        //     }
        // }
        // 1.3 调用下面的函数，处理两次查询的结果
        $handle_infor = Item::handle_db_information_by_infor($item1,$item2);
        return $handle_infor;
    }


    /**
     * 功能：根据项目名模糊搜索项目
     * 参数：项目名 $item_name  用户名 $user_name
     * 返回：项目的信息
     */
    public function search_item_infor_by_name($item_name,$user_name){
        $uid = Item::get_user_id_by_name($user_name);  
         // 1.1 查询项目管理者 项目所属客户
        $sql1 = "select item.id,item.item_name,user.user_name,item_attribute.* from item 
        left join user_item on item.id=user_item.iid 
        left join item_attribute_connect on item.id=item_attribute_connect.iid 
        left join item_attribute on item_attribute_connect.aid=item_attribute.aid 
        left join user on item_attribute_connect.vaid=user.id 
        where item.item_name like '%".$item_name."%' and user_item.uid='".$uid['id']."'";
        $item1 = Yii::$app->db->createCommand($sql1)->queryAll(); //项目管理者 项目所属客户
        // 1.2  查询项目所需机种
        $sql2 = "select item.item_name,device.name from item 
        left join user_item on item.id=user_item.iid 
        left join item_device on user_item.iid=item_device.iid 
        left join device on item_device.did=device.id 
        where item.item_name like '%".$item_name."%' and user_item.uid='".$uid['id']."'";
        $item2 = Yii::$app->db->createCommand($sql2)->queryAll(); //项目所需机种

        /*******不知为何，为pm的时候，会出现查询重复的数据，因此需要去重处理*****/

        // 1.3 调用下面的函数，处理两次查询的结果
        $handle_infor = Item::handle_db_information_by_infor($item1,$item2);
        return $handle_infor;
    }

    /**
     * 功能：对上面两个函数数据库查询的结果进行处理
     * 参数：数据库查询结果1 $item1  数据库查询结果2 $item2 
     * 返回：可直接显示在前端的数据
     * 说明：1代表项目管理者 2代表项目所属客户 
     */
    public function handle_db_information_by_infor($item1,$item2){
        // 1.3 下面的foreach函数是处理1.1操作查询的结果
        $arr1 = [];
        $arr2 = [];
        foreach ($item1 as $val) {
            if(count($arr1)==0){
                if($val['aid']== 1 ){
                    $arr2[0]=['item_name'=>$val['item_name'],'iid'=>$val['id'],'manager'=>$val['user_name']];
                    $arr1[0] = $val['item_name'];
                }elseif($val['aid']== 2){
                    $arr2[0]=['item_name'=>$val['item_name'],'iid'=>$val['id'],'item_user'=>$val['user_name']];
                    $arr1[0] = $val['item_name']; 
                }
            }elseif(in_array($val['item_name'], $arr1)){
                $index = array_search($val['item_name'],$arr1); //位置
                if($val['aid']==1){
                    if(isset($arr2[$index]['manager'])){
                        $arr2[$index]['manager'] = $arr2[$index]['manager'].' '.$val['user_name'];
                    }else{
                        $arr2[$index]['manager'] = $val['user_name'];
                    }
                }elseif($val['aid']==2){
                    if(isset($arr2[$index]['item_user'])){
                        $arr2[$index]['item_user'] = $arr2[$index]['item_user'].' '.$val['user_name'];
                    }else{
                        $arr2[$index]['item_user'] = $val['user_name'];
                    }
                }
            }else{
                $indesx = count($arr1);
                 if($val['aid']==1){
                    $arr2[$indesx]=['item_name'=>$val['item_name'],'iid'=>$val['id'],'manager'=>$val['user_name']];
                }elseif($val['aid']== 2){
                    $arr2[$indesx]=['item_name'=>$val['item_name'],'iid'=>$val['id'],'item_user'=>$val['user_name']];
                }
                $arr1[$indesx] = $val['item_name'];
            }    
        }
        // 1.4 下面的foreach是处理1.2查询的机种结果
        $arr3 =[];
        $arr4 =[];
        foreach ($item2 as $val) {
            if(count($arr3)==0){
                $arr4[0]=['item_name'=>$val['item_name'],'device'=>$val['name']];
                $arr3[0]=$val['item_name'];
            }elseif(in_array($val['item_name'], $arr3)){
                $index = array_search($val['item_name'],$arr3); //位置
                $arr4[$index]['device']= $arr4[$index]['device'].' '.$val['name'];
            }else{
                $indesx = count($arr3);
                $arr4[$indesx]=['item_name'=>$val['item_name'],'device'=>$val['name']];
                $arr3[$indesx] = $val['item_name'];
            }
        }
        // 1.5 将1.3与1.4的结果整合在一起返回
        foreach ($arr4 as $val) {
            foreach ($arr2 as $key => $value) {
                if($val['item_name']==$value['item_name']){
                    $arr2[$key]['device']= $val['device'];
                }   
            }
        }
        return $arr2;  
    }



    /**
     * 功能：查询该用户拥有的项目
     * 参数：用户名 $user_name
     * 返回：项目的数组
     */ 
    public function get_all_items_by_user_name($user_name){
        if($user_name){
            $uid = Item::get_user_id_by_name($user_name);
            $sql = "select item.item_name from user_item left join item on user_item.iid=item.id where user_item.uid='".$uid['id']."' order by user_item.common_used desc";
            $items = Yii::$app->db->createCommand($sql)->queryAll(); //项目所需机种
            return $items;
        }
    }


    /**
     * 功能：添加常用的项目
     * 参数：项目名 $item_name 用户名 $user_name
     * 返回：'success'
     */
    public function add_common_item($item_name,$user_name){
        if($item_name){
            $uid = Item::get_user_id_by_name($user_name);
            $iid = Item::find()->select('id')->where(['item_name'=>$item_name])->asArray()->one();
            $rel = User_item::updateAll(['common_used'=>1],['uid'=>$uid['id'],'iid'=>$iid['id']]);
            return 'success';
        }
    }


    /**
     * 功能：删除常用的项目
     * 参数：项目名 $item_name 用户名 $user_name
     * 返回：'success'
     */
    public function del_common_item($item_name,$user_name){
        if($item_name){
            $uid = Item::get_user_id_by_name($user_name);
            $iid = Item::find()->select('id')->where(['item_name'=>$item_name])->asArray()->one();
            $rel = User_item::updateAll(['common_used'=>0],['uid'=>$uid['id'],'iid'=>$iid['id']]);
            return 'success';
        }
    }


    /**
     * 功能：添加项目的文件信息
     * 参数：post传递的数据 $post
     * 返回： success false
     */
    public function add_item_file($post){
        if($post){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                
                $iid =Item::find()->select('id')->where(['item_name'=>$post['add_file_item']])->asArray()->one(); //项目id 
                if(! is_dir('/var/www/fw_server_file')){
                     mkdir('/var/www/fw_server_file');
                }
                //存文件
                $path = '/var/www/fw_server_file/'.time().$_FILES["file"]["name"];
                if(file_exists($path)){
                    return Yii::t('yii','Add failure, the file already exists');
                }

                if($_FILES["file"]["size"]>1000000000){
                     return '添加失败，文件只能小于1000M';
                }
                move_uploaded_file($_FILES["file"]["tmp_name"],$path);
                //说明:这里使用的百度编辑器作为备注，过滤p br 标签 并把换行的位置替换为 &#13;&#10; 
                if(isset($post['editorValue'])&& $post['editorValue']){
                  $length = strlen($post['editorValue']);
                  $trim_remarks = substr($post['editorValue'],3,$length-12);
                  $remarks = str_replace('</p><p>','&#13;&#10;',$trim_remarks);
                }else{
                  $remarks = '';
                }
                $dev_file = new Item_file();
                $dev_file->path = $path;
                $dev_file->file_remarks = $remarks;
                $dev_file->iid = $iid['id'];
                $dev_file->save();
                // 添加一条记录至数据库中
                Log::add_log(1,4,'add',$post['add_file_item'],'file');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success';  
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
            }
           
        }
    }


    /**
     * 功能：获得项目的含有的文件
     * 参数：用户名 $user_name 项目名 $item
     * 返回：项目的文件数组
     */
    public function get_item_files($user_name,$item=''){
        if($item){ //代表只需要查询该项目的文件
            $iid = Item::find()->select('id')->where(['item_name'=>$item])->asArray()->one();
            
        }else{ //获得此人的项目以及第一个项目的文件
            $find_item = Item::get_all_items_by_user_name($user_name);
            if(!$find_item){
                $files[0]['path']='';
                return $files;
            }
            $iid = Item::find()->select('id')->where(['item_name'=>$find_item[0]['item_name']])->asArray()->one();
        }
        $files = Item_file::find()->where(['iid'=>$iid['id']])->asArray()->all();
        return $files;
    }

    /**
     * 功能：根据项目名获得该项目的所有信息
     * 参数：项目名 $item_name
     * 返回：
     */
    public function find_item_all_information($item_id){
        $item_name = Item::find()->select('item_name')->where(['id'=>$item_id])->asArray()->one();
        $item_name = $item_name['item_name'];
        // 1.1 获得项目的共有属性属性值
        $sql1 = "select item.id,item.item_name,user.user_name,item_attribute.* from item left join item_attribute_connect on item.id=item_attribute_connect.iid left join item_attribute on item_attribute_connect.aid=item_attribute.aid left join user on item_attribute_connect.vaid=user.id where item.item_name='".$item_name."'";

        $item_att1 = Yii::$app->db->createCommand($sql1)->queryAll(); 
        // 1.2 获得该项目项目的机种
        $sql2 = "select item.item_name,device.name from item left join item_device on item.id=item_device.iid left join device on item_device.did=device.id where item.item_name='".$item_name."'";
        $item_att2 = Yii::$app->db->createCommand($sql2)->queryAll(); 

        $handle_infor = Item::handle_db_information_by_infor($item_att1,$item_att2); //此函数处理上面两个查询的结果
        // 1.3 获得项目的私有属性属性值
        $sql3 = "select item.item_name,item_attribute.*,item_attribute_val.vname,item_attribute_val.id from item 
        left join item_siyou_connect on item.id=item_siyou_connect.iid 
        left join item_attribute_val on item_siyou_connect.vaid=item_attribute_val.id 
        left join item_attribute on item_attribute_val.aid=item_attribute.aid where item.item_name='".$item_name."' and item_attribute.statue=0";

        $item_att3 = Yii::$app->db->createCommand($sql3)->queryAll();

        // 1.4 获得项目的备注信息
        $sql4 = "select item.item_name,item_remarks.iname from item left join item_remarks on item.id=item_remarks.iid where item.item_name='".$item_name."'";
        $item_att4 = Yii::$app->db->createCommand($sql4)->queryAll();

        $item_att1['device']=$item_att2;
        $item_att1['siyou'] =$item_att3;
        $item_att1['item_remarks']=$item_att4;
        
        return $item_att1;
    }


    /**
     * 功能：根据ajax提交的数据，添加管理者或者客户
     * 参数：项目id $item_id  用户名 $user_name 属性 $aid 
     * 返回：success
     */
    public function add_manager_by_ajax($item_id,$user_name,$aid){
        $uid = Item::get_user_id_by_name($user_name); // 用户id
        $aid = Item_attribute::find()->select('aid')->where(['aname'=>$aid])->asArray()->one();
        $rel = Item_attribute_connect::find()->where(['iid'=>$item_id,'vaid'=>$uid['id']])->asArray()->one();
        if(!$rel){
            $rels = User_item::find()->where(['uid'=>$uid['id'],'iid'=>$item_id])->asArray()->one();
            if(!$rels){
                $connect = new Item_attribute_connect();
                $connect->iid  = $item_id;
                $connect->vaid = $uid['id'];
                $connect->aid  = $aid['aid'];
                $connect->save();

                $user_item = new User_item();
                $user_item->uid = $uid['id'];
                $user_item->iid = $item_id;
                $user_item->save();

                //添加一条日志之数据库中
                $item_name = Item::find()->where(['id'=>$item_id])->asArray()->one();
                Log::add_log(1,5,'update',$item_name['item_name'],'item');
            }
            return 'success';
        }else{
            return Yii::t('yii','The username has already existed');
        }
        
    }


    /**
     * 功能：根据ajax提交的数据，添加项目所需机种
     * 参数：项目id $item_id  机种名 $device 
     * 返回：success
     */
    public function add_suoxu_device_by_ajax($item_id,$device){
        $did = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();
        $rel = Item_device::find()->where(['iid'=>$item_id,'did'=>$did['id']])->asArray()->one();
        if(!$rel){
            $connect = new Item_device();
            $connect->iid  = $item_id;
            $connect->did = $did['id'];
            $connect->save();

            //添加一条日志之数据库中
            $item_name = Item::find()->where(['id'=>$item_id])->asArray()->one();
            Log::add_log(1,5,'update',$item_name['item_name'],'item');
            return 'success';
        }else{
            return Yii::t('yii','The item has this device');
        }
        
    }

    /**
     * 功能：根据ajax提交删除项目管理者或项目所属客户
     * 参数：项目id $item_id 用户名 $user_name
     * 返回：success
     */
    public function delete_user_by_ajax($item_id,$user_name){
        $uid = Item::get_user_id_by_name($user_name); // 用户id
        $user_power = User::find()->select('power')->where(['user_name' =>$user_name])->asArray()->one();
        // 防止同级用户删除自己
        if($user_power['power'] >= Yii::$app->session['power']){
            return '您无权删除此用户';
        }
        if(!$uid) return Yii::t('yii','The username does not exist! Please fill it out again');
        Item_attribute_connect::deleteAll('iid = :age AND vaid = :sex', [':age' => $item_id, ':sex' =>$uid['id']]);

        //删除人和项目关系表
        User_item::deleteAll('iid = :age AND uid = :sex', [':age' => $item_id, ':sex' =>$uid['id']]);
        //添加一条日志之数据库中
        $item_name = Item::find()->where(['id'=>$item_id])->asArray()->one();
        Log::add_log(1,5,'update',$item_name['item_name'],'item');
        return 'success';
    }

    /**
     * 功能：根据ajax提交删除项目所需机种
     * 参数：项目id $item_id 机种名 $name
     * 返回：success
     */
    public function delete_device_by_ajax($item_id,$name){
        $did = Device::find()->select('id')->where(['name'=>$name])->asArray()->one();
        if(!$did) return '该机种不存在';
        Item_device::deleteAll('iid = :age AND did = :sex', [':age' => $item_id,':sex' =>$did['id']]);
        //添加一条日志之数据库中
        $item_name = Item::find()->where(['id'=>$item_id])->asArray()->one();
        Log::add_log(1,5,'update',$item_name['item_name'],'item');
        return 'success';
    }

    /**
     * 功能：根据ajax提交删除项目私有属性
     * 参数：私有属性值的id
     * 返回：success
     */
    public function delete_siyou_by_ajax($siyou_id){
        $aid = Item_attribute_val::find()->select('aid')->where(['id'=>$siyou_id])->asArray()->one();

        Item_attribute_val::deleteAll(['id'=>$siyou_id]);

        Item_siyou::deleteAll(['vaid'=>$siyou_id]);
        return 'success';
    }

    /**
     * 功能：  批量删除项目
     * @param  项目的id $iid
     * @return success or false  
     */
    public function delete_item_by_item_id($iid){
        foreach ($iid as $val) {
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                //获得项目名称
                $item_name = Item::find()->select('item_name')->where(['id'=>$val])->asArray()->one(); 

                // 1.1 删除项目表
                Item::deleteAll(['id'=>$val]);
                // 1.2 删除项目管理者关系表
                Item_attribute_connect::deleteAll(['iid'=>$val]);
                // 1.3 删除项目机种关系表
                Item_device::deleteAll(['iid'=>$val]);
                // 1.4 删除项目所含的文件
                $file = Item_file::find()->where(['iid'=>$val])->asArray()->all();
                if($file){
                    foreach ($file as $vals) {
                        Item_file::deleteAll(['id'=>$vals['id']]);
                        if(file_exists($vals['path'])){
                            unlink($vals['path']);
                        }
                    }
                }
                // 1.5 删除项目私有属性关系表
                Item_siyou::deleteAll(['iid'=>$val]);
                // 1.6 删除项目备注表
                Item_remarks::deleteAll(['iid'=>$val]);
                // 1.7 删除项目用户关系表
                User_item::deleteAll(['iid'=>$val]);

                //添加一条删除日志的信息至数据库中
                Log::add_log(1,4,'delete',$item_name['item_name'],'item');
                $transaction->commit();//提交事务会真正的执行数据库操作
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
                return 'false';
            } 
        }   
        return 'success';
    }
}