<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Item_siyou extends ActiveRecord{

	//连接item_siyou_connect表
    public static function tableName(){
        return '{{item_siyou_connect}}';
    }



}