<?php
namespace  frontend\models;

use yii\db\ActiveRecord;



class Item_device extends ActiveRecord{

	//连接item_device表
    public static function tableName(){
        return '{{item_device}}';
    }

}