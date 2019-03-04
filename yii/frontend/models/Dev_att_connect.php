<?php
namespace  frontend\models;

use yii\db\ActiveRecord;



class Dev_att_connect extends ActiveRecord{

	//连接dev_attribute_connect表
    public static function tableName(){
        return '{{dev_attribute_connect}}';
    }

}