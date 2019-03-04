<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Item_attribute_val extends ActiveRecord{

	//连接item_attribute_val表
    public static function tableName(){
        return '{{item_attribute_val}}';
    }



}