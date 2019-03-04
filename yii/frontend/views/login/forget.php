<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
</head>
<style type="text/css">
	*{padding: 0;margin: 0;}
	body{background-color: #EDF6FA;}
	.top{float: left;width: 35%;height: 100%;position: relative;left: 50%;margin-left: -16%;overflow: hidden;}
	.top img{margin-top: 20%;float: left;width: 30%;overflow: hidden;}
	.top header{margin-top: 20%;float: left;width: 65%;font-weight: bold;font-size: 20px;color: #D39C1F;overflow: hidden;}
	.top .phone{margin-top: 2%;width: 40px}
	.top .p{float: left;color: #D39C1F;font-size: 18px;margin-left: 2%;margin-top: 3%;overflow: hidden;}
	.name,.email{width: 65%;overflow: hidden;}
	.top .email p{margin-top: 4%;}
</style>
<body>
	<div class="top">
		<header>忘记密码了，赶紧联系管理员吧</header>
		<div class='name'>
			<img src="./images/phone.jpg" class="phone">
			<p class="p"><?=$infor['phone']?></p>
		</div>
		<div class="email">
			<img src="./images/youxiang.jpg" class="phone">
			<p class="p"><?=$infor['email']?></p>
		</div>
		<div><input type="submit" style="margin-top:6%;background-color:#3C95C8;color:#fff;width:120px;font-size:16px;border:none;height:30px;line-height:30px;" value="返回上一页" onclick="javascript:history.go(-1)" /></div>
	</div>
</body>
<script type="text/javascript">
	 

</script>
</html>