<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Dev_attribute_val extends ActiveRecord{

	//连接dev_attribute_val表
    public static function tableName(){
        return '{{dev_attribute_val}}';
    }



}