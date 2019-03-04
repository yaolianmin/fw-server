<?php

namespace frontend\models;


use yii\db\ActiveRecord;


class File_remarks extends ActiveRecord{

	//连接dev_attribute_val表
    public static function tableName(){
        return '{{file_remarks}}';
    }



}