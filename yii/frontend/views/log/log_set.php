<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
    .old_view{margin-top: 60px;margin-left: 98px;width: 900px;float: left;overflow: hidden;}
	.now_div li,.old_view li{float: left;width: 100px;height: 30px;text-align: center;line-height: 30px;border-radius: 4px;margin-right: 20px;margin-top: 20px;}	
	.now_div{margin-top: 90px;float:left;width:900px;}
	.backups,.upgrade{background-color: #3B95C8;color: #fff;border-radius: 6px;}
	.backups{float: left;width: 100px;border: 1px solid #D3DBDE;height: 30px;text-align: center;line-height: 30px;border-radius: 4px;margin-right: 20px;margin-top: 20px;}
	.checked,.checkbox{float: left;}
	.checked{margin-left: 10px;margin-right: 8px;margin-top: 8px;}
	</style>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?= Yii::t('yii','position')?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?= Yii::t('yii','home page')?>></a></li>
	            <li><a href="./index.php?r=log/log"><?= Yii::t('yii','log management')?>></a></li>
	            <li><a href="#"><?= Yii::t('yii','log set')?></a></li>
	        </ul>
	    </div>
	    <form action="" method="get" style="max-width:900px;">
			<div class="old_view">
		    	<span><?= Yii::t('yii','log level')?></span>
		    	<ul style="margin-left:86px;">
		    		<li>
		    			<input type="checkbox"  class="checked"  name="log_tips" <?php if($log_set['log_tips']){echo 'checked';}?> />
		    			<span class="checkbox" ><?= Yii::t('yii','tips')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_warn" <?php if($log_set['log_warn']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','warning')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_type" <?php if($log_set['log_type']){echo 'checked';}?>  />
		    			<span class="checkbox"><?= Yii::t('yii','operation')?></span>
		    		</li>	
		    	</ul>
		    </div>
		    <div class="now_div" style="margin-left:98px;">
		    	<span ><?= Yii::t('yii','log type')?></span>
		    	<ul style="margin-left:86px;">
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_dev" <?php if($log_set['log_dev']){echo 'checked';}?> />
		    			<span class="checkbox" ><?= Yii::t('yii','device')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_file" <?php if($log_set['log_file']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','file')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_item" <?php if($log_set['log_item']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','item')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_user" <?php if($log_set['log_user']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','user')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_system" <?php if($log_set['log_system']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','system')?></span>
		    		</li>
		    		<li>
		    			<input type="checkbox"  class="checked" name="log_upgrade" <?php if($log_set['log_upgrade']){echo 'checked';}?> />
		    			<span class="checkbox"><?= Yii::t('yii','upgrade')?></span>
		    		</li>
		    	</ul>
		    </div>
		    <div class="now_div" style="margin-left:98px;">
		    	<ul style="margin-left:86px;">
		    		<input type="submit" class="backups" value="<?= Yii::t('yii','confirm')?>" name="log_set">
		    		<li class="upgrade"><?= Yii::t('yii','cancel')?></li>
		    	</ul>
		    </div>
		    <input type="hidden" name="r" value="log/log_set" />
		</form>
	</div>
</body>
</html>