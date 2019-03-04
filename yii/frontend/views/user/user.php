<?php
use yii\widgets\LinkPager;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/user.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<link href="css/mask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
	<script type="text/javascript" src='./js/user.js'></script>
	<style>
    .pages .pagination li{width: 30px;height: 28px;float: left;text-align: center;border: 1px solid #DDDDDD;line-height: 28px;}
    .pages .pagination li a{width: 30px;height: 28px;display: block;color: #3399D5;}
    .active{background-color: #D4E7F0 !important;}
    img{margin-top:6px;float:left;border-radius: 50%;width: 24px;}
	</style>
	<script type="text/javascript">
	
	$(function(){
		$('.active a').removeAttr("href");
	})
	</script>
</head>
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
    	<div style="font-size:14px;margin-left:90px;margin-top:60px;">Are you sure delete these options ?</div>
    	<div>
    		<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="user_shadow_sure" />
    		<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_shadow_quxiao" />
    	</div>
    </div>
    <!-- 遮罩层结束 -->
    <div style="min-width:1080px;font-size:9pt;overflow:hidden;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=user/user" ondragstart="return false"><?=Yii::t('yii','user management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','basic content');?></a></li>
	        </ul>
	    </div>
	   <!--  按钮搜索区 -->
	    <div class="main-tool">
	    	<ul class="main-left">
	    		<li class="first" style="display:<?php if($power_have[7] == '0'){echo 'none';}?>;width:120px;" >
	    			<a href="./index.php?r=user/user_add" ondragstart="return false">
	    				<img src="./images/add1.png" alt=""/>
	    				<span style='float:left;margin-top:10px;margin-left:6px;'><?=Yii::t('yii','add user');?></span>
	    			</a>
	    		</li>
	    		<li id="user-delete" style="display:<?php if($power_have[8]=='0'){echo 'none';}?>;width:120px;">
	    				<img src="./images/delete1.png" alt=""/>
	    				<span style='float:left;margin-top:10px;margin-left:6px;'><?=Yii::t('yii','batch deleting');?></span>
	    		</li>
	    	</ul>
	    	<!-- 搜索框 -->
	    	<ul class="main-right" >
	    		<form action="" method="get">
	    		<input type="hidden" name="r" value="user/user"/>
		    		<li style="margin-left:20px;">
		    			<span><?=Yii::t('yii','input user name');?></span>
		    			<input type="text"  class="search" name="search_name" value="<?=$search_name?>" />
					</li>
					<li>
		    			<input type="submit"  value="<?=Yii::t('yii','search');?>"  class="sou" />
		    		</li>
	    		</form>
	    	</ul>
	    </div>
	    <!-- 表单内容区 -->
	    <table style="border:solid 1px #cbcbcb;width:99%;margin-left:10px;margin-top:10px;;border-collapse:collapse;border-spacing:0;" class="tablest">
	    	<tr>
	    		<th style="margin-left:10px;width: 60px;" >
	    			<input type="checkbox" class="both-delete" />
	    		</th>
	    		<th style="width:100px;"><?=Yii::t('yii','order');?></th>
	    		<th style="width:220px;"><?=Yii::t('yii','user name');?></th>
	    		<th><?=Yii::t('yii','level');?></th>
	    		<th style="width:500px;"><?=Yii::t('yii','device');?></th>
	    		<th style="display:<?php if($power_have[8]=='0'){echo 'none';}?>"><?=Yii::t('yii','edit');?></th>
	    		<th><?=Yii::t('yii','details');?></th>
	    	</tr>
	    	<?php
	    	    $i=10*($page->getPage());
	    		foreach ($user_dev  as $val) {
	        ?>
				<tr>
		    		<td style="margin-left:10px;">
		    			<input type="checkbox" class="choice" value="<?=$val['id']?>" />
		    		</td>
		    		<td><?=++$i?></td>
		    		<td><?=$val['user_name']?></td>
		    		<td><?php if($val['power']=='15'){echo  Yii::t('yii','superadministrator');}elseif($val['power']=='10'){echo"PM";}elseif($val['power']=='5'){echo"FAE";}elseif($val['power']=='1'){echo  Yii::t('yii','common user');}elseif($val['power']=='-1'){echo  Yii::t('yii','other');}?></td>
		    		<td title="<?=$val['name']?>"><?php if(strlen($val['name'])>50){echo mb_substr($val['name'],0,49).'...';}else{echo $val['name'];}?></td>
		    		<td style="display:<?php if($power_have[8]=='0'){echo 'none';}?>"><a href="./index.php?r=user/user_update&user_id=<?=$val['id']?>"><?=Yii::t('yii','update');?></a></td>
		    		<td title="<?=Yii::t('yii','click');?><?=Yii::t('yii','look');?><?=Yii::t('yii','details');?>" class="users_all_informa"><a href="./index.php?r=user/user_look&user_id=<?=$val['id']?>">...</a></td>
	    		</tr>
	        <?php	
	    	}
	    	?>
	    </table>
        <!--分页-->
	    <footer class='pages'>
	    	<div style="font-style:normal;margin-left:12px; margin-top:6px;">
	    			<?=Yii::t('yii','total have');?>&nbsp;<i><?=$page->totalCount?></i>&nbsp;<?=Yii::t('yii','strip');?> <?=Yii::t('yii','record');?> <?=Yii::t('yii','current display');?><?=Yii::t('yii','No.');?>&nbsp;<i><?= $page->getPage()+1;?></i>&nbsp;<?=Yii::t('yii','page');?>
	    	</div>
	    	<div style="float:right;margin-top:-16px;margin-right:4px;">
	    		<?= LinkPager::widget(['pagination' => $page, 'maxButtonCount' =>5]);?>
	    	</div>
	    </footer>
	</div>
</body>
</html>
