<?php
namespace  frontend\models;

use yii\db\ActiveRecord;



class Item_remarks extends ActiveRecord{

	//连接item_remarks表
    public static function tableName(){
        return '{{item_remarks}}';
    }

}