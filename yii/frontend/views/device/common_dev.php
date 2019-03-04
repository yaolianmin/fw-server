<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ZWA后台管理系统</title>
<link href="css/common_dev.css" rel="stylesheet" type="text/css" />
<link href="css/position.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
<script type="text/javascript" src='./js/exit.js'></script>
<script type="text/javascript">
$(function(){
	$('.device_infor ul li').click(function(){ //添加 删除Class的切换
		//获取当前的位置
		var common_index = $(this).index();
		$('.device_infor ul li').removeClass('common_dec_add');
		$(this).addClass('common_dec_add');
		//判断是添加还是删除
		$('.common_flag').val(common_index);
		if(common_index == 1){
			$('.tips').css('display','block');
		}else{
			$('.tips').css('display','none');
		}
	});
	//机种的下拉框
	$('#common_add_dec_jibie').change(function(){
		$('.common_add_jibie span').html($(this).val());
	})
	var val = $('#common_add_dec_jibie').val();
	$('.common_add_jibie span').html(val);
})
</script>
</head>
<body>
	<div class="common_top">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#"><?=Yii::t('yii','common device');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="device_infor">
	    	<ul>
	    		<li style="float:left;margin-left:-36px;" class="common_dec_add">
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add common device');?></a>
	    		</li>
	    		<li style="float:left;" >
	    			<a href="#" style="width:120px;" ondragstart="return false"><?=Yii::t('yii','delete common device');?></a>
	    		</li>
	    	</ul>
	    </div>
	   <!--  表单信息栏 -->
	    <form action="" class="dev_add_form" method="get">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','device name');?></span>
					<div class="common_add_jibie">
					    <span class="common_device"><?=Yii::t('yii','please choose');?><?=Yii::t('yii','device');?></span>
						<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='common_add_dec_jibie' name="common_dev">
						<?php
							foreach ($device as $val) {
						?>
							<option value="<?=$val['name']?>"><?=$val['name']?></option>
						<?php
							}
						?>
					</select>
					<span class='tips'>（<?=Yii::t('yii','The deletion here is only the order of the display of the device, and it does not delete the device itself');?>）</span>
				</li>
				<input type="hidden" value="" class="common_flag" name="flag">
				<input type="hidden" name="r" value="device/common_dev">
				<li style="clear:both">
					<input type="submit" value="<?=Yii::t('yii','confirm');?>" style="margin-left:60px;margin-right:60px;" class="dev_add_btn">
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn">
				</li>
	    	</ul>
	    </form>
	</div>
</body>
</html>