<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/user_add.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;"> 
	    <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user/user" ondragstart="return false"><?=Yii::t('yii','user management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','add user');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="user_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add user');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 信息表单栏 -->
		<form class="user_form">
			<ul>
				<li>
					<span class='span'><?=Yii::t('yii','user name');?><i style='color:#ea2020;'>*</i></span>
					<input type="text" style="width:220px;float: left;" class="input user_name" required>
					<div style="float:left;margin-left:30px;color:#ccc"><?=Yii::t('yii','within 12 characters');?></div>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','password');?><i style='color:#ea2020;'>*</i></span>
					<input type="password" style="width:220px;float:left;" class="input password">
					<div style="float:left;margin-left:30px;color:#ccc"><?=Yii::t('yii','6-15 characters, numbers, letters');?></div>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','confirm pass');?><i style='color:#ea2020;'>*</i></span>
					<input type="password" style="width:220px;" class="input re_password" required ">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','phone');?></span>
					<input type="text" style="width:220px;" class="input phone">
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','email');?></span>
					<input type="email" style="width:220px;float: left" class="input email">
					<div style="float:left;margin-left:30px;color:#ccc"><?=Yii::t('yii','you can get password back');?></div>
				</li>
				<li>
					<span class='span'><?=Yii::t('yii','level');?></span>
					<div class="user_jibie">
					        <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose')?></span>
							<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='user_dec_jibie' class='power' required>
								<option value="<?=Yii::t('yii','please choose');?>"><?=Yii::t('yii','please choose');?></option>
								<option value="PM" style="display:<?php if(\Yii::$app->session['power']<11){echo 'none';}?>">PM</option>
								<option value="FAE" style="display:<?php if(\Yii::$app->session['power']<6){echo 'none';}?>">FAE</option>
								<option value="普通用户" style="display:<?php if(\Yii::$app->session['power']<4){echo 'none';}?>"><?=Yii::t('yii','common user');?></option>
								<option value="其他" style="display:<?php if(\Yii::$app->session['power']<4){echo 'none';}?>"><?=Yii::t('yii','other');?></option>
					</select>
				</li>
				<li style="clear: both;" class="user_dev_inf"></li>
				<li style="clear:both;position: relative;margin-top: -14px;" class="user_dev_inf">
					<span class='span'><?=Yii::t('yii','device');?></span>
					<div class="span mouseover" style=" width:462px;height:100px;overflow:auto;border:1px solid #A7B5BC">
				    </div>
					<div class="box"></div>
					<div class="content_device" style="overflow:auto;">
						<?php foreach ($device as $val) {
						?>
							<div title="点击添加" style="margin-left: 10px;"><?=$val['name']?></div>
						<?php
						}?> 	
					 </div>
				</li>
				<img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add-devs user_dev_inf">
				<li style="clear: both;height: 10px;" class="user_dev_inf"></li>
				<li>
					<span class='span' style='float:left'><?=Yii::t('yii','permissions limit');?></span>
					<ul style="width:400px;height:180px;float:left;">
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[0] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','device kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm common_power own_dev_look">
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[1] == 0){echo 'none';}?>">
									<input type="checkbox" class="own_dev_aud">
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[2] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','item kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox" class="user_input pm own_item_look">
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[3] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_item_aud">
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[4] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','file kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm common_power own_file_look">
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[5] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input own_file_upload">
									<span><?=Yii::t('yii','upload');?></span>
								</li>
								<li style="display:<?php if($power_all[6] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm common_power own_file_download">
									<span><?=Yii::t('yii','download');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;display:<?php if($power_all[7] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','user kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input pm own_user_look">
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[8] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_user_aud">
									<span><?=Yii::t('yii','add update delete');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:360px;display:<?php if($power_all[9] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','log kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;float:left;">
									<input type="checkbox"  class="user_input pm own_log_look"> 
									<span><?=Yii::t('yii','look');?></span>
								</li>
								<li style="display:<?php if($power_all[10] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_log_download">
									<span><?=Yii::t('yii','download');?></span>
								</li>
								<li style="display:<?php if($power_all[11] == 0){echo 'none';}?>">
									<input type="checkbox"  class="user_input pm own_log_update">
									<span><?=Yii::t('yii','update log set');?></span>
								</li>
							</ul>
						</li>
						<li style="margin-top:10px;width:300px;width:300px;display:<?php if($power_all[12] == 0){echo 'none';}?>">
							<span style='float:left;width:70px;'><?=Yii::t('yii','upgrade kind');?></span>
							<ul style="float:left;">
								<li style="margin-left:12px;">
									<input type="checkbox"  class="user_input own_upgrade">
									<span><?=Yii::t('yii','upgrade');?></span>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li style="clear:both;margin-top:-30px;">
				<span class='span' ><?=Yii::t('yii','remark');?></span>
                    <textarea class="remark" style="border:solid 1px #a7b5bc;resize:none;width:450px;height:100px;float:left;padding-left:10px;font-size:10pt;"></textarea>
                </li>
				<li style="clear:both;margin-bottom:30px;margin-top:100px;">
					<input type="button" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="user_btn" onclick='check()'>
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_btn">
					<span style="margin-left:20px;color:red;display:none;" class='user_add_tip'></span>
				</li>
			</ul>
		</form>
	</div>
</body>
<script type="text/javascript">
	$(function(){
		//级别的下拉框
		$('#user_dec_jibie').change(function(){
			var val =$(this).val();
			$('.user_jibie span').html(val);

			//PM FAE默认拥有的权限
			if(val== 'PM'){

				$('.user_input').prop('checked','');
                $('.pm').prop('checked','true'); 
               	$('.user_dev_inf').css('display','none');
			}else if(val== 'FAE'){ //普通户用 其他默认权限

				$('.user_input').prop('checked','');
                $('.pm').prop('checked','true');
				$('.user_dev_inf').css('display','block');
			}else if(val== '普通用户'||val== '其他'){ //普通户用 其他默认权限

				$('.user_input').prop('checked','');
				$('.common_power').prop('checked','true');
				$('.user_dev_inf').css('display','block');
			}else if(val== '请选择'){ //没选择
				$('.user_dev_inf').css('display','block');
				$('.user_input').prop('checked','');
			};
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
        	var val = $(this).html();
        	var nums = $('.mouseover input').length;
	            var aa = 0;
	            for(var i=0;i<nums;i++){
	                if($('.mouseover input').eq(i).val()== val){
	                    aa=1;
	                }
	            }
	            if(!aa){
	                $('.mouseover').append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi'  readonly/><img src='./images/delete1.png'class='delete_attr'></div>")
	            } 
        })
        $(document).on('mouseover','.dev_brand',function(){
        	$(this).find('input').css('background-color','#E5EBEE');
        	$(this).find('img').css('display','block');
        })
        $(document).on('mouseleave','.dev_brand',function(){
        	$(this).find('input').css('background-color','#fff');
        	$(this).find('img').css('display','none');
        })
         $(document).on('click','.delete_attr',function(){
        	$(this).parent('.dev_brand').remove();
        })
    })
    //验证表单
    function check(){
    	var user_name         = $('.user_name').val();
    	var password          = $('.password').val();
    	var re_password       = $('.re_password').val();
    	var phone             = $('.phone').val();
    	var email             = $('.email').val();
    	var power             = $('.power').val();
    	var own_dev_look      = $('.own_dev_look').prop('checked');
    	var own_dev_aud       = $('.own_dev_aud').prop('checked');
    	var own_item_look     = $('.own_item_look').prop('checked');
    	var own_item_aud      = $('.own_item_aud').prop('checked');
    	var own_file_look     = $('.own_file_look').prop('checked');
    	var own_file_upload   = $('.own_file_upload').prop('checked'); 
    	var own_file_download = $('.own_file_download').prop('checked');
    	var own_user_look     = $('.own_user_look').prop('checked');
    	var own_user_aud      = $('.own_user_aud').prop('checked');
    	var own_log_look      = $('.own_log_look').prop('checked');
    	var own_log_download  = $('.own_log_download').prop('checked');
    	var own_log_update    = $('.own_log_update').prop('checked');
    	var own_upgrade       = $('.own_upgrade').prop('checked');
    	var remark            = $('.remark').val(); 
    	var dev_length        = $('.dev_brand').length;
    	var user_dev = new Array();
    	if(dev_length){
    		for(var i=0;i<dev_length;i++){
    		 user_dev[i] = $('.pinpaizhi').eq(i).val();
    		}
    	}
    	if(!user_name){
    		$('.user_add_tip').html("<?=Yii::t('yii','The username can not be empty')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	if(user_name.length >12){
    		$('.user_add_tip').html("<?=Yii::t('yii','within 12 characters');?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	if(!password){
    		$('.user_add_tip').html("<?=Yii::t('yii','Password can not be empty')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	var reg_pass = /^[0-9a-zA-Z]{6,15}$/;
    	if(! reg_pass.test(password)){
    		$('.user_add_tip').html("<?=Yii::t('yii','6-15 characters, numbers, letters')?>");
    		$('.user_add_tip').css('display','inline-block');
    		return false;
    	}
    	if(password != re_password){
    		$('.user_add_tip').html("<?=Yii::t('yii','two password is not the same')?>" );
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
    	if(power =='请选择'){
    		$('.user_add_tip').html('请选择级别');
    		$('.user_add_tip').css('display','inline-block');
    		return false;	
    	}
    	var date = {
    		'user_name':user_name,
    		'password':password,
    		're_password':re_password,
    		'phone':phone,
    		'email':email,
    		'power':power,
    		'user_dev':user_dev,
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
            url:'./index.php?r=user/user_add',
            type:'get',
            data:{'ajax_add_user':date},
            dataType:'json',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
               if(msg != 'success'){
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