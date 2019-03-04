<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Item_attribute extends ActiveRecord{

	//连接item_attribute表
    public static function tableName(){
        return '{{item_attribute}}';
    }



}