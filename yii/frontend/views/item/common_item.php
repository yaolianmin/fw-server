<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
    <link href="css/common_dev.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
	<script type="text/javascript" src='./js/common_item.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=item/item" ondragstart="return false"><?=Yii::t('yii','item management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','common item');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="device_infor">
	    	<ul>
	    		<li style="float:left;margin-left:-36px;" class="common_dec_add">
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add');?><?=Yii::t('yii','common item');?></a>
	    		</li>
	    		<li style="float:left;" >
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','delete');?><?=Yii::t('yii','common item');?></a>
	    		</li>
	    	</ul>
	    </div>
	   <!--  表单信息栏 -->
	    <form action="" class="dev_add_form" method="get">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','device name');?></span>
					<div class="common_add_jibie">
					    <span style="height:34px;border:none;margin-left:10px;text-index;"><?=Yii::t('yii','please choose');?><?=Yii::t('yii','device');?></span>
						<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='common_add_dec_jibie' name="common_item">
						<?php
						foreach ($items as $val) {
						?>
						<option value="<?=$val['item_name']?>"><?=$val['item_name']?></option>
						<?php
						}
						?>
					</select>
					<span style='color:#66C9F3;margin-left:-10px;margin-top:-40px;display:none' class='tips'>（<?=Yii::t('yii','The deletion here is only the order of the display of the item, and it does not delete the item itself');?>）</span>
				</li>
				<input type="hidden" value="0" class="common_flag" name="flag">
				<input type="hidden" name="r" value="item/common_item">
				<li style="clear:both">
					<input type="submit" value="<?=Yii::t('yii','confirm');?>" style="margin-left:60px;margin-right:60px;" class="dev_add_btn">
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn">
				</li>
	    	</ul>
	    </form>
	</div>
</body>
</html>