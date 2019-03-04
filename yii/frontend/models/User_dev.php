<?php
namespace  frontend\models;

use yii\db\ActiveRecord;





class User_dev extends ActiveRecord{

	//连接user_management表
    public static function tableName(){
        return '{{user_dev}}';
    }

}