<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ZWA后台管理系统</title>
<link href="css/position.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .success{width: 490px;margin-top: 75px;padding-top: 65px; background:url('./images/success.png') no-repeat;}
    .success h2{margin-left: 154px;}
    .return_last{color: #fff;background: #3c95c8;display: block;line-height: 35px;text-align: center;border-radius: 3px;margin-top: 20px;width: 130px;margin-left: 160px;}
</style>
<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
<script type="text/javascript" src='./js/exit.js'></script>
<script language="javascript">
	$(function(){
        $('.success').css({'position':'absolute','left':($(window).width()-360)/2});
    	$(window).resize(function(){  
             $('.success').css({'position':'absolute','left':($(window).width()-360)/2});
        }) 

        $('.return_last').click(function(){
           window.history.go(-1);
        }) 
    });  
</script> 
</head>
<body style="background:#edf6fa;">
	<div class="place">
        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
        <ul class="placeul">
            <li><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','information hints');?></a></li>
        </ul>
    </div>
    <div class="success" style="position: absolute; left: 555px;">
    <h2><?=Yii::t('yii','operation succeeded');?>！</h2>
    <div class="return_last"><?=Yii::t('yii','previous page');?></div> 
    </div>
</body>
</html>
