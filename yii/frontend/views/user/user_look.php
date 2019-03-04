<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link rel="stylesheet" href="./css/user_update.css">
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<style>
	.center_dev span:hover{background-color: #CDCDCD;}
	</style>
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;"> 
	    <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="#" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user/user" ondragstart="return false"><?=Yii::t('yii','user management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','user information');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="user_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','user information');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息 -->
	    <div class="user_form">
			<ul>
				<li>
					<span class='span'><?=Yii::t('yii','user name');?></span>
					<input type="text" style="width:220px;" class="input"  value="<?=$dev_infor[0]['user_name']?>" readonly>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','phone');?></span>
					<input type="text" style="width:220px;" class="input"  value="<?=$dev_infor[0]['phone']?>" readonly>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','email');?></span>
					<input type="email" style="width:220px;" class="input" value="<?=$dev_infor[0]['email']?>" readonly>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','level');?></span>
					<input type="text" style="width:220px;" class="input"  value="<?php if($dev_infor[0]['power'] ==15){echo '超级管理员';}elseif($dev_infor[0]['power'] ==10){echo 'PM';}elseif($dev_infor[0]['power'] ==5){echo 'FAE';}elseif($dev_infor[0]['power'] ==1){echo Yii::t('yii','common user');}elseif($dev_infor[0]['power'] ==-1){echo Yii::t('yii','other');}?>" readonly>
				</li>
				<li style="clear:both;">
					<span class='span' style='float:left'><?=Yii::t('yii','permissions limit');?></span>
					<ul style="width:300px;height:180px;float:left">
						<li style="margin-top:10px;width:300px;display:<?php if($dev_infor[0]['own_dev_look']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','device kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input" <?php if($dev_infor[0]['own_dev_look']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_dev_aud']==0){echo 'none';}?>">
									<input type="checkbox" <?php if($dev_infor[0]['own_dev_aud']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($dev_infor[0]['own_item_look']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','item kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input"<?php if($dev_infor[0]['own_item_look']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_item_aud']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input"<?php if($dev_infor[0]['own_item_aud']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($dev_infor[0]['own_file_look']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','file kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input"<?php if($dev_infor[0]['own_file_look']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_file_upload']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input "<?php if($dev_infor[0]['own_file_upload']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','upload');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_file_download']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input" <?php if($dev_infor[0]['own_file_download']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','download');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($dev_infor[0]['own_user_look']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','user kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input" <?php if($dev_infor[0]['own_user_look']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_user_aud']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input" <?php if($dev_infor[0]['own_user_aud']){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($dev_infor[0]['own_log_look']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','log kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input"<?php if($dev_infor[0]['own_log_look']==1){echo 'checked="on"';}?> disabled> 
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_log_download']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input" <?php if($dev_infor[0]['own_log_download']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','download');?></span>
								</li>
								<li style="display:<?php if($dev_infor[0]['own_log_update']==0){echo 'none';}?>">
									<input type="checkbox"  class="user_input"<?php if($dev_infor[0]['own_log_update']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','update log set');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;width:300px;display:<?php if($dev_infor[0]['own_upgrade']==0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','upgrade kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input"<?php if($dev_infor[0]['own_upgrade']==1){echo 'checked="on"';}?> disabled>
									<span><?=Yii::t('yii','upgrade');?></span>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class='user_dev_inf' style="clear:both;">
					<span class='span'><?=Yii::t('yii','device');?></span>
					<div class="span center_dev" style=" width:400px;height:110px;overflow:auto;border:1px solid #A7B5BC">
                  	<?php
                  	foreach ($dev_arr as $val) {
                  	?>
						<span type='text' style='width:100%;float:left;'><?=$val?></span>
                  	<?php	
                  	}
                  	?>
                    </div>
				</li>
				<li style="clear:both;margin-top:90px;">
                    <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea name="remark[]" id="" style="border:solid 1px #a7b5bc;resize:none;width:390px;height:100px;float:left;padding-left:10px;font-size:10pt;" readonly><?php if(isset($dev_infor[0][0][0]['remarks'])){echo $dev_infor[0][0][0]['remarks'];}?></textarea>
                </li>
				<?php
				if($power_all){
				?>
				<li style="clear:both;margin-top:90px;">
				    <a href="./index.php?r=user/user_update&user_id=<?=$dev_infor[0]['id']?>">
				    	<input type="submit" value="<?=Yii::t('yii','update');?> <?=Yii::t('yii','user information');?>" style="margin-left:100px;margin-right:50px;width:150px;" class="user_btn">
				    </a>	
				</li>
				<?php
				}
				?>			
			</ul>
		</div>	
	</div>
</body>
</html>