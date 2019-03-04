<?php

namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\Product;

/**
* 模块：产品宣传
* 说明：由于需求不断的更改，这个功能暂时没有做，等待
* 时间   2018.01.05
* 说明：Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
*       里面的含有所有的翻译中文语言
*
*
*
*/

class ProductController extends Controller{

 
		public function actions(){
        	return [
            	'error' => [
                	'class' => 'yii\web\ErrorAction',
            	],
            	'captcha' => [
                	'class' => 'yii\captcha\CaptchaAction',
                			'maxLength'=>4,
                				'minLength'=>4,
            	],
        	];
    	}






      
	 public function actionProduct(){
	 		$form = new Product();
        	if ($form->load(\Yii::$app->request->post()) && $form->validate()){
            	return $this->refresh();
        	}
		return $this->renderPartial('product',['form'=>$form]);
	   
	}















}