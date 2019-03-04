<?php

namespace frontend\models;
use yii\db\ActiveRecord;



class Upgrade extends ActiveRecord{


	//连接user_management表
    public static function tableName(){
        return '{{version}}';
    }

    //查找当前的版本号
    public function find_now_version(){
    	$version = Upgrade::findOne(['statue' =>'1']);
    	if($version){
    		return $version->version;
    	}
    }



    //查找所有的历史版本号
    public function find_history_version(){
    	$version = Upgrade::find()->where(['statue' =>'0'])->asArray()->all();
    	if($version){
    		$return =[];
    		foreach ($version as $val) {
    			array_push($return, $val['version']);
    		}
    	    return $return;
    	}
    }


    //备份数据库并放至 /var/www/fw-server/backups/ 的文件夹下
    public function backups_db(){

    	$filename = '/var/www/fw-server/backups/'.time();

        $version_now = Upgrade::find_now_version(); //找到当前的版本

        $sql_backups = 'mysqldump -hlocalhost -uroot -pmysql_yii fw_server'." > ".$filename.'fw_server'.$version_now.'.'.'sql';

        exec($sql_backups);
        $filename = $filename.'fw_server'.$version_now.'.'.'sql';
        if($filename){   
            $size = filesize($filename);
            Header('Content-Type: text/html;charset=utf-8'); //发送指定文件MIME类型的头信息
            Header("Accept-Ranges: bytes");
            Header("Content-Length:".$size); //发送指定文件大小的信息，单位字节
            Header("Content-Disposition:attachment; filename=".$filename); //发送描述文件的头信息，附件和文件名   
            readfile($filename);      
        }   
        unlink($filename);// 删除刚才下载的日志
        Log::add_log(1,9,'backups','data base');
        return true;
    }


    //修改过度版本为当前的版本
    public function update_version(){
    	
    	Upgrade::updateAll(['version'=>'V1.0.0.2'],['statue'=>'1']);
    }



}