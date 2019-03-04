<?php
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<style type="text/css">
	*{padding: 0 ;margin: 0;}
	ul{list-style: none;}
	.wai{width: 200px;float: left;border-bottom:1px solid #B9CAD3;background-color: #D4E7F0;}
	.left header{height: 40px;width: 100%;background-color: #3C96C8;color: #fff;}
	.left img{margin-left: 10px;margin-top: 12px;float: left;border: none;}
	.left span{float: left;line-height: 40px;margin-left: 6px;font-size: 14px;}
    .left li:hover{cursor: pointer;}
    .left .next{display: none;}
    .active{position:relative; background:url(./images/libg.png) repeat; line-height:40px; color:#fff;}
	</style>
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript">
	$(function(){
		$('.wai').click(function(){
			$('.wai').next('ul').slideUp();
			if($(this).next('ul').is(':visible')){
				
				$(this).next('ul').slideUp();
			}else{

				$(this).next('ul').slideDown();
			}
		})
		//导航切换
		$(".next li").click(function(){
			$(".next li").removeClass("active")
			$(this).addClass("active");
		});
	})
	</script>
</head>
<body style="background:#f0f9fd;border-right:1px solid #B7D5DF;height:1600px;">
<div class="left" style="background: url(./images/line.gif) repeat-y right;overflow: hidden;">
    <header>
    	<img src="./images/down.png" alt="" />
    	<span><?=Yii::t('yii','menu navigation');?></span>
    </header>
	<ul>
		<li style="display:<?php if($power<12){echo 'none';}?>">
			<div class="wai">
				<img src="./images/main_.png" alt="" />
				<span><?=Yii::t('yii','homepage');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
                <a href="./index.php?r=index/main" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
                	<li style="float:left;width:100%;">
						<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:14px;" />
						<span><?=Yii::t('yii','homepage');?></span>
					</li>
                </a>
			</ul>
		</li>
		<li>
			<div class="wai">
				<img src="./images/device_.png" alt="" />
				<span><?=Yii::t('yii','device management');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
				<a href="./index.php?r=device/device" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
					<li style="float:left;width:100%;">
						<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:14px;" />
						<span style='color:#551A8B;'><?=Yii::t('yii','device details');?></span>
					</li>
				</a>
			</ul>
		</li>
		<li style="<?php if(!$power_have[7]){echo 'display:none';}?>">
			<div class="wai">
				<img src="./images/usercenter_.png" alt="" />
				<span><?=Yii::t('yii','user management');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
			    <a href="<?=Url::to(['user/user']);?>" style="float:left;width:100%;" target="rightFrame" target = '_self' ondragstart="return false">
					<li style="float:left;width:100%;">
						<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:14px;" />
						<span><?=Yii::t('yii','user information');?></span>
					</li>
				</a>
			</ul>
		</li >
		<li style="display:<?php if(!$power_have[2]){echo 'none';}?>">
			<div class="wai">
				<img src="./images/item_.png" alt="" />
				<span><?=Yii::t('yii','item management');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
			<a href="<?=Url::to(['item/item']);?>" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
				<li style="float:left;width:100%;">
				<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:1s4px;" />
				<span><?=Yii::t('yii','item details');?></span>
				</li>
			</a>
			</ul>
		</li>
		<li style="display:<?php if(!$power_have[9]){echo 'none';}?>">
			<div class="wai">
				<img src="./images/file_.png" alt=""  />
				<span><?=Yii::t('yii','log management');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
			<a href="<?=Url::to(['log/log']);?>" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
				<li style="float:left;width:100%;">
				<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:1s4px;" />
				<span><?=Yii::t('yii','system log');?></span>
				</li>
			</a>
			</ul>
		</li>
		<li>
			<div class="wai">
				<img src="./images/usercenter_.png" alt="" />
				<span><?=Yii::t('yii','user center');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;border:none" class="next">
			<a href="<?=Url::to(['user_center/user_center']);?>" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
				<li style="float:left;width:100%;">
				<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:1s4px;" />
				<span><?=Yii::t('yii','personal information');?></span>
				</li>
			</a>
			</ul>
		</li>
		<li style="display:<?php if(!$power_have[12]){echo 'none';}?>">
			<div class="wai">
				<img src="./images/upgrade_.png" alt=""  style="width:18px;"/>
				<span><?=Yii::t('yii','upgrade management');?></span>
			</div>
			<ul style="width:100%;float:left;background-color:#f0f9fd;" class="next">
			<a href="<?=Url::to(['upgrade/upgrade']);?>" style="float:left;width:100%;" target="rightFrame" ondragstart="return false">
				<li style="float:left;width:100%;">
				<img src="./images/list.gif" alt="" style="margin-left:32px;margin-top:1s4px;" />
				<span><?=Yii::t('yii','upgrade');?></span>
				</li>
			</a>
			</ul>
		</li>
	</ul>
</div>	
</body>
</html>