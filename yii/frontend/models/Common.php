<?php

namespace frontend\models;
use Yii;
use yii\base\Model;
use frontend\models\Log;
use frontend\models\Login;


/**
* 作用：这里添加公共方法，供其他模块调用。
*
*
*
*  @copyright Copyright (c) 2017 – www.zhiweiya.com
*  @author yaolianmin
*  @version 1.0 2017/10/8 10:06
*/

class Common extends Model{

    /**
     *功能：切换语言
     *参数：$language
     *@return
     */
    public function change_language($language=''){
        if($language){
            Yii::$app->session['language']=$language; //将语言修改至session中
            $re = Login::updateAll(['language'=>$language],['user_name'=>Yii::$app->session['user_name']]);
            if($re){
                return 'success';
            }
                             
        }  
      }
  
      /**
       *功能：退出系统，销毁session值
       *@return
       */
      public function exit_system(){
              $session = Yii::$app->session->destroy();
              
              return 'success';     
      }


       
    

}