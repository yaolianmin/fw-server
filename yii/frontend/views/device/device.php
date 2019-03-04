<?php
use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/device.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<link href="css/mask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
	<script type="text/javascript" src='./js/device.js'></script>
</head>
<body>
	<!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
    	<div style="font-size:14px;margin-left:20px;margin-top:60px;"><?=Yii::t('yii','Delete the machine, the file will also be deleted, confirm the deletion ?');?></div>
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
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','basic content');?></a></li>
	        </ul>
	    </div>
	   <!--  按钮搜索区 -->
	   	<div class= 'device-tool' >
	    	<ul class="device-left" >
	    		<li class="first" style="margin-left:10px;display:<?php if(!$power[1]){echo 'none';}?>">
	    			<a href="./index.php?r=device/device_add" ondragstart="return false">
	    				<img src="./images/add1.png" alt=""  style="margin-top:6px;float:left" />
	    				<span style='float:left;margin-top:8px;margin-left:4px;'><?=Yii::t('yii','add device');?></span>
	    			</a>
	    		</li>
	    		<li class="first" <?php if(!$power[0]){echo "style='margin-left:10px;'";}?>>
	    			<a href="./index.php?r=device/common_dev" style="width:130px;" ondragstart="return false">
	    				<img src="./images/add1.png" alt=""  style="margin-top:6px;float:left" />
	    				<span style='float:left;margin-top:8px;margin-left:2px;overflow:hidden;width:94px;'><?=Yii::t('yii','common device');?></span>
	    			</a>
	    		</li>
	    		<li class="first" <?php if(!$power[1]){echo "style='display:none;'";}?>>
	    			<a href="./index.php?r=device/dev_property" ondragstart="return false">
	    				<img src="./images/add1.png" alt=""  style="margin-top:6px;float:left" />
	    				<span style='float:left;margin-top:8px;margin-left:0px;width:98px;'><?=Yii::t('yii','attribute (values)');?></span>
	    			</a>
	    		</li>
	    		<li class="first" <?php if(!$power[4]){echo "style='display:none;'";}?>>
	    			<a href="./index.php?r=device/dev_files" ondragstart="return false">
	    				<img src="./images/add1.png" alt=""  style="margin-top:6px;float:left" />
	    				<span style='float:left;margin-top:8px;margin-left:2px;'><?=Yii::t('yii','file');?></span>
	    			</a>
	    		</li>
	    		<li id="device-delete" style="margin-left:6px;display:<?php if(!$power[1]){echo 'none';}?>">
	    				<img src="./images/delete1.png" alt=""  style="margin-top:6px;float:left;width: 24px;"/>
	    				<span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','batch deleting');?></span>
	    		</li>
	    	</ul>
	    	<ul class="device-right"  style="width:400px;">
	    	    <form action="" method="get">
	    		<li>
	    			<span><?=Yii::t('yii','input device name');?></span>
	    			<input type="text"  class="search"  name="dev_name" value="<?php if($search_dev){echo $search_dev;}?>" />
	    		</li>
	    		<li>
	    			<input type="submit"  value="<?=Yii::t('yii','search');?>"  class="sou" />
	    		</li>
	    		<input type="hidden" name="r" value="device/device">
	    		</form>
	    	</ul>
	   	</div>
	    <!-- 机种表格区 -->
	    <table style="border:solid 1px #cbcbcb;width:99%;margin-left:10px;margin-top:10px;border-collapse:collapse;border-spacing:0;" class="tablest">
	    	<tr>
	    		<th style="margin-left:10px;" >
	    			<input type="checkbox" class="both-delete" />
	    		</th>
	    		<th><?=Yii::t('yii','order');?></th>
	    		<th><?=Yii::t('yii','device name');?></th>
	    		<th><?=Yii::t('yii','card type');?></th>
	    		<th><?=Yii::t('yii','device type');?></th>
	    		<th><?=Yii::t('yii','application scene');?></th>
	    		<th style="width:420px;"><?=Yii::t('yii','brand');?></th>
	    		<th <?php if(!$power[1]){echo "style='display:none;'";}?>><?=Yii::t('yii','edit');?></th>
	    		<th><a href="#"><?=Yii::t('yii','details');?></a></th>
	    	</tr>
	    	<?php
	    	$i=10*($page->getPage())+1;
	    	foreach ($dev as $val) { 
	    	?>
			<tr>
	    		<td style="margin-left:10px;">
	    			<input type="checkbox" class="choice" value="<?=$val['id']?>"  />
	    		</td>
	    		<td><?=$i?></td>
	    		<td><?=$val['device']?></td>
	    		<td><?=$val['card_type']?></td>
	    		<td><?=$val['dev_type']?></td>
	    		<td><?=$val['sence']?></td>
	    		<td title="<?=$val['attribute']?>"><?php if(strlen($val['attribute'])>60){echo mb_substr($val['attribute'],0,59).'...';}else{echo $val['attribute'];}?></td>
	    		<td <?php if(!$power[1]){echo "style='display:none;'";}?>>
	    			<a href="./index.php?r=device/dev_update&dev_id=<?=$val['id']?>"><?=Yii::t('yii','update');?></a>
	    		</td>
	    		<td title="<?=Yii::t('yii','click');?><?=Yii::t('yii','look');?><?=Yii::t('yii','details');?>">
	    			<a href="./index.php?r=device/dev_look&dev_id=<?=$val['id']?>">...</a>
	    		</td>
	    	</tr>  
	    	<?php
	    	$i++;	
	    	}
	    	?>	
	    </table>
	    <footer class='pages'>
	    	<div style="font-style:normal;margin-left:12px; margin-top:6px;">
	    		<?=Yii::t('yii','total have');?>&nbsp;<i><?=$page->totalCount?></i>&nbsp;<?=Yii::t('yii','strip');?> <?=Yii::t('yii','record');?> <?=Yii::t('yii','current display');?><?=Yii::t('yii','No.');?>&nbsp;<i><?= $page->getPage()+1;?></i>&nbsp;<?=Yii::t('yii','page');?>
	    	</div>
	    	<div style="float:right;margin-top:-16px;">
	    		<?= LinkPager::widget(['pagination' => $page, 'maxButtonCount' =>5]);?>
	    	</div>
	    </footer>
	</div>
</body>
</html>