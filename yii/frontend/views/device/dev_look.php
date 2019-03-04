<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/dev_look.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript">
    $(function(){
        $('.mouseover div').click(function(){
            var val = $(this).html();
            var dev_name = $('.dev_name').val();
        })
        //点击修改信息的按钮
        $('.dev_look_btn').click(function(){
            var dev_id = $('.dev_id').val();
            window.location.href = './index.php?r=device/dev_update&dev_id='+dev_id;
        })  
    })
    </script>
</head>
<body>
    <div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','device');?> <?=Yii::t('yii','details');?></a></li>
	        </ul>
	    </div>
	    <!-- 机种详情 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','device');?> <?=Yii::t('yii','details');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息栏 -->
	    <div class="dev_add_form">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','device name');?></span>
					<input type="text" style="width:220px;" class="input dev_name" readonly value="<?=$dev_name['name']?>" >
                    <input type="hidden"  class="dev_id" value="<?=$dev_id?>" />
	    		</li>
	    		
                <?php
                foreach ($gongyou as $val) {
                ?>
                <li>
                    <span class='span'><?=$val['aname']?></span>
                    <input type="text" style="width:220px;" class="input" readonly value="<?=$val['vname']?>">
                </li>
                <?php
                }
                ?>
                 <?php
                foreach ($siyou as $val) {
                ?>
                <li>
                    <span class='span'><?=$val['aname']?></span>
                    <input type="text" style="width:220px;" class="input" readonly value="<?=$val['vname']?>">
                </li>
                <?php
                }
                ?>
                <li style="height:auto;width:96%;">
                    <span class='span'><?=Yii::t('yii','brand');?></span>
                    <div class="mouseover span">
                        <?php
                        foreach ($pinpai as $val) {
                        ?>
                        <div class='dev_brand'><input type='text' value="<?=$val['vname']?>" class='pinpaizhi attributes' readonly/></div>
                        <?php   
                        }
                        ?>
                    </div>
                </li>
                <li>
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea name="remarks[]" readonly class="remark"><?=$remarks['dev_re_name']?></textarea>
                </li>
                <li style="display:<?php if($power[1]){echo 'block';}else{echo 'none';}?>" class='insert_here'>
                    <input type="submit" value="<?=Yii::t('yii','update information');?>" class="dev_look_btn">
                </li>
	    	</ul>
	    </div>
	</div>
</body>
</html>