<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		body{
			background-color: #EDF6FA;
			font-size: 12px;
		}
		.center{
			margin-top:60px;
			width: 800px;
			height: 600px;
			overflow: hidden;
			position: relative;
			left: 50%;
			margin-left: -400px;
		}
		.jindutiao{
			width: 600px;
			margin-left: 100px;
			margin-top:30px;
			height: 30px;
		}
		ul{
			list-style: none;
		}
		.jindutiao .width-length li{
			background-color: #CCCCCC;
			height: 6px;
			width:180px;
			border-radius: 4px;
			float: left;
			margin-left: -4px;
		}
		.jindutiao .radius li{
			width: 20px;
			height: 20px;
			border-radius: 50%;
			border:1px solid #CCCCCC;
			float: left;
			text-align: center;line-height: 18px;
			background-color: #CCCCCC;
			color: #fff;
		}
		.radius-one{
			position: relative;
			top: -9px;
			left: -454px;
			background-color: #7ABD54 !important;
			border-color:#7ABD54 !important; 
		}
		.radius-two{
			position: relative;
			top: -31px;
			left: 250px;
		}
		.radius-three{
			position: relative;
			top: -31px;
			left: 400px;
		}
		.shuoming .define li{
			width: 110px;
			height: 20px;
			line-height: 20px;
			float: left;
			margin-top: -10px;
			text-align: center;
		}
		.step_two,.step_one{
			width:460px;
			height: 330px;
			margin-left: 170px;
			margin-top: 30px;
		}
		.step_one li{
			width:100%;
			height: 60px;
		}
		
		.step_two li{
			width:100%;
			height: 60px;
		}
		input{
			height: 25px;
			outline: none;
			border-top: solid 1px #a7b5bc;
        	border-left: solid 1px #a7b5bc;
        	border-right: solid 1px #ced9df;
        	border-bottom: solid 1px #ced9df;
		}
		.get_code:hover{
			cursor: pointer;
		}
		.step_three{
			width:460px;
			height: 330px;
			margin-left: 170px;
			margin-top: 30px;
		}
		.return_button{
			position: relative;
			top: -40px;
			left: 180px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	$(function(){
		//发送第一步
		$('.next_one').click(function(){
			var name = $('.user_name').val();
            var email = $('.e-mail').val();
            var reg = /^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
            if(name && email){
            	if(!reg.test(email)){
            		$('.infor').css('display','block');
            		$('.infor').html('邮箱格式不正确！');
            	}else{
            		$.ajax({
                		url:'./index.php?r=login/find_password',
                		type:'post',
                		data:{'ajax_user_name':name,'ajax_email':email,'<?php echo \Yii::$app->request->csrfParam;?>':'<?php echo \Yii::$app->request->csrfToken?>'},
                		dataType:'text',
                		error:function(){
                    		alert('失败了');
                		},
                		success:function(msg){
                			if(msg == 'success'){
                				$('.step_one').css('display','none');
								$('.step_two').css('display','block');
								$('.infor').css('display','none');
								$('.rad-two').css('color','#7ABD54');
								$('.radius-two').css('background-color','#7ABD54');
								$('.chang_two').css('background-color','#7ABD54');
                			}else{
                				$('.infor').css('display','block');
            					$('.infor').html(msg);
                			}
                		}
            		})
            	}
            }else{
            	$('.infor').css('display','block');
            	$('.infor').html('用户名或邮箱不能为空！');	
            }
		})
		//发送第二步 状态2
		$('.next_two').click(function(){
			pass = $('.pass').val();
			re_pass = $('.repass').val();
			var codes = $('.code').val();
			var post_user = $('.user_name').val();
			if(!codes){
				$('.infor').css('display','block');
            	$('.infor').html('验证码不能为空！');
			}else{
				if( pass != re_pass ){
                	$('.infor').css('display','block');
            		$('.infor').html('两次密码不一样,请重新填写！');
				}else{
					$.ajax({
                		url:'./index.php?r=login/find_password',
                		type:'post',
                		data:{'ajax_pass':pass,'ajax_repass':re_pass,'ajax_post_code':codes,'ajax_post_user':post_user,'<?php echo \Yii::$app->request->csrfParam;?>':'<?php echo \Yii::$app->request->csrfToken?>'},
                		dataType:'text',
                		error:function(){
                    		alert('失败了');
                		},
                		success:function(msg){
                			if(msg == 'success'){
                				$('.step_one').css('display','none');
								$('.step_two').css('display','none');
								$('.step_three').css('display','block');
								$('.infor').css('display','none');
								$('.rad-three').css('color','#7ABD54');
								$('.radius-three').css('background-color','#7ABD54');
								$('.chang_three').css('background-color','#7ABD54');
                			}else{
                				$('.infor').css('display','block');
            					$('.infor').html(msg);
                			}
                		}
            		})
				}
			}
		})

		// 发送邮箱验证码
		$('.get_code').click(function(){
			var email = $('.e-mail').val();
			$(this).attr('disabled',true);
			if(email){
				$.ajax({
                	url:'./index.php?r=login/find_password',
                	type:'post',
                	data:{'ajax_post_email':email,'<?php echo \Yii::$app->request->csrfParam;?>':'<?php echo \Yii::$app->request->csrfToken?>'},
                	dataType:'text',
                	error:function(){
                    	alert('失败了');
                	},
                	success:function(msg){
                		if(msg == 'success'){
                				time_code = setInterval(fun,1000);
								$('.record').css('display','block');
                		}else{
                			$('.infor').css('display','block');
            				$('.infor').html(msg);
                		}
                	}
            	})
			}else{
				$('.infor').css('display','block');
            	$('.infor').html('邮箱不能为空！');
            	$('.step_one').css('display','block');
            	$('.step_two').css('display','none');
            	$('.rad-two').css('color','#CCCCCC');
            	$('.radius-two').css('background-color','#CCCCCC');
            	$('.chang_two').css('background-color','#CCCCCC');
			}
		})
		$('.return').click(function(){
			window.location.href='./index?phpr=index/index';
		})
	})
    i=99;
    function fun(){
    	$('.seconds').html(i);
     	i--;	
     	if(i==-2){
            clearInterval(time_code);
            $(".get_code").attr("disabled", false);
            $('.record').css('display','none');
            $('.seconds').html('100');
            i=99;
     	}
    }
	</script>
</head>
<body>
	<div style="font-size: 12px;color: #666;font-family: '\5b8b\4f53';line-height: 18px">找回密码</div>
	<div class="center">
		<div class="jindutiao">
			<ul class="width-length">
				<li style="background-color:#7ABD54;" class="chang_one"></li>
				<li class="chang_two"></li>
				<li class="chang_three"></li>
			</ul>
			<ul class="radius">
				<li class="radius-one">1</li>
				<li class="radius-two">2</li>
				<li class="radius-three">3</li>
			</ul>
		</div>
		<div class="shuoming">
			<ul class="define">
				<li class="rad-one" style="margin-left:-20px;color:#7ABD54;">身份验证</li>
				<li class="rad-two" style="margin-left:68px;color:#CCC;">重置密码</li>
				<li class="rad-three" style="margin-left:66px;color:#CCC;">成功返回</li>
			</ul>
		</div>
		<div style="clear:both"></div>
		<div class="step_one" >
		    <ul>
		    	<li style="margin-top:40px;">
		    		<span style='display:inline-block;width:80px'>用户名：</span>
					<input type="text" placeholder='输入用户名' class="user_name">
		    	</li>
		    	<li>
		    		<span style='display:inline-block;width:80px'>邮箱：</span>
					<input type="text" placeholder='注册用户的邮箱' class="e-mail">
					<a href="./index.php?r=login/forget" style="margin-left:20px;color:#005EA7;text-decoration:none;">忘记邮箱？</a>
		    	</li>
		    	<li>
		    		<input type="submit" value="下一步" style="width:110px;background-color:#EFF8E8;" class="next_one">
					<input type="button" value='返回' style="margin-left:100px;width:110px;background-color:#EFF8E8;" class="return">
		    	</li>
		    </ul>
		</div>
		<div class="step_two" style="display:none;">
			<ul>
		    	<li style="margin-top:40px;">
		    		<span style='display:inline-block;width:80px'>新密码：</span>
					<input type="password" class="pass">
					<span style='color:#ccc;margin-left:10px;'>6-10位字符,字母、数字</span>
		    	</li>
		    	<li>
		    		<span style='display:inline-block;width:80px'>确认密码：</span>
					<input type="password" class="repass">
		    	</li>
		    	<li>
		    		<input type="text" value="" style='display:inline-block;width:80px;' class="code">
					<input type="button" value='获取邮箱验证码' style="margin-left:30px;width:110px;background-color:#F6F6F6;" class="get_code">
					<span style='color:#666666;width:325px;display:none;' class='record'>你好，我们已向您的邮箱发送验证码，请查收，<span class='seconds'>100</span>s&nbsp&nbsp内有效</span>
		    	</li>
		    	<li>
		    		<input type="submit" value="下一步" style="width:110px;background-color:#EFF8E8;" class="next_two">
					<input type="button" value='返回' style="margin-left:80px;width:110px;background-color:#EFF8E8;" class="return">
		    	</li>
		    </ul>
		</div>
		<div class="step_three" style="display:none;">
			<div style="margin-top:18px;margin-left:30px;">
				<img src="./images/success.png" alt="">
				<input type="submit" value="返回" style="width:110px;background-color:#EFF8E8;" class="return_button return">
			</div>
		</div>
		<div style="margin-left:280px;color:red;margin-top:-100px;display:none" class="infor">信息填写错误，请重新填写</div>
	</div>
</body>
</html>