<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Dev_attribute extends ActiveRecord{

	//连接dev_attribute表
    public static function tableName(){
        return '{{dev_attribute}}';
    }



}