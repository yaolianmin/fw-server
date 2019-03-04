<?php
namespace  frontend\models;

use yii\db\ActiveRecord;



class Dev_remark extends ActiveRecord{

	//连接dev_remarks表
    public static function tableName(){
        return '{{dev_remarks}}';
    }

}