<?php
namespace  frontend\models;

use yii\db\ActiveRecord;



class Item_file extends ActiveRecord{

	//连接item_file表
    public static function tableName(){
        return '{{item_file}}';
    }

}