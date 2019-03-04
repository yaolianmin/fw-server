<?php
use yii\widgets\LinkPager;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/device.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
    #date{margin-left: 30px;width:320px;background-color:#fff;border:none;background:none;}
    #date input{border-top: solid 1px #a7b5bc;border-left: solid 1px #a7b5bc;border-right: solid 1px #ced9df;border-bottom: solid 1px #ced9df;margin-top: 4px;height:26px;}
	</style>
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
	<script type="text/javascript">
	$(function(){
		//起始时间
		$('.time_begin').change(function(){
			var time_begin = $(this).val();
			var time_end = $('.time_end').val();
			window.location.href = './index.php?r=log/log&time_begin='+time_begin+"&time_end="+time_end;
		})
		//截止时间
		$('.time_end').change(function(){
			var  time_end= $(this).val();
			var  time_begin= $('.time_begin').val();
			window.location.href = './index.php?r=log/log&time_begin='+time_begin+"&time_end="+time_end;
		})

		//下载功能
		$('.export').click(function(){
			var search = $('.search').val(); //搜索条件
			var page = $('.active a').html()                 //当前的页码
			var time_begin = $('.time_begin').val();                      //当前的起止时间
			var time_end  =  $('.time_end').val() ;                          //当前的结束时间
			window.location.href = './index.php?r=log/log&export=export&search_user_name='+search+'&page='+page+'&time_begin='+time_begin+'&time_end='+time_end;
		})
		$('.active a').removeAttr("href");
	})
	</script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=log/log"><?=Yii::t('yii','log management');?>></a></li>
	            <li><a href="#"><?=Yii::t('yii','basic content');?></a></li>
	        </ul>
	    </div>
	     <!--  按钮搜索区 -->
        <div class= 'device-tool'>
            <ul class="device-left">
                <li class="first" style="margin-left:10px;display:<?php if(!$power_have[11]){echo 'none';}?>">
                    <a href="./index.php?r=log/log_set">
                        <img src="./images/add1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;" />
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','log set');?></span>
                    </a>
                </li>
                <li class="first" style="display:<?php if(!$power_have[10]){echo 'none';}?>">
                    <a href="#" class="export">
                        <img src="./images/dow1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;" />
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','download log');?></span>
                    </a>
                </li>
                <li style="" id="date">
                	<input type="date"style='width:140px;' value="<?php if($time_be){echo $time_be;}else{echo date('Y-m-d',time()-604800);}?>" class='time_begin'/>
                	<span style='margin-left:5px;margin-right:5px;'><?=Yii::t('yii','to');?></span>
                	<input type="date" style='width:140px;' value="<?php if($time_en){echo $time_en;}else{echo date('Y-m-d',time());}?>" class='time_end' />
                </li>
            </ul>
            <ul class="device-right" >
                <form action="" method="get">
                <li>
                    <span><?=Yii::t('yii','input user name');?></span>
                    <input type="text"  class="search"  name="search_user_name" value="<?php if($search_name){echo $search_name;}?>" />
                </li>
                <li>
                    <input type="submit"  value="<?=Yii::t('yii','search');?>"  class="sou" />
                </li>
                <input type="hidden" name="r" value="log/log">
                </form>
            </ul>
        </div>
       <!--表格区域-->
         <table style="border:solid 1px #cbcbcb;width:99%;margin-left:10px;margin-top:10px;;border-collapse:collapse;border-spacing:0;" class="tablest">
	    	<tr>
	    		<th style="margin-left:10px; width:60px; " >
	    			<input type="checkbox" class="both-delete" />
	    		</th>
	    		<th style="min-width:90px;"><?=Yii::t('yii','order');?></th>
	    		<th style="min-width:100px;"><?=Yii::t('yii','user name');?></th>
	    		<th style="min-width:100px;"><?=Yii::t('yii','log level');?></th>
	    		<th style="min-width:100px;"><?=Yii::t('yii','log type');?></th>
	    		<th style="min-width:140px;"><?=Yii::t('yii','time');?></th>
	    		<th style="min-width:120px;">IP</th>
	    		<th style='min-width:450px;'><?=Yii::t('yii','information');?></th>
	    	</tr>
	    	<?php
	    	$i=10*($page->getPage())+1;
	    	foreach ($log_infor as $val) {
	    	?>
			<tr>
	    		<td style="margin-left:10px;">
	    			<input type="checkbox" class="choice" value=""  />
	    		</td>
	    		<td><?=$i?></td>
	    		<td><?= $val['user_name']?></td>
	    		<td><?= Yii::t('yii',$val['log_level'])?></td>
	    		<td><?= Yii::t('yii',$val['log_type'])?></td>
	    		<td><?= date('Y-m-d H:i:s',$val['log_time'])?></td>
	    		<td><?=$val['login_ip']?></td>
	    		<td title="<?= Yii::t('yii',$val['action_info']).' '.Yii::t('yii',$val['info']).' '.Yii::t('yii',$val['item_info'])?>" ><?php if(mb_strlen($val['action_info'].' '.$val['info'].' '.$val['item_info'],'utf-8')>65){echo mb_substr(Yii::t('yii',$val['action_info']).' '.$val['info'].' '.Yii::t('yii',$val['item_info']),0,65,"UTF-8").'...';}else{echo Yii::t('yii',$val['action_info']).' '.Yii::t('yii',$val['info']).' '.Yii::t('yii',$val['item_info']);}?></td>
	    	</tr>
	    	<?php
	    	$i++;	
	    	}
	    	?>
	    </table>
	    <!--分页-->
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