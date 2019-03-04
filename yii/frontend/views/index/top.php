<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<style type="text/css">
	body{
		padding: 0;
		margin: 0;
		min-width: 980px;
		background:url('./images/topbg.gif');
		overflow: hidden;
	}
	a{
		text-decoration: none;
	}
	ul{
		list-style:none;
		float: left;
	}
	.top{
		height: 88px;
	}
	.top .top-header{
		float: left;
		height: 88px;
		width: 600px;
		background: url('./images/topleft.jpg') no-repeat;
	}
	.top .top-header img{
		float: left;
		margin-top: 12px;
		margin-left: 12px;
	}
	.top .top-header span{
		font-size: 19px;
		height: 88px;
		line-height: 90px;
		margin-left: 14px;
		color: #fff;
	}
	.top .header-pic{
		float: left;

	}
	.top .header-pic ul li{
		width: 110px;
		height: 88px;
		float: left;
		margin-top: -16px;
	}
	.top .header-pic ul li img{
		float: left;
		margin-top: 16px;
		margin-left: 30px;
		width: 45px;
	}
	.top .header-pic ul li  span{
		width: 110px;
		text-align: center;
		color: #fff;
		float: left;
	}
	.top .header-pic ul li:hover{
		background-color: #0E79AF;
		cursor: pointer;
	}
	.top .top-footer{
		float: right;
		height: 88px;
		background: url('./images/topright.jpg') no-repeat;
	}
	
	.top .top-footer ul li{
		float: right;
		width: 90px;
		text-align: center;
		margin-right: 14px;
		color: #fff;
	}
	.top .top-footer .user{
        height: 30px;
        width: 110px;
        margin-top: 8px;
        margin-right: 10px;
		border-radius: 30px;
		background: url('./images/ub1.png') no-repeat;
	}
	.top .top-footer .user span{
		float: left;
		height: 30px;
		width: 110px;
		text-align: center;
		line-height: 30px;
		font-size: 13px;
		color:#b8ceda;
	}
	.user span{text-align: center;}
	.return_souye,.quit_xitong:hover{
		cursor: pointer;
	}
	</style>
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript">
	$(function(){
		$('.quit_xitong').click(function(){
			top.location.href = './index.php?r=login/index&action=12312';
		})
		//切换语言的功能
		$('.language').change(function(){
			var val = $(this).val();
			$.ajax({
                url:'./index.php?r=index/top',
                type:'get',
                data:{'language':val},
                dataType:'text',
                error:function(){
                    alert('失败了');
                },
                success:function(msg){

                  top.location.reload();
                }
            })
		})
	})
	</script>
</head>
<body>
    <div class="top">
    	<header class='top-header'>
    	    <img src="./images/logo.gif" alt="" />
    		<span style='width:400px;'><?=Yii::t('yii','backstage management information system');?></span>
    	</header>
    	<footer class='top-footer'>
	    	<div>
	    		<a href="./index.php?r=index/main" style="color:#b8ceda;font-size:14px;" target="rightFrame" ondragstart="return false"><?=Yii::t('yii','go home');?></a>
	    		<span style='color:#b8ceda;font-size:14px;'>|</span>
	    		<a href="#" style="color:#b8ceda;font-size:14px;" class='quit_xitong' ondragstart="return false"><?=Yii::t('yii','quit');?></a>
	    	</div>
	    	<div class="user">
	    		<span><?=Yii::$app->session['name']?></span>	
	    	</div>
	    	<div></div>
    	</footer>
    	<select class="language" id="language" style="text-aline:center;float:right;margin-top:32px;margin-right:20px;">
                      <option value="zh-CN" <?php if(\Yii::$app->session['language']=="zh-CN"){echo 'selected';}?>>中文</option>
                      <option value="en" <?php if(\Yii::$app->session['language']=="en"){echo 'selected';}?>>English</option>
                      <option value="zh-TW" <?php if(\Yii::$app->session['language']=="zh-TW"){echo 'selected';}?>>中文繁體</option>
        </select>
    </div>
</body>
</html>