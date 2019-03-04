<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link rel="stylesheet" type="text/css" href="css/item_update.css">
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript" src='./js/item_update.js'></script>
</head>
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
        <div style="font-size:14px;margin-left:86px;margin-top:60px;">are you sure delete this attribute ?</div>
        <div>
            <input type="submit" value="<?=Yii::t('yii','confirm');?>" class="user_shadow_sure" />
            <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_shadow_quxiao" />
        </div>
    </div>
    <!-- 遮罩层结束 -->
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','item management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','item');?> <?=Yii::t('yii','details');?></a></li>
	        </ul>
	    </div>
	    <!-- 机种详情 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','item');?> <?=Yii::t('yii','details');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息栏 -->
	    <form class="dev_add_form">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','item name');?></span>
					<input type="text" style="width:300px;float:left;" class="input dev_name" value="<?=$item_infor[0]['item_name']?>" required>
                    <input type="hidden" value='<?=$item_infor[0]['id']?>' class='item_id'/>
                    <span style='color:#ccc;margin-left:20px;'>40个字符以内</span>
	    		</li>
                <?php
                if(!empty($item_infor['siyou'])){
                    foreach ($item_infor['siyou'] as $val) {
                ?>
                <li>
                    <span class='span'><?=$val['aname']?></span>
                    <input type="text" style="width:300px;float:left;" class="input"  value="<?=$val['vname']?>" readonly>
                    <span style='float:left;margin-top:5px;margin-left:6px;' class='add_siyous'>
                        <img src="./images/delete1.png" class="delete_siyou_btn" style="border-radius: 50%;">
                    </span>
                    <input type="hidden" value="<?=$val['id']?>" name='siyou_id[]' class='siyou_id'/>
                </li>
                <?php    
                    }
                }
                ?>
                <li style="clear:both;margin-top:10px;" class="add_siyou_all">
                    <input type="text" class="input add_siyou" placeholder="<?=Yii::t('yii','add attribute');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width:90px;text-indent:0px;" />
                    <input type="text" class="input add_siyou_val" placeholder="<?=Yii::t('yii','add attribute values');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width: 300px;padding: -4px;" />
                    <img src="./images/add1.png" class="add_siyou_btn" style="width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left: 8px;">
                    <span style="float：right;margin-left: 10px;color: #ccc;">该项目的私有属性、属性值，可不填</span>
                </li>
	    		<li style="height:auto;width:100%;margin-top:30px; position: relative;">
                    <span class='span'><?=Yii::t('yii','item manager');?></span>
                    <div class="span mouseover managers" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                    <input type="hidden" value="1" class="flag_">
                    <?php 
                        foreach ($item_infor as $val) {
                            if(isset($val['aname'])&&$val['aname']=="项目管理者"){
                    ?>
                        <div class='dev_brand'>
                            <input type='text' value='<?=$val['user_name']?>' class='pinpaizhi user_manage'  readonly/>
                            <img src='./images/delete1.png'class='delete_attr'>
                        </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                    <div class="box"></div>
                    <div class="content_device" style="overflow:auto;">
                        <?php
                        foreach ($fae as $val) {
                        ?>
                        <div title="点击添加" style="margin-left: 10px;"><?=$val['user_name']?></div>       
                        <?php
                        }
                        ?>
                    </div>
				</li>
                <img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add-devs">
				<li style="height:auto;width:100%;margin-top:00px;position: relative;">
                    <span class='span'><?=Yii::t('yii','client of item');?></span>
                    <div class="span mouseover suoshu_users" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                    <input type="hidden" value="2" class="flag_">
                    <?php 
                        foreach ($item_infor as $val) {
                            if(isset($val['aname'])&&$val['aname']=="项目所属客户"){
                    ?>  
                        <div class='dev_brand'>
                            <input type='text' value='<?=$val['user_name']?>' class='pinpaizhi user_client'  readonly/>
                            <img src='./images/delete1.png'class='delete_attr'>
                        </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                    <div class="box"></div>
                    <div class="content_device" style="overflow:auto;">
                        <?php
                        foreach ($user as $val) {
                        ?>
                        <div title="点击添加" style="margin-left: 10px;"><?=$val['user_name']?></div>       
                        <?php
                        }
                        ?>
                    </div>
				</li>
                <img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add_devs1">
				<li style="height:auto;width:100%;margin-top:20px;position: relative;">
                    <span class='span'><?=Yii::t('yii','item required');?></span>
                    <div class="span mouseover suoxu_devices" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                     <input type="hidden" value="3" class="flag_">
                    <?php 
                        foreach ($item_infor['device'] as $val) {
                    ?>
                       <div class='dev_brand'>
                            <input type='text' value='<?=$val['name']?>' class='pinpaizhi user_device'  readonly/>
                            <img src='./images/delete1.png'class='delete_attr'>
                        </div>
                    <?php 
                    }
                    ?>
                    </div>
                    <div class="box"></div>
                    <div class="content_device" style="overflow:auto;">
                        <?php
                        foreach ($device as $val) {
                        ?>
                        <div title="点击添加" style="margin-left: 10px;"><?=$val['name']?></div>       
                        <?php
                        }
                        ?>
                    </div>
				</li>
                <img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add_devs2">
                <li style="clear:both">
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea  class="remark" style="border:solid 1px #a7b5bc;resize:none;width:390px;height:100px;float:left;padding-left:10px;font-size:10pt;" ><?php if(isset($item_infor['item_remarks'][0]['iname'])){echo $item_infor['item_remarks'][0]['iname'];}?></textarea>
                </li>
                <li style="clear:both;margin-top:100px;" class="add_heres">
                    <input type="button" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="dev_add_btn" onclick="check()">
                    <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn">
                </li>
            </ul>
        </form>
	</div>
    <div style="color: red;margin-left: 200px;" class="tips"></div>
</body>
</html>
