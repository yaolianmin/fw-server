<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="icon"  href="images/favicon.ico">
    <title>ZWA后台管理系统</title>
    <link rel="stylesheet" href="css/index.css" />
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="js/fw_verifyjs.js"></script>
</head>
<body style="overflow:hidden;">
    <div class="form" id="form"> 
        <table>
	    <form action="" method="post">
	        <caption>请登陆</caption>
	    	<tr  class="first">
		    	<td class="usename left">用户名：</td>
		    	<td><input type="text" name="user_name" id="user_name" value="<?php if(isset($information)){echo $post['user_name'];}?>" /></td>
		    	<td></td>
	    	</tr>
	    	<tr> 
	    		<td class="password left">密码：</td>
	    		<td><input type='password' style="width:150px;height:24px;border:none;background-color:#fff;margin-bottom:18px;" id="md_pass"  /></td>
	    		<td></td>
	    	</tr>
	    	
	        <tr style="margin-top:30px;">
	         	<td class="vertify left" >验证码：</td>
	        	<td><input type="text" name="verify" id="ver" value="<?php if(isset($information)){echo $post['verify'];}?>" /></td>
	         	<td ><img src="/index.php?r=verify/verify" id='code'></td>
	        </tr>
	           <tr>
	           	<td><input type="hidden" name="passwords" id="hidden" /></td>
	           	<td><div class='show_infor' style="display:<?php if(isset($information)){echo 'block';}?>"><?php if(isset($information)){echo $information;}?></div></td>
	           	<td></td>
	           </tr> 
	    	<tr class="login">
	    		<td><input type="submit" value="登录" id="login"  /></td>
	    		<td class="button"><input type="reset" value="重置" id="button" /></td>
	    		<td><a href="./index.php?r=login/find_password" class="forget">忘记密码？</a></td>		
	    	</tr>
	    	<input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
	    </form>
        </table>
    </div>
</body>
<script type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript">
    var user_name = document.getElementById('user_name');
	var pass = document.getElementById('md_pass');
	var hidden = document.getElementById('hidden');
	pass.onblur = function(){

         var val = hex_md5(pass.value);
            hidden.value = val;     
	}
	user_name.onblur = function(){
        var val = hex_md5(pass.value);
            hidden.value = val;
	}
</script>
</html>