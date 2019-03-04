<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>游客页面</title>
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script src="js/jquery.scrollBanner.js" type="text/javascript"></script>
</head>
<body>
   <?=Html::cssFile('css/product.css')?>
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
            <ul>
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
       <!--  轮播图 -->
		<div id="banner"></div>
        <!-- 机种展示区 -->
		<div class="product">
			<img src="./images/biaoge.png" class="biaoge">
            <header>机种展示</header>
            <aside class='right'>更多展示>></aside>
            <ul>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
            </ul>
		</div>
	</div>
</body>
<script type="text/javascript">

    /***********轮播插件**************/    
    $("#banner").scrollBanner({
        images : [
            {src:"images/20160420110752.jpg",title:"智威亚有限公司",href:"#"},
            {src:"images/20160420110852.jpg",title:"banner2",href:"#"},
            {src:"images/20170803170230.jpg",title:"banner3",href:"#"},
            {src:"images/201706011512507745.jpg",title:"banner4",href:"#"}
        ],
        scrollTime:3000,
        bannerHeight:"500px",
        iconColor: "#FFFFFF",
        iconHoverColor : "#82C900",
        iconPosition : "center"
    });

     /*************机种分类************/
    $('.discrption').mouseover(function(){
        $('.kind').fadeIn('slow');
        $('.kinds').css('background-color','#E0E0E0');
    })

     /*************机种分类消失************/
    $('.kinds').mouseleave(function(){
         $('.kind').fadeOut('slow');
         $('.kinds').css('background-color','#fff');
    })

     /*************登录************/
    $('.login').click(function(){
        window.location.href = '/index.php?r=index/index';
    })

     /*************机种展示************/
    $('.right').click(function(){
        window.location.href = '/index.php?r=product/product'; 
    })
</script>
</html>