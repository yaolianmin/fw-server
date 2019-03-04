<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="css/item_look.css">
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript">
    $(function(){
        //跳转到修改页面
        $('.dev_look_btn').click(function(){
            var val = $('.item_id').val();
            window.location.href = './index.php?r=item/item_update&item_id='+val;
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
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','item management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','item');?><?=Yii::t('yii','details');?></a></li>
	        </ul>
	    </div>
	    <!-- 机种详情 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','item');?><?=Yii::t('yii','details');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息栏 -->
	    <div class="dev_add_form">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','item name');?></span>
					<input type="text" style="width:400px;" class="input dev_name" readonly value="<?=$item_infor[0]['item_name']?>" >
                    <input type="hidden"  class="item_id" value="<?=$item_infor[0]['id']?>" />
	    		</li>
                <?php
                if(!empty($item_infor['siyou'])){
                    foreach ($item_infor['siyou'] as $val) {
                ?>
                <li>
                    <span class='span'><?=$val['aname']?></span>
                    <input type="text" style="width:400px;" class="input" readonly value="<?=$val['vname']?>">
                </li>
                <?php    
                    }
                }
                ?>
	    		<li style="height:auto;width:96%;">
                    <span class='span'><?=Yii::t('yii','item manager');?></span>
                    <div class="span mouseover" style=" width:400px;height:100px;overflow:auto;border:1px solid #A7B5BC">
                    <?php 
                        foreach ($item_infor as $val) {
                            if(isset($val['aname'])&&$val['aname']=="项目管理者"){
                    ?>
                        <div><?=$val['user_name']?></div>
                    <?php
                        }
                    }
                   ?>
                    </div>
				</li>
				<li style="height:auto;width:96%;margin-top:20px;">
                    <span class='span'><?=Yii::t('yii','client of item');?></span>
                    <div class="span mouseover" style=" width:400px;height:100px;overflow:auto;border:1px solid #A7B5BC">
                    <?php 
                        foreach ($item_infor as $val) {
                            if(isset($val['aname'])&&$val['aname']=="项目所属客户"){
                    ?>
                        <div><?=$val['user_name']?></div>
                    <?php
                        }
                    }
                   ?>
                    </div>
				</li>
				<li style="height:auto;width:96%;margin-top:20px;">
                    <span class='span'><?=Yii::t('yii','item required');?></span>
                    <div class="span mouseover" style=" width:400px;height:100px;overflow:auto;border:1px solid #A7B5BC">
                    <?php 
                        foreach ($item_infor['device'] as $val) {
                    ?>
                        <div><?=$val['name']?></div>
                    <?php 
                    }
                    ?>
                    </div>
				</li>
                <li style="clear:both">
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea name="remarks[]" style="border:solid 1px #a7b5bc;resize:none;width:390px;height:100px;float:left;padding-left:10px;font-size:10pt;" readonly><?php if(isset($item_infor['item_remarks'])){echo $item_infor['item_remarks'][0]['iname'];}?></textarea>
                </li>
                <li style="margin-top:90px;width:160px;display:<?php if(!$power_have[3]){echo 'none';}?>" class='insert_here'>
                    <input type="submit" value="<?=Yii::t('yii','update information');?>" style="margin-left:100px;margin-right:50px;" class="dev_look_btn">
                </li>
	    	</ul>
	    </div>
	</div>
</body>
</html>