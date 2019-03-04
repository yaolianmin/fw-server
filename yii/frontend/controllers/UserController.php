<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use frontend\models\Device;
use frontend\models\Upgrade;
use frontend\models\Log;
use yii\data\Pagination;
use yii\helpers\Json;

/**
* 模块：用户管理的控制器
* 作用：@用户管理的添加 删除 修改 分页显示 修改密码等
* 时间：2018-01-10
* 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
*       里面的含有所有的翻译中文语言
*
*/

class UserController extends Controller{

   /**
    * 模块：用户管理的主页面
    * 功能：显示用户简单的信息
    *
    */
   public function actionUser(){
      //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
      $power = Yii::$app->session['power'];
      $name = Yii::$app->session['name'];
      // 1.1 获得此人的是否拥有增删修的权限
      $power_have = User::have_all_power($name);
      if($power<5){ //代表普通用户或其他 无权新增用户
         $power_have [0]= 0;
      }
      if(!$power_have[0]) return $this->redirect(['device/device']);
   
      // 1.2 刚进入页面显示用户信息
      $user_dev = User::find_user_infor($name);
      // 1.3 搜索功能
      $search_name = Yii::$app->request->get('search_name');

      if(Yii::$app->request->isGet){ 
         if($search_name){
            $user_dev = User::serach_user($search_name);
         }
      }
      // 1.4 删除用户操作
      $del_name = Yii::$app->request->get('del_name');
      if($del_name){
         $length = strlen($del_name)-1;
         $del_name = substr($del_name, 0,$length);
         $del_name = explode(',', $del_name);
         //删除含有的名字
         $rel = User::delete_all_user($del_name);
         if ($rel) {
            return $this->redirect(['user_center/success']);
         }
      }
      // 1.5 分页的操作
      $length_dev = count($user_dev);
      $totalCount = $length_dev;
      $page  = new Pagination(['totalCount' =>$totalCount, 'pageSize' =>10]);
      $page_now = Yii::$app->request->get('page');
      $user_dev_new = []; 
      if($page_now<=1){ //仅显示前十个数据 
         if($length_dev <=10){
            $user_dev_new = $user_dev;
         }else{
            for($i=0;$i<10;$i++){
               array_push($user_dev_new,$user_dev[$i]);
            }
         } 
      }else{ //第2页数据以上
         if($length_dev <= 10*$page_now){
            for ($i=10*($page_now - 1); $i < $length_dev; $i++) {
               array_push($user_dev_new,$user_dev[$i]);
            }  
         }else{
            for ($i=10*($page_now-1); $i < 10*$page_now ; $i++) { 
               array_push($user_dev_new,$user_dev[$i]);
            }
         } 
      }
   	return $this->renderPartial('user',['user_dev'=>$user_dev_new,'power_have'=>$power_have,'search_name'=>$search_name,'page'=>$page]);
   }
   

   /**
    * 模块：用户管理的添加页面
    * 作用：新增用户
    * 返回：错误数据显示在本页 添加成功跳转到用户主页
    */
   public function actionUser_add(){
      //判断是否存在session用户,没有则返回登陆页面
      if(!isset(Yii::$app->session['name'])){
         return $this->redirect(['login/quit']); 
      }
      $power = Yii::$app->session['power']; //权限
      $name = Yii::$app->session['name'];  //姓名
      $result = ''; //数据的提示信息
      // 1.1 获得此人是否拥有增删修的权限
      $power_have = User::is_have_power($name);
      if($power_have[0]['own_user_aud']=='1'){
         //查看此人的所有权限设定
         $power_all = User::have_all_power($name);
         if($power_all[0] =='1'){ //表示有机种权限
            if($power>9){ //表示（超级）管理员
               $device = User::find_device();
            }elseif($power ==5){ //查找该FAE所拥有的机种
               $device = User::find_device_some($name);
            }elseif ($power < 5) { //无权添加用户
               return $this->redirect(['user/user']);
            }
            if(Yii::$app->request->isAjax){ 
               $ajax_get = Yii::$app->request->get('ajax_add_user'); 
               //验证数据的合理性
               $result = User::date_is_resonble($ajax_get);
               if($result){ //数据不合理
                  return Json::encode($result);
               }
               $user_is_exit = User::find()->where(['user_name'=>$ajax_get['user_name']])->asArray()->one();
               if(isset($user_is_exit['user_name'])&& $user_is_exit['user_name']){
                  return Json::encode(Yii::t('yii','The username has already existed'));
               }
               //将用户的信息存入数据库
               $new_user = User::add_new_user($ajax_get); 
               return Json::encode($new_user);    
            }   
         }
      }else{ //无权添加用户
         return $this->redirect(['user/user']);
      }
   	return $this->renderPartial('user_add',['device'=>$device,'power_all'=>$power_all]);
   }




   /**
    * 模块：用户的修改页面
    * 功能：修改用户的信息 
    * 返回：错误信息时重新填写 ，成功后跳转到用户主页 
    */
   public function actionUser_update(){
      //判断是否存在session用户,没有则返回登陆页面
      if(!isset(Yii::$app->session['name'])) return $this->redirect(['login/quit']); 
   
      $power = Yii::$app->session['power']; //权限
      $name = Yii::$app->session['name'];  //姓名
      //获得此人的所有权限
      $power_all = User::have_all_power($name); 
      //判断此人是否有权限更改用户
      if($power_all[8] == 0){ 
         return $this->redirect(['user/user']) ;
      }
      //判断是哪个级别的人
      if($power>9){ //表示（超级）管理员
         $device = User::find_device();
      }elseif($power == 5){ //查找该FAE所拥有的机种
         $device = User::find_device_some($name);
      }elseif ($power < 5) { //无权添加用户
         return $this->redirect(['user/user']);
      }
      // ajax 添加或者删除人拥有的机种
      if(Yii::$app->request->isAjax){
         // 添加操作
         $ajax_add = Yii::$app->request->get('ajax_add');
         if($ajax_add){
            $rel = User::ajax_add_device($ajax_add['ajax_add_dev'],$ajax_add['ajax_add_uid']);
            return Json::encode('');
         }
         // 删除人的机种操作
         $ajax_delete_dev = Yii::$app->request->get('ajax_delete_dev');
         if($ajax_delete_dev){
            $ajax_uid_id = Yii::$app->request->get('ajax_delete_uid');
            $rel = User::ajax_delete_device($ajax_delete_dev,$ajax_uid_id);
            return '';
         }
         $user_ifor = Yii::$app->request->get('ajax_update_user');
         if($user_ifor){
            // 1.0 过滤ajax提交的信息
            if(!$user_ifor['user_name']){
               return Json::encode(Yii::t('yii','The username can not be empty'));
            }
            if(strlen($user_ifor['user_name']) >12){
               return Json::encode(Yii::t('yii','username too long'));
            }
            if(!preg_match('/^1\d{10}$/', $user_ifor['phone'])){
               return Json::encode(Yii::t('yii','phone format is incorrect'));
            }
            if(! preg_match('/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/', $user_ifor['email'])){
               return Json::encode(Yii::t('yii','email format is incorrect'));
            }
            if(!$user_ifor['power']){
               return Json::encode(Yii::t('yii','Please add user level'));
            }
            // 1.0.0 检测修改者的权限是否大于操作者(防止恶意的串改比自己权限大的信息)
            $update_user_power = User::find()->select('power')->where(['id'=>$user_ifor['user_id']])->asArray()->one();
            if($update_user_power['power'] > $power){
               return Json::encode('您无权修改此用户的信息');
            }
            // 1.2 更换数据
            $user = User::find()->where(['id'=>$user_ifor['user_id']])->asArray()->one();
            if($user_ifor['user_name'] != $user['user_name']){
               $rel = User::find()->where(['user_name'=>$user_ifor['user_name']])->asArray()->one();  
               if($rel){
                  return Json::encode(Yii::t('yii','The username has already existed'));
               }else{
                  User::updateAll(['user_name'=>$user_ifor['user_name']],['id'=>$user_ifor['user_id']]);
               }
            }
            if($user_ifor['phone'] !=$user['phone']){
               User::updateAll(['phone'=>$user_ifor['phone']],['id'=>$user_ifor['user_id']]); 
            }
            if($user_ifor['email'] !=$user['email']){
               User::updateAll(['email'=>$user_ifor['email']],['id'=>$user_ifor['user_id']]); 
            }
            //级别处理
            if($user_ifor['power'] == 'PM'){
               $user_ifor['power'] = '10';
            }elseif ($user_ifor['power'] == 'FAE') {
               $user_ifor['power'] = '5';
            }elseif ($user_ifor['power'] == '普通用户') {
               $user_ifor['power'] = '1';
            }elseif ($user_ifor['power'] == '其他') {
               $user_ifor['power'] = '-1';
            }else{
               $user_ifor['power'] = '1'; 
            }
            if($user_ifor['power'] != $user['power']){
               User::updateAll(['power'=>$user_ifor['power']],['id'=>$user_ifor['user_id']]); 
            }
            //权限的处理
            User::update_user_information($user_ifor);
            return Json::encode('');
         }
      }
      if(Yii::$app->request->isGet){//显示此人的所有信息
         $user_id = Yii::$app->request->get('user_id');
         $user_name = User::find()->select('user_name')->where(['id'=>$user_id])->asArray()->one();
         $user_name = $user_name['user_name'];
         //查询这个人的用户信息
         $dev_infor = User::find_user_infor_by_name($user_name);
         $dev_infor[0]['name']=explode('@@@@@',trim($dev_infor[0]['name']));
         //查找这个人的备注信息
         $user_remarks = User::find_user_remarks($user_name);
         array_push($dev_infor[0], $user_remarks);
      }
   	return $this->renderPartial('user_update',['power_all'=>$power_all,'device'=>$device,'dev_infor'=>$dev_infor]);
   }


   /**
    *  模块：用户的修改页面
    *  功能：仅供查看用户信息，无法修改 
    */
   public function actionUser_look(){
      //判断是否存在session用户,没有则返回登陆页面
      if(!isset(Yii::$app->session['name'])) return $this->redirect(['login/quit']); 
      $power = Yii::$app->session['power']; //权限
      $name = Yii::$app->session['name'];  //姓名
      
      $power_all = User::have_all_power($name); 
      if($power_all[7] == 0){ //无权查看用户的信息
         return $this->redirect(['user/user']);
      }
      if(Yii::$app->request->isGet){
         $user_id = Yii::$app->request->get('user_id');
         if(!$user_id){
            return $this->redirect(['user/user']);
         }
         $user_name = User::find()->select('user_name')->where(['id'=>$user_id])->asArray()->one();
         //查询这个人的用户信息
         $dev_infor = User::find_user_infor_by_name($user_name['user_name']);
         //查找这个人的备注信息
         $user_remarks = User::find_user_remarks($user_name['user_name']);
         array_push($dev_infor[0], $user_remarks);
         $dev_arr = explode('@@@@@', $dev_infor[0]['name']);
      }
      return $this->renderPartial('user_look',['dev_infor'=>$dev_infor,'power_all'=>$power_all[8],'dev_arr'=>$dev_arr]);
   }



   /**
    * 模块：用户模块下的修改页面
    * 功能：上级用户修改下级的密码
    * 返回：错误数据显示在本页，成功跳转到用户主页
    */
   public function actionUpdate_password(){
      //判断是否存在session用户,没有则返回登陆页面
      if(!isset(Yii::$app->session['name'])){
         return $this->redirect(['login/quit']); 
      }
      if(Yii::$app->request->isGet){
         $uid = Yii::$app->request->get('name');//获得用户的id
         if(!$uid){
            return $this->redirect(['user/user']);
         }
         //查找此人的姓名
         $user_name =User::find_user_name_by_uid($uid);
         if(!$user_name){
            return $this->redirect(['user/user']);
         }
         $user_name = $user_name['user_name'];
      }

      if(Yii::$app->request->isPost){
         $user_name = Yii::$app->request->post('user_name');
         $new_password = Yii::$app->request->post('new_password');
         $re_password = Yii::$app->request->post('re_password');

         if(!$new_password||!$re_password){
            $infor = Yii::t('yii','Password can not be empty');
            return $this->renderPartial('update_password',['user_name'=>$user_name,'infor'=>$infor]);
         }
         if(!(preg_match('/^[a-zA-Z0-9]{6,10}$/',$new_password))){
            $infor = Yii::t('yii','Password setting is not reasonable');
            return $this->renderPartial('update_password',['user_name'=>$user_name,'infor'=>$infor]);
         }
         if($new_password!=$re_password){
            $infor = Yii::t('yii','two password is not the same');
            return $this->renderPartial('update_password',['user_name'=>$user_name,'infor'=>$infor]);
         }
         $md5 = md5($new_password);
         //修改到数据库中
         $update = User::find()->where(['user_name'=>$user_name])->one();
         $update->password = $md5;
         $update->update();

         Log::add_log(1,5,'update',$user_name,'password');
         //修改成功
         return $this->redirect(['user/user']); 
      }
   	return $this->renderPartial('update_password',['user_name'=>$user_name]);
   }
}