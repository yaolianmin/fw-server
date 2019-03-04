<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link rel="stylesheet" href="./css/user_update.css">
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<link href="css/mask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	 <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
    	<div style="font-size:14px;margin-left:90px;margin-top:60px;">Are you sure delete these options ?</div>
    	<div>
    		<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="user_shadow_sure" />
    		<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_shadow_quxiao" />
    	</div>
    </div>
    <!-- 遮罩层结束 -->
	<div style="min-width:980px;font-size: 9pt;"> 
	    <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="#" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user/user" ondragstart="return false"><?=Yii::t('yii','user management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','update user');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="user_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','update user');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息 -->
	    <form class="user_form">
			<ul>
				<li>
					<span class='span'><?=Yii::t('yii','user name');?></span>
					<input type="text" style="width:220px;float: left;" class="input user_names"  value="<?=$dev_infor[0]['user_name']?>" required>
					<input type="hidden" value="<?=$dev_infor[0]['id']?>" class="user_name user_id"/>
					<div style="float:left;margin-left:30px;color:#ccc"><?=Yii::t('yii','within 12 characters');?></div>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','phone');?></span>
					<input type="text" style="width:220px;" class="input phone" value="<?=$dev_infor[0]['phone']?>">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','email');?></span>
					<input type="email" style="width:220px;" class="input email" value="<?=$dev_infor[0]['email']?>">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','level');?></span>
					<div class="user_jibie">
					        <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose');?></span>
							<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select id='user_dec_jibie' class='power'>
								<option value="PM" style="display:<?php if(\Yii::$app->session['power']<11){echo 'none';}?>" <?php if($dev_infor[0]['power']==10){echo 'selected';}?>>PM</option>
								<option value="FAE" style="display:<?php if(\Yii::$app->session['power']<6){echo 'none';}?>" <?php if($dev_infor[0]['power']==5){echo 'selected';}?>>FAE</option>
								<option value="<?=Yii::t('yii','common user');?>" style="display:<?php if(\Yii::$app->session['power']<4){echo 'none';}?>" <?php if($dev_infor[0]['power']==1){echo 'selected';}?>><?=Yii::t('yii','common user');?></option>
								<option value="<?=Yii::t('yii','other');?>" style="display:<?php if(\Yii::$app->session['power']<1){echo 'none';}?>" <?php if($dev_infor[0]['power']==-1){echo 'selected';}?>><?=Yii::t('yii','other');?></option>
					</select>
				</li>
				<li>
					<span class='span' style='float:left'><?=Yii::t('yii','permissions limit');?></span>
					<ul style="width:300px;height:180px;float:left">
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[0] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','device kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm common_power own_dev_look" <?php if($dev_infor[0]['own_dev_look']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[1] == 0){echo 'none';}?>">
									<input type="checkbox" class="own_dev_aud" <?php if($dev_infor[0]['own_dev_aud']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[2] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','item kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm common_power own_item_look" <?php if($dev_infor[0]['own_item_look']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[3] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_item_aud" <?php if($dev_infor[0]['own_item_aud']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($power_all[4] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','file kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm common_power own_file_look" <?php if($dev_infor[0]['own_file_look']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[5] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input own_file_upload" <?php if($dev_infor[0]['own_file_upload']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','upload');?></span>
								</li>
								<li style="display:<?php if($power_all[6] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm common_power own_file_download" <?php if($dev_infor[0]['own_file_download']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','download');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[7] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','user kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm own_user_look"<?php if($dev_infor[0]['own_user_look']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[8] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_user_aud" <?php if($dev_infor[0]['own_user_aud']){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($power_all[9] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','log kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm own_log_look" <?php if($dev_infor[0]['own_log_look']==1){echo 'checked="on"';}?>> 
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[10] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_log_download"  <?php if($dev_infor[0]['own_log_download']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','download');?></span>
								</li>
								<li style="display:<?php if($power_all[11] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_log_update" <?php if($dev_infor[0]['own_log_update']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','update log set');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;width:300px;display:<?php if($power_all[12] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','upgrade kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input own_upgrade"     <?php if($dev_infor[0]['own_upgrade']==1){echo 'checked="on"';}?>>
									<span><?=Yii::t('yii','upgrade');?></span>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li style="clear:both"></li>
				<li style="margin-top:-34px;position: relative;" class='user_dev_inf'>
					<span class='span'><?=Yii::t('yii','device');?></span>
					<div class="span center_dev" style=" width:460px;height:100px;overflow:auto;border:1px solid #A7B5BC">
                  	<?php
                  	if($dev_infor[0]['name'][0]){
                  		foreach($dev_infor[0]['name'] as $val) {
                  	?>
						<div class='dev_brand'><input type='text' value="<?=$val?>" class='pinpaizhi attributes' readonly/><img src='./images/delete1.png'class='delete_attr'></div>
                  	<?php
                  	}	
                  	}
                  	?>
                    </div>
					<div class="box"></div>
                    <div class="content_device">
                   <?php
 						foreach($device as $val){
 					?>
						<div title="点击添加" style="margin-left:10px;"><?=$val['name']?></div>
 					<?php 	
 					}
                    ?>
                     </div>
				</li>
				<img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add-devs user_dev_inf">
                <li style="margin-top:60px;clear: both;">
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea class="remark" style="border:solid 1px #a7b5bc;resize:none;width:454px;height:100px;float:left;font-size:10pt;padding-left:10px;"><?php if(isset($dev_infor[0][0][0]['remarks'])){echo $dev_infor[0][0][0]['remarks'];}?></textarea>
                </li>
                <div class="reurn_infor"></div>
				<li style="clear:both;margin-top:10px;">
					<input type="button" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="user_btn" onclick='check()'>
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_btn">
					<input type="button" value="<?=Yii::t('yii','update password');?>" class="user_btn update_password" style="margin-left:50px;width:100px;">
				</li>
				<li style="margin-left:300px;color:red;display:none" class='user_add_tip'></li>
			</ul>
		</form>
	</div>
</body>
<script type="text/javascript">
	$(function(){
		//获得级别的输入框
		var jibie_ = $('#user_dec_jibie').val();
		$('.user_jibie span').html(jibie_);

		//修改密码按钮
		$('.update_password').click(function(){
			var user_name = $('.user_name').val();
         	window.location.href = './index.php?r=user/update_password&name='+user_name;
		});

		//级别的下拉框
		$('#user_dec_jibie').change(function(){

			var val =$(this).val();
	    	$('.user_jibie span').html(val);
        })
        $(document).on('mouseover','.dev_brand',function(){
        	$(this).find('input').css('background-color','#E5EBEE');
        	$(this).css('background-color','#E5EBEE');
        	$(this).find('img').css('display','block');
        })
         $(document).on('mouseleave','.dev_brand',function(){
        	$(this).find('input').css('background-color','#fff');
        	$(this).css('background-color','#fff');
        	$(this).find('img').css('display','none');
        })

        $('.add-devs').click(function(){
        	$('.box').css('display','block');
        	$('.content_device').css('display','block');
        })
        $('.content_device').mouseleave(function(){
        	$('.box').css('display','none');
        	$('.content_device').css('display','none');
        })

        $('.content_device div').click(function(){
        	var user_id = $('.user_id').val();
        	var val = $(this).html();
            var date ={
            	'ajax_add_uid':user_id,
            	'ajax_add_dev':val
            }
        	$.ajax({
		            url:'./index.php?r=user/user_update',
		            type:'get',
		            data:{'ajax_add':date},
		            dataType:'json',
		            error:function(){
		                alert('失败了');
		            },
		            success:function(msg){
		               if(msg){
		               		$('.user_add_tip').html(msg);
		    				$('.user_add_tip').css('display','inline-block');
		    				return false;
		               }else{
			                var aa = 0;var nums = $('.pinpaizhi').length;
				            for(var i=0;i<nums;i++){
				                if($('.pinpaizhi').eq(i).val()== val){
				                    aa=1;
				                }
				            }
				            if(!aa){
				                $('.center_dev').append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi' name='brand[]' readonly/><img src='./images/delete1.png'class='delete_attr'></div>");
				            } 
		               }
		            }
        		})        
        })
        // 删除私有属性 属性值
        $(document).on('click','.delete_attr',function(){
        	var user_id = $('.user_id').val();
        	var user_dev = $(this).prev().val();
        	var this_father = $(this).parent('.dev_brand');
        	$('.user_shadow').css('display','block');
        	$('.user_shadow_content').css('display','block');
        	$('.user_shadow_quxiao').click(function(){
        		$('.user_shadow').css('display','none');
        		$('.user_shadow_content').css('display','none');	
        	})
        	$('.user_shadow_sure').click(function(){
        		$.ajax({
		            url:'./index.php?r=user/user_update',
		            type:'get',
		            data:{'ajax_delete_uid':user_id,'ajax_delete_dev':user_dev},
		            dataType:'text',
		            error:function(){
		                alert('失败了');
		            },
		            success:function(msg){
		               if(msg){
		               		$('.user_add_tip').html(msg);
		    				$('.user_add_tip').css('display','inline-block');
		    				return false;
		               }else{
		               	$('.user_shadow').css('display','none');
        				$('.user_shadow_content').css('display','none');
		               	this_father.remove();
		               }
		            }
        		})
        	})
        	
        })
	})

	function check(){
    	var user_names = $('.user_names').val();
    	var user_id = $('.user_id').val();
    	var phone = $('.phone').val();
    	var email = $('.email').val();
    	var power = $('.power').val();
    	var own_dev_look      = $('.own_dev_look').prop('checked')?1:0;
    	var own_dev_aud       = $('.own_dev_aud').prop('checked')?1:0;
    	var own_item_look     = $('.own_item_look').prop('checked')?1:0;
    	var own_item_aud      = $('.own_item_aud').prop('checked')?1:0;
    	var own_file_look     = $('.own_file_look').prop('checked')?1:0;
    	var own_file_upload   = $('.own_file_upload').prop('checked')?1:0; 
    	var own_file_download = $('.own_file_download').prop('checked')?1:0;
    	var own_user_look     = $('.own_user_look').prop('checked')?1:0;
    	var own_user_aud      = $('.own_user_aud').prop('checked')?1:0;
    	var own_log_look      = $('.own_log_look').prop('checked')?1:0;
    	var own_log_download  = $('.own_log_download').prop('checked')?1:0;
    	var own_log_update    = $('.own_log_update').prop('checked')?1:0;
    	var own_upgrade       = $('.own_upgrade').prop('checked')?1:0;
    	var remark            = $('.remark').val(); 
    	if(!user_names){
    		$('.user_add_tip').html("<?=Yii::t('yii','The username can not be empty')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	if(user_names.length >12){
    		$('.user_add_tip').html("<?=Yii::t('yii','within 12 characters');?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	var reg_phone =  /^1\d{10}$/;
    	if(!reg_phone.test(phone)){
    		$('.user_add_tip').html("<?=Yii::t('yii','phone format is incorrect')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	var reg_email =  /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    	if(!reg_email.test(email)){
    		$('.user_add_tip').html("<?=Yii::t('yii','email format is incorrect')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	if(!power){
    		$('.user_add_tip').html('请添加用户级别');
    		$('.user_add_tip').css('display','inline-block');
    		return false;	
    	}
    	var date = {
    		'user_name':user_names,
    		'user_id':user_id,
    		'phone':phone,
    		'email':email,
    		'power':power,
    		'own_dev_look':own_dev_look,
    		'own_dev_aud':own_dev_aud,
    		'own_item_look':own_item_look,
    		'own_item_aud':own_item_aud,
    		'own_file_look':own_file_look,
    		'own_file_upload':own_file_upload,
    		'own_file_download':own_file_download,
    		'own_user_look':own_user_look,
    		'own_user_aud':own_user_aud,
    		'own_log_look':own_log_look,
    		'own_log_download':own_log_download,
    		'own_log_update':own_log_update,
    		'own_upgrade':own_upgrade,
    		'remark':remark
    	}

    	$.ajax({
            url:'./index.php?r=user/user_update',
            type:'get',
            data:{'ajax_update_user':date},
            dataType:'json',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
               if(msg){
               		$('.user_add_tip').html(msg);
    				$('.user_add_tip').css('display','inline-block');
    				return false;
               }else{
               	window.location.href = './index.php?r=user/user';
               }
            }
        }) 
	}
</script>
</html>
