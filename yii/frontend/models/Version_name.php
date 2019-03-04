<?php
namespace  frontend\models;

use yii\db\ActiveRecord;





class Version_name extends ActiveRecord{

	//连接version_name表
    public static function tableName(){
        return '{{version_name}}';
    }

}