<?php
namespace frontend\controllers;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Device;
use frontend\models\Log;
use frontend\models\Dev_file;
use frontend\models\Item_file;
use frontend\models\Version_name;
use yii\data\Pagination;
use yii\web\ZipArchive;
use frontend\models\Dev_remark;
use frontend\models\Dev_attribute_val;

/**
 * 机种模块
 * 功能 增删改查机种， 机种增删机种文件
 * 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
 *       里面的含有所有的翻译中文语言
 *
 * @copyright Copyright (c) 2018–www.zwaveasia.com.cn
 * @author yaolianmin
 * @version 1.0 2018/1/29 9:00
 */

class DeviceController extends Controller{ 
    /**
     * 模块：机种主页面
     * 功能：显示主页信息 删除，分页以及各操作
     */
    public function actionDevice(){ 

        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $power = Yii::$app->session['power']; //权限
        $user_name = Yii::$app->session['name']; 
        $dev = Device::get_user_devs($user_name);
        $power_have =User::have_all_power($user_name); 
        // 1.1 搜索功能
        $search_name = Yii::$app->request->get('dev_name');
        if($search_name){
            //将用户权限及机种名带入
            $dev = Device::search_dev_by_name($search_name,$power);
            if($dev === false){
                return $this->redirect(['login/index']);
            }
        }
        // 1.2 批量删除操作
        $del_devices = Yii::$app->request->get('del_devices');
        if($del_devices){
            $length = strlen($del_devices)-1;
            $del_devices = substr($del_devices, 0,$length);
            $del_devices = explode(',', $del_devices);
            $rel = Device::delete_all_devices($del_devices);
            if ($rel) {
                return $this->redirect(['user_center/success']);
            }elseif ($rel === false) { //数据库异常处理
                return $this->redirect(['device/device']);    
            }
        }
        // 1.3 分页的操作
        $length_dev = count($dev);
        $totalCount = $length_dev;
        $page  = new Pagination(['totalCount' =>$totalCount, 'pageSize' =>10]);
        $page_now = Yii::$app->request->get('page');
        $user_dev_new = [];
        if($page_now<=1||is_null($page_now)){ //仅显示前十个数据 
            if($length_dev <= 10){
                $user_dev_new = $dev;
            }else{
               $user_dev_new = array_slice($dev,0,10);
            } 
        }else{ //第2页数据以上
            if($length_dev <= 10*$page_now){
                for ($i=10*($page_now - 1); $i < $length_dev; $i++) {
                   array_push($user_dev_new,$dev[$i]);
                }  
            }else{
                for ($i=10*($page_now-1); $i < 10*$page_now; $i++) { 
                   array_push($user_dev_new,$dev[$i]);
                }
            } 
        }
       
        return $this->renderpartial('device',[
                                    'dev'=>$user_dev_new,
                                    'power'=>$power_have,
                                    'page'=>$page,
                                    'search_dev'=>$search_name
                                ]);
    }
    

    /**
     * 模块：机种的添加页面
     * 功能：添加机种以及返回错误信息
     *
     */
    public function actionDevice_add(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
        
        //获得此人是否拥有添加机种的权限
        $power_have =User::have_all_power($user_name); 
        if(!$power_have[1]){
            return $this->redirect(['device/device']);
        }
        //查询 所有的属性 以及该属性的属性值（品牌除外）
        $arrtibute = Device::find_all_attribute_vals();
        $pinpai_val = Device::find_attribute_val('品牌');
        if(Yii::$app->request->isAjax){
             // 1 .1 ajax 获得表单提交的机种信息
            $dev_infor = Yii::$app->request->get('ajax_add_dev');
            if($dev_infor){
                // 1.2 过滤特殊字符数据
                if(!$dev_infor['dev_name']) 
                    return Json::encode(Yii::t('yii','The name of the device can not be empty'));
                if(count($dev_infor['attribute'])<4) 
                    return Json::encode(Yii::t('yii','Attribute value can not be empty'));
                if(strlen($dev_infor['dev_name'])>32) 
                    return Json::encode(Yii::t('yii','The name of the device is too long'));
                // 检测该机种名是否已存在
                $is_have_dev = Device::is_have_device($dev_infor['dev_name']);
                if($is_have_dev) 
                    return Json::encode(Yii::t('yii','The name of the device has already existed. Please fill in it again'));
                // 1.3 存储数据
                $rel = Device::add_device_infor($dev_infor);
                if(!$rel) 
                    return Json::encode(Yii::t('yii','System is upgrading, retry later'));
                return Json::encode('');
            }
        }
        return $this->renderpartial('device_add',['pinpai_val'=>$pinpai_val,'arrtibute'=>$arrtibute]);
    }
    

    /**
     * 模块：机种的属性与属性性值页面
     * 功能: 添加 删除 属性（值）
     */
    public function actionDev_property(){  
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name'];
        //判断此人是否拥有权限进入此页
        $power_is_have = Device::power_is_have($user_name);
        if(!$power_is_have[0]['own_dev_aud']){
            return $this->redirect(['device/device']);
        }
        $attributes = Device::find_attributes(); //获得所有的属性
        $attri = Yii::$app->request->post('attribute'); //获得ajax提交的值
        if($attri){
            $aval = Device::find_attribute_val($attri);
            $str = '';
            foreach ($aval as $val) {
                $str .=$val['vname'].'$$$$';
            }
            return $str;
        }else{
            $aval = Device::find_attribute_val();
        }
        //添加 删除属性（值)的4个操作
        if(Yii::$app->request->isGet){
            //1.0 添加属性的操作
            $add_attribute = Yii::$app->request->get('add_attribute');
            if($add_attribute){
                $len = mb_strlen($add_attribute,'utf-8');
                if($len>14){
                    $add_rel = Yii::t('yii','The length of the property is too long');
                    return $this->renderpartial('dev_property',[
                                               'attributes'=>$attributes,
                                               'aval'=>$aval,
                                               'infor'=>$add_rel
                                           ]); 
                }
                $add_rel = Device::add_attribute($add_attribute);
                if($add_rel == 'success'){
                    return $this->redirect(['device/device']);
                }else{
                    return $this->renderpartial('dev_property',[
                                                'attributes'=>$attributes,
                                                'aval'=>$aval,
                                                'infor'=>$add_rel
                                            ]);
                }
            }
            //2.0 删除属性的操作
            $del_attribute = Yii::$app->request->get('del_attribute');
            if($del_attribute){
                //有些属性不给删除
                if($del_attribute == '品牌'){
                    $infor = Yii::t('yii','Brand attributes can not be deleted');
                }elseif($del_attribute == '设备类型') {
                    $infor = Yii::t('yii','Device type properties cannot be deleted');
                }elseif($del_attribute == '卡类型') {
                    $infor = Yii::t('yii','Card type properties cannot be deleted');
                }elseif($del_attribute == '应用场景') {
                    $infor = Yii::t('yii','Application scene properties cannot be deleted'); 
                }
                //判断此属性的属性值是否已经被使用，若使用，则不给删除
                $is_have_used = Device::attribute_is_have_used($del_attribute);
                if($is_have_used){
                    $infor = Yii::t('yii','This property has been used by the device and can not be deleted');
                }
                if(isset($infor)&&$infor){
                    return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval,'infor'=>$infor]);
                }
                $del_rel = Device::del_attribute($del_attribute);
                if($del_rel == 'success'){ //删除成功
                    return $this->redirect(['device/device']);
                }else{
                    return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval,'infor'=>$del_rel]);
                }
            }
            //3.0 添加属性值的操作
            $add_attribute_val = Yii::$app->request->get('add_attribute_val');  //属性
            $add_attribute_vals = Yii::$app->request->get('add_attribute_vals'); //属性值
            if($add_attribute_vals){
                $add_aval = Device::add_attribute_val($add_attribute_val,$add_attribute_vals);

                if($add_aval == 'success'){ //添加成功
                    return $this->redirect(['device/device']);
                }else{
                    return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval,'infor'=>$add_aval]);
                }
            }
            //4.0 删除属性值的操作
            $del_attribute_val = Yii::$app->request->get('del_attribute_val'); //属性 
            $del_attribute_vals = Yii::$app->request->get('del_attribute_vals'); //属性值
            if($del_attribute_vals){
                //判断其他机种是否已经使用此属性值，若使用，则不给删除
                $is_used = Device::attribute_val_is_used($del_attribute_vals);
                if($is_used){
                    $infor = Yii::t('yii','This property value has been used and can not be deleted');
                    return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval,'infor'=>$infor]);
                }
                $del_val = Device::delete_attribute_val($del_attribute_vals);
                if($del_val == 'success'){
                    return $this->redirect(['device/device']);
                }else{
                   return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval,'infor'=>$add_aval]); 
                }
            }
        }
        return $this->renderpartial('dev_property',['attributes'=>$attributes,'aval'=>$aval]);
    }


    /**
     *常用机种的添加页面模块
     * 
     */
    public function actionCommon_dev(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name'];
        //查询此人所拥有的机种
        $dev_have = User::find_device_some($user_name);
        $get = Yii::$app->request->get();
        if(isset($get['common_dev'])){
            if($get['flag']){ //表示删除操作
                $del_rel = Device::del_common_dev($get['common_dev']);
                if($del_rel){
                    return $this->redirect(['device/device']);
                }
            }else{ //表示添加操作
                $add_rel = Device::add_common_dev($get['common_dev']);
                if($add_rel){
                    return $this->redirect(['device/device']);
                }
            }
        }
        return $this->renderpartial('common_dev',['device'=>$dev_have]);
    }


    /**
     * 模块：每个机种的详情页
     * 功能：展示机种的信息
     */
    public function actionDev_look(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $dev_id = Yii::$app->request->get('dev_id'); //get提交的机种名
        $dev_name = Device::find()->select('name')->where(['id'=>$dev_id])->asArray()->one();
        if($dev_name){
            $dev_attribute = Device::find_dev_infor_by_dev($dev_name['name']); //机种的属性属性值
           // 对机种的共有属性值 品牌 进行分类
           $pinpai = [];
           $siyou = [];
           $gongyou = [];
           foreach ($dev_attribute as $val) {
              if($val['statue']){ //代表共有属性
                  if($val['aid'] == 1){  //代表品牌
                   array_push($pinpai, $val);
                  }else{
                   $attribute_val = Device::get_all_attribute_vals($val['aname']);
                   $val['aname_val'] = $attribute_val;
                   array_push($gongyou, $val);
                  }
              }else{
               array_push($siyou, $val);
              }
           }
           $dev_remarks = Device::get_device_remarks($dev_name); //机种的备注
           $pinpai_val = Device::find_attribute_val('品牌');
        }else{
            return $this->redirect(['device/device']);
        }
        $power_have =User::have_all_power($user_name); //此人的权限
        return $this->renderpartial('dev_look',[
                                    'dev_id'=>$dev_id,
                                    'dev_name'=>$dev_name,
                                    'pinpai'=>$pinpai,
                                    'gongyou'=>$gongyou,
                                    'siyou'=>$siyou,
                                    'remarks'=>$dev_remarks,
                                    'power'=>$power_have
                                   ]);
    }


    /**
     * 模块：机种管理的修改页面
     * 功能：修改单个机种的详细信息
     */
    public function actionDev_update(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        // ajax 提交表单的信息 ，放在 return $this->redirect(['device/device']); 后面会有 302的重定向错误
        if(Yii::$app->request->isAjax){
            //删除机种私有的属性 属性值
            $del_att = Yii::$app->request->get('del_att');
            if($del_att){
                $rel = Device::del_dev_siyou_attribute($del_att);
                return Json::encode('success');
            }
             // 1 .1 ajax 获得表单提交的机种信息
            $dev_infor = Yii::$app->request->get('ajax_update_dev');
            if($dev_infor){
                // 1.2 过滤特殊字符数据
                if(!$dev_infor['dev_name']){
                    $ajax_return = Yii::t('yii','The name of the device can not be empty');
                    return Json::encode($ajax_return);
                }
                if(count($dev_infor['attribute']) < 4 ){
                    $ajax_return = Yii::t('yii','Brand value can not be empty');
                    return Json::encode($ajax_return);
                }
                if(strlen($dev_infor['dev_name'])>32){
                    $ajax_return = Yii::t('yii','The name of the device is too long');
                    return Json::encode($ajax_return);
                }
                //检测机种名是否更换
                $find_dev_name = Device::find()->select('name')->where(['id'=>$dev_infor['dev_id']])->asArray()->one();
                if($dev_infor['dev_name']!=$find_dev_name['name']){
                    $is_have_dev = Device::is_have_device($dev_infor['dev_name']);
                    if($is_have_dev){
                        $ajax_return = Yii::t('yii','The name of the device has already existed. Please fill in it again');
                        return Json::encode($ajax_return);
                    }
                    $upd_dev = Device::updateAll(['name'=>$dev_infor['dev_name']],['id'=>$dev_infor['dev_id']]);
                }
                //检测属性值是否有更换
                $attribute_rel = Device::checked_attribute_is_change($dev_infor['dev_name'],$dev_infor['attribute']);
                //是否更换备注信息
                $dev_remarks = Device::get_device_remarks($dev_infor['dev_name']); //机种的备注
                if($dev_remarks!= $dev_infor['dev_remarks']){
                   Dev_remark::updateAll(['dev_re_name'=>$dev_infor['dev_name']],['id'=>$dev_infor['dev_id']]);
                }
                //检测是否有私有属性的添加
                if(isset($dev_infor['arr_siyou'])){
                   foreach ($dev_infor['arr_siyou'] as $key => $val) {
                      $rel = Device::add_new_attribute_val($dev_infor['dev_id'],$val,$dev_infor['arr_siyou_val'][$key]);
                      if($rel != 'success'){
                          $ajax_return = Yii::t('yii','System is upgrading, retry later');
                          return Json::encode($ajax_return);
                      }
                   }
                }
                // 添加一条日志值数据库中
                Log::add_log(1,7,'update',$dev_infor['dev_name'],'device');

                $ajax_return = '';
                return Json::encode($ajax_return);
            }
        }
        // $user_name = Yii::$app->session['name']; //用户名
        $dev_id = Yii::$app->request->get('dev_id'); //获得机种id
        if(!$dev_id) return $this->redirect(['device/device']);
        $dev_name = Device::find()->select('name')->where(['id'=>$dev_id])->asArray()->one();
        $dev_name = $dev_name['name']; //机种名
        if($dev_name){
            $dev_attribute = Device::find_dev_infor_by_dev($dev_name); //机种的属性属性值
           // 对机种的共有属性值 品牌 进行分类
           $pinpai = [];
           $siyou = [];
           $gongyou = [];
           foreach ($dev_attribute as $val) {
              if($val['statue']){ //代表共有属性
                  if($val['aid'] == 1){  //代表品牌
                   array_push($pinpai, $val);
                  }else{
                   $attribute_val = Device::get_all_attribute_vals($val['aname']);
                   $val['aname_val'] = $attribute_val;
                   array_push($gongyou, $val);
                  }
              }else{
               array_push($siyou, $val);
              }
           }
           $dev_remarks = Device::get_device_remarks($dev_name); //机种的备注
           $pinpai_val = Device::find_attribute_val('品牌');
        }else{
            return $this->redirect(['device/device']);
        }
        return $this->renderpartial('dev_update',[
                                    'dev_id'=>$dev_id,
                                    'dev_name'=>$dev_name,
                                    'pinpai'=>$pinpai,
                                    'gongyou'=>$gongyou,
                                    'siyou'=>$siyou,
                                    'remarks'=>$dev_remarks,
                                    'all_pinpai'=>$pinpai_val
                                   ]);
    }



    /**
     * 模块：机种的文件部分 
     * 作用：添加机种--品牌--版本的文件
     * 时间：2018.04.19 14:06
     */
    public function actionDev_files(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $dev_pin_ban = Dev_file::find_device_pinpai_version_by_cond($user_name);
        /*
         * 此操作是为了检测/var/www/fw-server/frontend/web文件夹中是否有通过 批量下载按钮不正当操作
         * 从而导致的文件没有删除，致使web文件夹因文件没有删除而越来越大。
         */
        $web_path = scandir('/var/www/fw-server/yii/frontend/web'); //web文件夹下所有的文件数组
        if(count($web_path)>12){
            foreach ($web_path as $val) {
                $dir = substr($val,strlen($val)-4);
                if($dir == '.zip'){
                   unlink($val);
                }
            }
        }

        //查看此人是否拥有文件的相关操作（默认都有查看下载自己的机种文件，不管是否赋予权限）
        $power_is_have = User::have_all_power($user_name);
        // 1.1 ajax 交互替换品牌 版本 文件的操作
        if(Yii::$app->request->isAjax){
            // 1.1.1 添加版本的ajax
            $ajax_add_version_dev = Yii::$app->request->get('ajax_device');
            if($ajax_add_version_dev){
                $pinpais = Dev_file::find_device_pinpai_version_by_cond('',$ajax_add_version_dev);
                $return = '';
                foreach ($pinpais['pinpai'] as $val) {
                   $return .= $val['vname'].'@@@@@';
                }
                return $return;    
            }

            // 1.1.2 添加文件机种的ajax
            $ajax_add_file_dev = Yii::$app->request->get('ajax_file_device');
            if($ajax_add_file_dev){
                $pinpais_version = Dev_file::find_device_pinpai_version_by_cond('',$ajax_add_file_dev);
                $pinpaizhi = ''; //所有品牌值的字符串
                foreach ($pinpais_version['pinpai'] as $val) {
                   $pinpaizhi .= $val['vname'].'@@@@@';
                }
                $versions = ''; //所有版本号的字符串
                if(isset($pinpais_version['version'][0]['version_name'])){
                    foreach ($pinpais_version['version'] as $val) {
                        $versions .= $val['version_name'].'$$$$$';
                    }
                }
                $return = $pinpaizhi.'#####'.$versions;
                return $return;
            }

            // 1.1.3 添加文件的品牌ajax
            $ajax_add_file_pin = Yii::$app->request->get('ajax_file_pinpai');
            if($ajax_add_file_pin){
                $ajax_add_file_device = Yii::$app->request->get('ajax_file_dev');
                $pinpais_version = Dev_file::find_device_pinpai_version_by_cond('',$ajax_add_file_device,$ajax_add_file_pin);
                $return = ''; //返回的所有版本字符串
                if(isset($pinpais_version['version'][0]['version_name'])){
                    foreach ($pinpais_version['version'] as $val) {
                        $return .= $val['version_name'].'@@@@@';
                    }
                }
                return $return;
            }

            // 1.1.4 下载文件的机种替换ajax
            $ajax_download_device = Yii::$app->request->get('ajax_download_device');
            if($ajax_download_device){
                $device_pinpai_version_file = Dev_file::find_device_pinpai_version_by_cond('',$ajax_download_device);
                $pinpai = ''; //返回的品牌值字符窜
                foreach ($device_pinpai_version_file['pinpai'] as $val) {
                    $pinpai .=$val['vname'].'@@@@@';
                }
                $version = ''; //返回的版本号字符窜
                if(isset($device_pinpai_version_file['version'][0]['version_name'])){
                    foreach ($device_pinpai_version_file['version'] as $val) {
                        $version .= $val['version_name'].'$$$$$';
                    }
                }
                $file = ''; //返回的文件字符串
                $file_re = ''; // 限制返回文件的备注长度
                if(isset($device_pinpai_version_file['file'][0]['path'])){
                    foreach ($device_pinpai_version_file['file'] as $val) {
                        if(mb_strlen($val['file_remarks'])>35){
                            $file_re .= mb_substr($val['file_remarks'],0,34).'...'.'&&&&&';
                        }else{
                            $file_re .= $val['file_remarks'].'&&&&&';
                        }
                        $file .= $val['id'].'%%%%%'.substr($val['path'],34).'%%%%%'.$val['file_remarks'].'*****';
                    }
                }
                $return  = $pinpai.'#####'.$version.'#####'.$file.'#####'.$file_re;
                return $return;
            }
            // 1.1.5 下载文件的品牌值替换的ajax
            $ajax_download_pinpai = Yii::$app->request->get('ajax_download_pinpai');
            if($ajax_download_pinpai){
                $ajax_download_dev = Yii::$app->request->get('ajax_download_dev'); //机种
                $version_file_detail = Dev_file::find_device_pinpai_version_by_cond('',$ajax_download_dev,$ajax_download_pinpai);
                $version = '';
                if(isset($version_file_detail['version'][0]['version_name'])){
                    foreach ($version_file_detail['version'] as $val) {
                        $version .= $val['version_name'].'$$$$$';
                    }
                }
                $file = ''; //返回的文件字符串
                $file_re = ''; // 限制返回文件的备注长度
                if(isset($version_file_detail['file'][0]['path'])){
                    foreach ($version_file_detail['file'] as $val) {
                        if(mb_strlen($val['file_remarks'])>35){
                            $file_re .= mb_substr($val['file_remarks'],0,34).'...'.'&&&&&';
                        }else{
                            $file_re .= $val['file_remarks'].'&&&&&';
                        }
                        $file .= $val['id'].'%%%%%'.substr($val['path'],34).'%%%%%'.$val['file_remarks'].'*****';
                    }
                }
                $return  = $version.'#####'.$file.'#####'.$file_re;
                return $return;
            }
            // 1.1.6 下载文件的版本名替换的ajax
            $ajax_download_ver = Yii::$app->request->get('ajax_download_ver');
            if($ajax_download_ver){
                $ajax_download_dev = Yii::$app->request->get('ajax_down_dev'); //机种
                $ajax_download_pin = Yii::$app->request->get('ajax_down_pin'); //机种
                $ajax_fi_detail = Dev_file::find_device_pinpai_version_by_cond('',$ajax_download_dev,$ajax_download_pin,$ajax_download_ver);
                $file = ''; //返回的文件字符串
                $file_re = ''; // 限制返回文件的备注长度
                if(isset($ajax_fi_detail['file'][0]['path'])){
                    foreach ($ajax_fi_detail['file'] as $val) {
                        if(mb_strlen($val['file_remarks'])>35){
                            $file_re .= mb_substr($val['file_remarks'],0,34).'...'.'&&&&&';
                        }else{
                            $file_re .= $val['file_remarks'].'&&&&&';
                        }
                        $file .= $val['id'].'%%%%%'.substr($val['path'],34).'%%%%%'.$val['file_remarks'].'*****';
                    }
                }
                $return  = $file.'#####'.$file_re;
                return $return;
            }
        }
        // 1.2 添加版本的操作
        $add_version = Yii::$app->request->get('version_name');
        if($add_version){
            $version_get = Yii::$app->request->get();
            //检测是否已经有此版本名
            $rel = Version_name::find()->where(['version_name'=>$add_version])->asArray()->one();
            if($rel){
                $tips =  Yii::t('yii','This version of the name has already existed and is renamed');
                return $this->renderpartial('dev_files',['dev_pin_ban'=>$dev_pin_ban,'power'=>$power_is_have,'re_version'=>$tips]);
            }
            //存数据
            $rel = Dev_file::add_version($version_get);
            if($rel){
                return $this->redirect(['device/device']);
            }
        }
        // 1.3 添加文件的操作
        $file_post = Yii::$app->request->post('file_add_ver');
        if($file_post){
            if($_FILES['file']['name']){
                $post = Yii::$app->request->post();
                $rel = Dev_file::add_dev_file($post);
                if($rel = 'success'){
                    return $this->redirect(['device/device']);
                }
            }
        }
        // 1.4 下载文件的操作
        $download_file_id = Yii::$app->request->get('download_id');
        if($download_file_id){
            $path = Dev_file::find()->select('path')->where(['id'=>$download_file_id])->asArray()->one();
            $new_path = substr($path['path'], 34);

            //判断文件是否存在
            if(!file_exists($path['path'])){
                $tips =  '404 Not find file!!';
                return $this->renderpartial('dev_files',['dev_pin_ban'=>$dev_pin_ban,'power'=>$power_is_have]);
            }
            $size = filesize($path['path']);
            if($size>1400266407){
                $tips = '文件过大，更换文件';
                return $this->renderpartial('dev_files',['dev_pin_ban'=>$dev_pin_ban,'power'=>$power_is_have,'re_version'=>$tips]);
            }
            if($path['path']){    
                set_time_limit(0);
                ini_set('memory_limit', '1500M');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.$new_path);
                header('Content-Transfer-Encoding: binary');
                ob_end_clean();
                readfile($path['path']);   
            }  
            //添加一条日志至数据库中
            Log::add_log(1,7,'download',$new_path,'file');    
        }
        // 1.6 批量删除文件的操作
        $delete_file_id = Yii::$app->request->get('batch_delete_id');
        if($delete_file_id){
            $len = strlen($delete_file_id)-1;
            $delete_file_id = substr($delete_file_id,0,$len);
            $delete_file_id = explode(',', $delete_file_id);
            foreach ($delete_file_id as $val) {
                try{
                    $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                    $path = Dev_file::find()->select('path')->where(['id'=>$val])->asArray()->one();
                    if(file_exists($path['path'])){
                        unlink($path['path']);
                    }
                    Dev_file::deleteAll("id='".$val."'");
                    //添加一条日志至数据库中
                    Log::add_log(1,7,'delete',substr($path['path'],34),'file');
                    $transaction->commit();//提交事务会真正的执行数据库操作
                 }catch( \Exception $e){
                     $transaction->rollback();//如果操作失败, 数据回滚
                 } 
            }
            return $this->redirect(['device/dev_files']);
        }
        return $this->renderpartial('dev_files',['dev_pin_ban'=>$dev_pin_ban,'power'=>$power_is_have]);
    }



    // 批量下载文件操作
    public function actionBatch_download_file(){
        // 1.1 批量下载机种文件
        $file_id = Yii::$app->request->get('fil_id');
        if($file_id){
            $len = strlen($file_id)-1;
            $file_id = substr($file_id,0,$len);
            $file_id = explode(',', $file_id);
            $arr_return = [];
            foreach ($file_id as $val) {
               $file_path = Dev_file::find()->select('path')->where(['id'=>$val])->asArray()->one();
               array_push($arr_return,$file_path['path']);
            }
        }
        // 1.2 批量下载项目文件
        $item_file_id = Yii::$app->request->get('item_file_id');
        if($item_file_id){
            $len = strlen($item_file_id)-1;
            $item_file_id = substr($item_file_id,0,$len);
            $item_file_id = explode(',', $item_file_id);
            $arr_return = [];
            foreach ($item_file_id as $val) {
               $file_path = Item_file::find()->select('path')->where(['id'=>$val])->asArray()->one();
               array_push($arr_return,$file_path['path']);
            }
        }
        return $this->renderpartial('batch_download_file',['download_file'=>$arr_return]);
    }
}