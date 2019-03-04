<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class Remark extends ActiveRecord{

	//连接user_management表
    public static function tableName(){
        return '{{remarks}}';
    }



}