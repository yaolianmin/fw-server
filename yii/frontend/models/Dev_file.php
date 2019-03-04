<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\User;
use frontend\models\Device;
use frontend\models\Dev_attribute;
use frontend\models\Dev_attribute_val;
use frontend\models\Version_name;
use frontend\models\Log;



class Dev_file extends ActiveRecord{
    //连接dev_files表
    public static function tableName(){
        return '{{dev_files}}';
      }


   /**
    * 功能:根据不同的人 机种 品牌 版本号 获得不同返回值
    * 参数：用户名  机种 品牌 版本号
    * 返回：数据数组
    */
    public function find_device_pinpai_version_by_cond($user_name='',$device='',$pinpai='',$version=''){
        if($user_name){
          $uid = User::find()->select('id')->where(['user_name'=>$user_name])->asArray()->one();
          $sql = "select device.name from user_dev left join device on user_dev.did=device.id where user_dev.uid='".$uid['id']."' order by user_dev.common_used desc";

          $devices = Yii::$app->db->createCommand($sql)->queryAll(); //用户的所有机种
        }

        $return  = []; //函数返回的数据数组
        if(!$device){ //如果没有参数机种
          if(isset($devices[0]['name'])){ 
                $device = $devices[0]['name'];
                $return['device'] = $devices;
          }else{ //如果这个人没有机种 返回空
                return $return;
          }
        }
      
      $did = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();

      $pid = Dev_attribute::find()->select('aid')->where(['aname'=>'品牌'])->asArray()->one(); //品牌的id

      //获得机种的品牌
      $sql_pin = "select dev_attribute_val.vname  from dev_attribute_val left join dev_attribute on dev_attribute.aid=dev_attribute_val.aid left join dev_attribute_connect on dev_attribute_val.id=dev_attribute_connect.vaid where dev_attribute.aid='".$pid['aid']."' and dev_attribute_connect.did='".$did['id']."'";
      $pinpais = Yii::$app->db->createCommand($sql_pin)->queryAll(); //第一个机种的所有品牌
      if(!$pinpai){
          $pinpai =$pinpais[0]['vname'];
          $return['pinpai'] = $pinpais;
      }
      $pin_id = Dev_attribute_val::find()->select('id')->where(['vname'=>$pinpai])->asArray()->one(); //品牌值的id

      //获得品牌值的所有版本号
      $versions = Version_name::find()->where(['did'=>$did['id'],'pid'=>$pin_id['id']])->asArray()->all();
      if(!$version){
          if(isset($versions[0]['version_name'])){
              $version = $versions[0]['version_name'];
              $return['version'] = $versions;
          }else{
              $return['version'] = '';
              return $return;
          }
      }
      //获得版本号的文件
      if($version){
          $vid = Version_name::find()->select('id')->where(['version_name'=>$version])->asArray()->one();
          $files = Dev_file::find()->where(['vid'=>$vid['id']])->asArray()->all();
          $return['file'] = $files;
      }else{
          $files = '';
      }
      return $return;
    }

    /**
    * 功能:添加版本号
    * 参数：机种 品牌 版本名
    * 返回: 布尔
    */
    public function add_version($get){
        try{
            $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

            $device  = $get['ver_add_dev']; //机种
            $pinpai  = $get['ver_add_pin']; //品牌值
            $version_name = $get['version_name']; // 版本名

            $did = Device::find()->select('id')->where(['name'=>$device])->asArray()->one();
            $pid = Dev_attribute_val::find()->select('id')->where(['vname'=>$pinpai])->asArray()->one();

            $version = new Version_name();
            $version->did = $did['id'];
            $version->pid = $pid['id'];
            $version->version_name = $version_name;
            $version->save();

            $transaction->commit();//提交事务会真正的执行数据库操作
            return true;
        }catch(\Exception $e){
             $transaction->rollback();//如果操作失败, 数据回滚
        }
       
    }
      /**
       * 功能：添加文件
       * 参数：post提交的信息
       * 返回：true
       */
     public function add_dev_file($post){
        if($post){
            try{
                $transaction= Yii::$app->db->beginTransaction(); // 开启数据库的事务

                $did = Device::find()->select('id')->where(['name'=>$post['file_add_dev']])->asArray()->one(); //机种id 
                $pid = Dev_attribute_val::find()->select('id')->where(['vname'=>$post['file_add_pin']])->asArray()->one(); //品牌值id
                $vid = Version_name::find()->select('id')->where(['version_name'=>$post['file_add_ver']])->asArray()->one(); //版本id

                //存文件
                if(! is_dir('/var/www/fw_server_file')){
                   mkdir('/var/www/fw_server_file');
                }
                $path = '/var/www/fw_server_file/'.time().$_FILES["file"]["name"];
                if(file_exists($path)){
                    return Yii::t('yii','Add failure, the file already exists');
                }

                if($_FILES["file"]["size"]>1000000000){
                     return Yii::t('yii','Add failure, the file can only be less than 1000M');
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
                $dev_file = new Dev_file();
                $dev_file->path = $path;
                $dev_file->file_remarks =$remarks;
                $dev_file->vid = $vid['id'];
                $dev_file->save();

                //添加一条日志至记录中
                Log::add_log(1,7,'add',$_FILES["file"]["name"],'file');
                $transaction->commit();//提交事务会真正的执行数据库操作
                return 'success'; 
            }catch( \Exception $e){
                $transaction->rollback();//如果操作失败, 数据回滚
            }
            
        }
    }
}