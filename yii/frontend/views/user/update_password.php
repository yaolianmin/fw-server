<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/user_add.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;"> 
	    <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user/user"><?=Yii::t('yii','user management');?>></a></li>
	            <li><a href="#"><?=Yii::t('yii','update password');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="user_infor">
	    	<ul>
	    		<li>
	    			<a href=""><?=Yii::t('yii','update password');?></a>
	    		</li>
	    	</ul>
	    </div>
	   <!--  密码 -->
	    <form action="" class="user_form" method="post">
			<ul>
				<li>
					<span class='span'><?=Yii::t('yii','user name');?><i style='color:#ea2020;'>*</i></span>
					<input type="text" style="width:220px;" class="input" value="<?=$user_name?>" readonly name='user_name'>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','password');?><i style='color:#ea2020;'>*</i></span>
					<input type="password" style="width:220px;" class="input" placeholder='6-12' name="new_password">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','confirm pass');?><i style='color:#ea2020;'>*</i></span>
					<input type="password" style="width:220px;" class="input" name="re_password">
				</li>
				<li style="clear:both">
					<input type="submit" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:20px;" class="user_btn">
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_btn">
				</li>
                <li style="color:red;margin-left:200px;margin-top:50px;display:<?php if(!isset($infor)){echo 'none';}?>">
                  <?php if(isset($infor)){echo $infor;}?>  
                </li>
			</ul>
            <input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
	    </form>
	</div>
</body>
</html>