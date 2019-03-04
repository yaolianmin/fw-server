<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Device;
use frontend\models\Item;
use frontend\models\Item_attribute;
use frontend\models\Item_attribute_val;
use frontend\models\User;
use frontend\models\Dev_file;
use frontend\models\File_remarks;
use frontend\models\Item_siyou;
use frontend\models\Log;
use frontend\models\Item_file;
use yii\data\Pagination;
use yii\helpers\Json;

/**
 * 模块：项目管理的控制器
 * 作用：显示view里面的视图
 * 时间：2018.04.25
 * 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
 *       里面的含有所有的翻译中文语言
 *
 * @author：
 */

class ItemController extends Controller{
    /**
     * 模块：项目管理主页
     * 作用：显示项目的相关信息
     */
    public function actionItem(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
        // 1.1 判断此人是否拥有查看项目的权限
        $power_have =User::have_all_power($user_name); 
        if(!$power_have[2]){
            return $this->redirect(['device/device']);
        }
        // 1.2 获得此人的项目
        $it_infor =Item::get_item_information_by_name($user_name); 
        // 1.3 搜索功能
        $search_name = Yii::$app->request->get('search_item_name');
        if($search_name){
            $it_infor = Item::search_item_infor_by_name($search_name,$user_name);
        }
        // 1.4 分页操作
        $length_dev = count($it_infor);
        $totalCount = $length_dev;
        $page  = new Pagination(['totalCount' =>$totalCount, 'pageSize' =>10]);
        $page_now = Yii::$app->request->get('page');//当前的页数
        $user_dev_new = [];
        if($page_now<=1||is_null($page_now)){ //仅显示前十个数据 
            if($length_dev <= 10){
                $user_dev_new = $it_infor;
            }else{
               $user_dev_new = array_slice($it_infor,0,10);
            } 
        }else{ //第2页数据以上
            if($length_dev <= 10*$page_now){
                for ($i=10*($page_now - 1); $i < $length_dev; $i++) {
                   array_push($user_dev_new,$it_infor[$i]);
                }  
            }else{
                for ($i=10*($page_now-1); $i < 10*$page_now; $i++) { 
                   array_push($user_dev_new,$it_infor[$i]);
                }
            } 
        }
        // 1.5 批量删除操作
        $del_item = Yii::$app->request->get('del_items');
        if($del_item){
            $length = strlen($del_item)-1;
            $del_item = substr($del_item,0,$length);
            $del_item = explode(',', $del_item);
            $rel = Item::delete_item_by_item_id($del_item);
            if($rel == 'success'){
                return $this->redirect(['user_center/success']);
            }elseif($rel === 'false'){
                return $this->renderpartial('item',[
                                            'it_infor'=>$user_dev_new,
                                            'page'=>$page,
                                            'search_name'=>$search_name,
                                            'power'=>$power_have
                                        ]);
            }
        }
        return $this->renderpartial('item',[
                                    'it_infor'=>$user_dev_new,
                                    'page'=>$page,
                                    'search_name'=>$search_name,
                                    'power'=>$power_have
                                ]);
    }


    /**
     * 模块：添加项目的模块
     * 作用：添加项目
     */
    public function actionItem_add(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
        $power_have =User::have_all_power($user_name);
        if(!$power_have[3]){
            return $this->redirect(['item/item']);
        }
        // 1.1 获得所有的FAE用户
        if($power == '5'){
            $fae = [['user_name'=>$user_name]];
        }elseif($power > '5'){
            if($power == '10'){
                $fae = User::find()->select('user_name')->where(['power'=>5])->asArray()->all();
                $self = User::find()->select('user_name')->where(['user_name'=>$user_name])->asArray()->one();
                array_push($fae, $self);
            }else{
                $fae = User::find()->select('user_name')->where(['between', 'power', 4, 14])->asArray()->all();
            }   
        }else{
            return $this->redirect(['item/item']);
        }
        // 1.2 获得所有的普通用户
        if($power == '5'){
            $user = Item::get_self_user($user_name);
        }elseif($power > '5'){
            $user = Item::get_all_user();
        }
        // 1.3 获得所有的机种
        $device = Item::get_self_device($user_name); 
        // 1.4 添加项目
        if(Yii::$app->request->isAjax){
            $item_infor = Yii::$app->request->get('ajax_add_item');
            if($item_infor){
                if(!$item_infor['item_name']) return Json::encode(Yii::t('yii','The name of the item can not be empty'));
                if(strlen($item_infor['item_name']) > 40) return Json::encode(Yii::t('yii','The name of the item is too long'));
                if(!$item_infor['user_manage']) return Json::encode(Yii::t('yii','item managers can not be empty'));
                if(!$item_infor['user_device']) return Json::encode(Yii::t('yii','The type of device required for the item can not be empty'));
                $is_have_item = Item::find()->where(['item_name'=>$item_infor['item_name']])->asArray()->one();
                if($is_have_item) return Json::encode(Yii::t('yii','The name of the item has already existed. Please rename it again'));
                $rel = Item::store_item_inforamtion($item_infor);
                return Json::encode($rel);
            }
        }
        return $this->renderpartial('item_add',['fae'=>$fae,'user'=>$user,'device'=>$device]);
    }



    /**
     *模块：常用项目的添加删除
     *
     */
    public function actionCommon_item(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        //判断此人是否拥有查看项目的权限
        $power_have =User::have_all_power($user_name); 
        if(!$power_have[2]){
            return $this->redirect(['item/item']);
        }
        // 1.1 查询这个人拥有的项目
        $items = Item::get_all_items_by_user_name($user_name);
        // 1.2 获得表单提交的数据
        $get = Yii::$app->request->get();
        if(isset($get['common_item'])){
            if($get['flag']){ //表示删除操作
                $del_rel = Item::del_common_item($get['common_item'],$user_name);
                if($del_rel){
                    return $this->redirect(['item/item']);
                }
            }else{ //表示添加操作
                $add_rel = Item::add_common_item($get['common_item'],$user_name);
                if($add_rel){
                    return $this->redirect(['item/item']);
                }
            }
        }
        return $this->renderpartial('common_item',['items'=>$items]);
    }

    /**
     * 模块：项目管理的查看页面
     * 作用：查看单个项目的详细信息
     */
    public function actionItem_look(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])) return $this->redirect(['login/quit']); 
        
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
        $item_name = Yii::$app->request->get('item_id'); //项目的id
        if(!$item_name) return $this->redirect(['item/item']);
        // 1.1 判断此人是否拥有查看项目的权限
        $power_have =User::have_all_power($user_name); 
        if(!$power_have[2]) return $this->redirect(['device/device']);
        // 1.2 查询这个项目的详细信息
        $item_information = Item::find_item_all_information($item_name); 
        return $this->renderpartial('item_look',['item_infor'=>$item_information,'power_have'=>$power_have]);
    }


    /**
     * 模块：项目管理的修改页面
     * 作用：修改项目的相关信息
     */
    public function actionItem_update(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
     
        // 1.5 修改项目的各个信息(不能放在后面，否则报302的错误)
        if(Yii::$app->request->isAjax){
            // 1.5.0 添加属性值
            $add_item_att = Yii::$app->request->get('ajax_add_item_att');
            if($add_item_att){
                switch ($add_item_att['flag']) {
                    case 'user_manage':
                        $rel = Item::add_manager_by_ajax($add_item_att['item_id'],$add_item_att['item_att'],'项目管理者');
                        return Json::encode($rel);
                    case 'user_client':
                        $rel = Item::add_manager_by_ajax($add_item_att['item_id'],$add_item_att['item_att'],'项目所属客户');
                        return Json::encode($rel);
                    case 'user_device':
                        $rel = Item::add_suoxu_device_by_ajax($add_item_att['item_id'],$add_item_att['item_att']);
                        return Json::encode($rel);
                    default:
                        return Json::encode(Yii::t('yii','Transfer data error, please add again'));
                }
            }
            // 1.5.1 删除属性值的操作
            $ajax_delete_item_att = Yii::$app->request->get('ajax_delete_item_att');
            if($ajax_delete_item_att){
                switch ($ajax_delete_item_att['flag']) {
                    case '1':
                        $rel = Item::delete_user_by_ajax($ajax_delete_item_att['item_id'],$ajax_delete_item_att['val']); 
                        return Json::encode($rel);  
                    case '2':
                        $rel = Item::delete_user_by_ajax($ajax_delete_item_att['item_id'],$ajax_delete_item_att['val']); 
                        return Json::encode($rel);
                    case '3':
                        $rel = Item::delete_device_by_ajax($ajax_delete_item_att['item_id'],$ajax_delete_item_att['val']); 
                        return Json::encode($rel);
                    default:
                        return Json::encode(Yii::t('yii','Transfer data error, please add again'));   
                }
            }
            // 1.5.2 ajax删除项目私有属性属性值
            $siyou_id = Yii::$app->request->get('siyou_id');
            if($siyou_id){
                $rel = Item::delete_siyou_by_ajax($siyou_id);
                return $rel;
            }
            // 修改项目的ajax操作
            $item_infor = Yii::$app->request->get('ajax_update_item');
            if($item_infor){
                if(!$item_infor['item_name']) return Json::encode(Yii::t('yii','The name of the item can not be empty'));
                if(strlen($item_infor['item_name'])>40) return Json::encode(Yii::t('yii','The name of the item is too long'));
                $rel = Item::update_item_information($item_infor);
                return Json::encode($rel);
            }
        }
        // 1.0 获得项目名
        $item_name = Yii::$app->request->get('item_id'); //项目id
        if(!$item_name){
            return $this->redirect(['item/item']);
        }
        // 1.1 查询这个项目的详细信息
        $item_information = Item::find_item_all_information($item_name);
        // 1.2 获得所有的FAE用户
        if($power == '5'){
            $fae = [['user_name'=>$user_name]];
        }elseif($power > '5'){
            if($power == '10'){
                $fae = User::find()->select('user_name')->where(['power'=>5])->asArray()->all();
                $self = User::find()->select('user_name')->where(['user_name'=>$user_name])->asArray()->one();
                array_push($fae, $self);
            }else{
                $fae = User::find()->select('user_name')->where(['between', 'power', 4, 14])->asArray()->all();
            } 
        }else{
            return $this->redirect(['item/item']);
        }
        // 1.3 获得所有的普通用户
        if($power == '5'){
            $user = Item::get_self_user($user_name);
        }elseif($power > '5'){
            $user = Item::get_all_user();
        }
        // 1.4 获得所有的机种
        $device = Item::get_self_device($user_name); 
        return $this->renderpartial('item_update',['item_infor'=>$item_information,'fae'=>$fae,'user'=>$user,'device'=>$device]);
    }
    /**
     * 模块：项目的文件
     * 功能：添加 删除 下载项目的文件
     */
    public function actionItem_files(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']); 
        }

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
        
        $user_name = Yii::$app->session['name']; //用户名
        $power = Yii::$app->session['power']; //权限
        $item = Item::get_all_items_by_user_name($user_name);

        //查看此人是否拥有文件的相关操作（默认都有查看下载自己的机种文件，不管是否赋予权限）
        $power_is_have = User::have_all_power($user_name);
        // 1.0 获得项目的所有文件
        $item_files = Item::get_item_files($user_name);
        // 1.0.0 ajax的操作
        if(Yii::$app->request->isAjax){
            // 1.0.0项目替换获得的信息
            $ajax_item = Yii::$app->request->get('ajax_download_item');
            if($ajax_item){
                $item_files = Item::get_item_files($user_name,$ajax_item);
                $files = ''; //返回的文件信息
                $file_re = ''; // 限制返回文件的备注长度
                if($item_files){
                    foreach ($item_files as $val) {
                        if(mb_strlen($val['file_remarks'])>35){
                            $file_re .= mb_substr($val['file_remarks'],0,34).'...'.'&&&&&';
                        }else{
                            $file_re .= $val['file_remarks'].'&&&&&';
                        }
                        $files .= $val['id'].'%%%%%'.substr($val['path'],34).'%%%%%'.$val['file_remarks'].'*****';
                    }
                }
                $return  = $files.'#####'.$file_re;
                return $return;   
            }
        }
        // 1.1 添加文件的操作
        $add_file_item = Yii::$app->request->post('add_file_item');
        if($add_file_item){
            $file = Yii::$app->request->post();
            if($_FILES['file']['name']){
                $rel = Item::add_item_file($file);
                if($rel = 'success'){
                    return $this->redirect(['item/item']);
                }else{
                    return $this->renderpartial('item_files',['item'=>$item,'files'=>$item_files]);
                }
            }
        }
        // 1.2 下载文件的操作
        $download_file_id = Yii::$app->request->get('download_id');
        if($download_file_id){
            $path = Item_file::find()->select('path')->where(['id'=>$download_file_id])->asArray()->one();
            $new_path = substr($path['path'], 34);
            //判断文件是否存在
            if(!file_exists($path['path'])){
                $tips =  '404 Not find file!';
                return $this->renderpartial('item_files',['item'=>$item,'files'=>$item_files,'power'=>$power_is_have]);
            }
            // 判断文件是否过大
            $size = filesize($path['path']);
            if($size>1400000000){
                 $tips =  '文件过大，请更换文件';
                return $this->renderpartial('item_files',['item'=>$item,'files'=>$item_files,'tips'=>$tips,'power'=>$power_is_have]);
            } 
            // 传递信息个浏览器
            if($path['path']){    
                set_time_limit(0); //脚本解析时间设置为永远
                ini_set('memory_limit', '1500M'); //因单个文件规定需要1G的大小，readfile函数在php.ini配置的到校为200M
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.$new_path);
                header('Content-Transfer-Encoding: binary');
                ob_end_clean();
                readfile($path['path']);    
            }  
            //添加一条日志至数据库中
            Log::add_log(1,4,'download',$new_path,'file');  
        }
        
        // 1.3 批量删除文件的操作
        $delete_file_id = Yii::$app->request->get('batch_delete_id');
        if($delete_file_id){
            $len = strlen($delete_file_id)-1;
            $delete_file_id = substr($delete_file_id,0,$len);
            $delete_file_id = explode(',', $delete_file_id);
            foreach ($delete_file_id as $val) {
                try{
                    $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务
                    $path = Item_file::find()->select('path')->where(['id'=>$val])->asArray()->one();
                    if(file_exists($path['path'])){
                         unlink($path['path']);
                    }
                    Item_file::deleteAll("id='".$val."'");

                    //添加一条日志至数据库中
                    Log::add_log(1,4,'delete',substr($path['path'],34),'file');
                    $transaction->commit();//提交事务会真正的执行数据库操作 
                }catch( \Exception $e){
                     $transaction->rollback();//如果操作失败, 数据回滚
                }
            }
            return $this->redirect(['item/item_files']);   
        }
        return $this->renderpartial('item_files',['item'=>$item,'files'=>$item_files,'power'=>$power_is_have]);
    }
}