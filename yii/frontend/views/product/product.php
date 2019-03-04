
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>游客页面</title>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>
<body>
<?=Html::cssFile('css/product_index.css')?>
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
        <hr style="color:#ccc;width:100%;float:left;margin-top:10%;">
        <!-- 机种展示区 -->
        <div class="dev_show">
        <img src="./images/list.png" alt="" class="lists">
        	<header>机种展示区</header>
        	<ul class="first">
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
        		<li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
        		<li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
        		<li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
        		<li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
        		<li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>
                <li title="这是一款非常好的机种，赶快来购买吧！"><a href="/index.php?r=product/detial">AC-1028</a></li>

        	</ul>
        	<div class="rights">
        		<img src="./images/111.png" alt="">
        	</div>
        </div>
    </div> 
   <div class="site-contact">
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($form, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('验证一下', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
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