<?php
namespace  frontend\models;

use yii\db\ActiveRecord;





class User_item extends ActiveRecord{

	//连接user_item表
    public static function tableName(){
        return '{{user_item}}';
    }

}