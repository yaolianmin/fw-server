<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/user_add.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<style>
	.center_dev span{float: left;width: 100%;}
	.center_dev span:hover{cursor: pointer;background-color: #CDCDCD;}
	input{outline: none;}
	</style>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;">
    <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user_center/user_center" ondragstart="return false"><?=Yii::t('yii','user center');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','personal information');?></a></li>
	        </ul>
	    </div>
	    <form action="" method='post' class="user_form">
			<ul>
				<li>
					<span class='span'><?=Yii::t('yii','user name');?><i style='color:#ea2020;'>*</i></span>
					<input type="hidden" name="hidden_user_name" value="<?php if(isset($post)){echo $post['user_name'];}?>"  class='center_name'/>
					<input type="text" style="width:220px;" class="input" name='user_name' value="<?php if(isset($post)){echo $post['user_name'];}?>" required>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','phone');?></span>
					<input type="text" style="width:220px;" class="input" name="phone" value="<?php if(isset($post)){echo $post['phone'];}?>">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','email');?></span>
					<input type="email" style="width:220px;" class="input" name="email" value="<?php if(isset($post)){echo $post['email'];}?>">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','level');?></span>
					<input type="email" style="width:220px;" class="input" value="<?php if($post['power']=='15'){echo Yii::t('yii','superadministrator');}elseif($post['power']=='10'){echo  'PM';}elseif($post['power']=='5'){echo 'FAE';}elseif($post['power']=='1'){echo  Yii::t('yii','common user');}elseif($post['power']=='-1'){echo  Yii::t('yii','other');}?>" readonly>
				</li>
				<li style="clear:both;">
					<span class='span' style='float:left;width:100px;'><?=Yii::t('yii','permissions limit');?></span>
					<ul style="width:400px;height:180px;float:left">
						<li style="margin-top:10px;width:300px;display:<?php if($post['own_dev_look']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','device kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm common_power" <?php if($post['own_dev_look']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($post['own_dev_aud']==0){echo 'none';}?>">
									<input type="checkbox" <?php if($post['own_dev_aud']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($post['own_item_look']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','item kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm common_power" <?php if($post['own_item_look']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($post['own_item_aud']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_item_aud']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($post['own_file_look']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','file kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm common_power" <?php if($post['own_file_look']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($post['own_file_upload']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input " <?php if($post['own_file_upload']){echo 'checked="on"';}?> disabled />
									<span><?=Yii::t('yii','upload');?></span>
								</li>
								<li style="display:<?php if($post['own_file_download']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm common_power" <?php if($post['own_file_download']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','download');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($post['own_user_look']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','user kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_user_look']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($post['own_user_aud']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_user_aud']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:380px;display:<?php if($post['own_log_look']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','log kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_log_look']){echo 'checked="on"';}?> disabled> 
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($post['own_log_download']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_log_download']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','download');?></span>
								</li>
								<li style="display:<?php if($post['own_log_update']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm" <?php if($post['own_log_update']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','update log set');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;width:300px;display:<?php if($post['own_upgrade']==0){echo 'none';}?>">
							<span style='float:left;width:82px;'><?=Yii::t('yii','upgrade kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input" <?php if($post['own_upgrade']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','upgrade');?></span>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li style="clear:both;">
					<span class='span'><?=Yii::t('yii','device');?></span>
					<div class="span center_dev" style=" width:400px;height:110px;overflow:auto;border:1px solid #A7B5BC">
                  	<?php
                  	foreach ($own_dev as $val) {
                  	?>
						<span type='text' ><?=$val?></span>
                  	<?php	
                  	}
                  	?>
                    </div>
				</li>
				<input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
				<li style="clear:both;margin-bottom:30px;margin-top:90px;">
					<input type="submit" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="user_btn">
					<input type="resert" value="<?=Yii::t('yii','cancel');?>" class="user_btn">
				</li>
			</ul>
		</form>
	</div>
</body>
</html>