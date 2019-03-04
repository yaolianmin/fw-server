<?php
use yii\helpers\Html;
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>智威亚科技有限公司</title>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>
<body>
<?=Html::cssFile('css/detail.css')?>
    <div class="top">
		 <div class="img">
            <img src="./images/logo.gif" alt="">
        </div>
        <div class="login">
            <img src="./images/denglu.png" style="background-color:blue;">
            <span>登录</span>
        </div>
		<header>
			<input type="text" placeholder='请输入机种名'>
			<span>搜索</span>
        </header>
        <div class="kinds">
            <span>机种分类</span>
            <ul >
                <li class='first discrption'>设备类型</li>
                <li class='discrption'>卡类型</li>
                <li class='discrption'>应用场景</li>
            </ul>
             <div class="kind">
                <ul class="out">
                    <li>
                        <ul>
                            <li>AP</li>
                            <li>AC</li>
                            <li>CPE</li> 
                       </ul>
                    </li>

                    <li>
                        <ul>
                            <li>单卡2.4G</li>
                            <li>双卡2.4G</li>
                            <li>单卡5.8G</li>
                            <li>双卡5.8G</li>
                            <li>双卡2.4G&5.8G</li>
                       </ul>
                    </li>
                    <li>
                        <ul>
                            <li>室内</li>
                            <li>室外</li>
                       </ul>
                    </li>
                </ul>
            </div>
        </div>
       
        <!-- 机种详情 -->
        <div class="detail">
        	
            <header style='font-size:20px;color:#7a7a7a;'>机种详情</header>
        	<aside>AC-1028</aside>
        	<ul class="level"> 
        		<li>设备类型</li>
        		<li>卡类型</li>
        		<li>应用场景</li>
        	</ul>
        	<ul class="level-right">
        		<li>AP</li>
        		<li>单卡2.4G</li>
        		<li>室内</li>
        	</ul>
        </div> 
        <hr style="color:#ccc;width:100%;float:left;">
        <div class="beizhu">
            <aside>机种说明</aside>
        	<p>这是一种时尚的机种，适用于任何场合的使用，主要用户机械，公司的大型项目，主要。。。。。。</p>
        </div>
        <div class="document">
        	<aside>机种文件下载区</aside>
        	<ul>
        		<li><a href="">ZAC-1023-name</a></li>
        		<li><a href="">ZAC-1023-name</a></li>
        		<li><a href="">ZAC-1023-name</a></li>
        		<li><a href="">ZAC-1023-name</a></li>
        		<li><a href="">ZAC-1023-name</a></li>
        		<li><a href="">ZAC-1023-name</a></li>
        	</ul>
        </div>
	</div>
</body>
<script type="text/javascript">

    
     /************登录*************/
    $('.login').click(function(){
        window.location.href = '/index.php?r=index/index';
    })

     /*************机种分类************/
    $('.discrption').mouseover(function(){
        $('.kind').fadeIn('slow');
         $('.kinds').css('background-color','#E0E0E0');
    })

     /*************机种消失************/
    $('.kinds').mouseleave(function(){
         $('.kind').fadeOut('slow');
          $('.kinds').css('background-color','#fff');
    })
</script>
</html>