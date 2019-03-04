<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/item_add.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
 <script type="text/javascript" src='./js/exit.js'></script>
 <script type="text/javascript">
 $(function(){
        $('.add-devs').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(0).css('display','block');
            $('.content_device').eq(0).css('display','block');
        })
        $('.add-devs').mouseover(function(){
            $('.mouseover').css('background-color','#fff');
        })
        $('.content_device').mouseleave(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
        })


        $('.add_devs2').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(1).css('display','block');
            $('.content_device').eq(1).css('display','block');
        })
        $('.add_devs2').mouseover(function(){
            $('.mouseover').css('background-color','#fff');
        })
        $('.add_devs3').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(2).css('display','block');
            $('.content_device').eq(2).css('display','block');
        })
        $('.add_devs3').mouseover(function(){
            $('.mouseover').css('background-color','#fff');
        })

        // 添加私有属性
        $('.add_siyou_btn').click(function(){
            var siyou = $(this).parent('.add_siyou_all').find('.add_siyou').val();
            var siyou_val = $(this).parent('.add_siyou_all').find('.add_siyou_val').val();
           
            if((siyou)&& (siyou_val)){
                $('.add_siyou_all').before("<li style='clear:both;margin-top:10px;' class='add_siyou_alls'><input type='text' class='input add_si' value='"+siyou+"' style='border: none;width:96px;text-indent:0px;' readonly/><input type='text' class='input add_siyou_vals' value='"+siyou_val+"' style='border:solid 1px #a7b5bc;width: 300px' readonly/><img src='./images/delete1.png' class='siyou_delete_btn' style='width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left:6px;'></li>");
                $(this).parent('.add_siyou_all').find('.add_siyou').val('');
                $(this).parent('.add_siyou_all').find('.add_siyou_val').val('');
            }else{
                alert('please add relevant information first');
            }
        })
        
        // 删除私有属性 属性值
        $(document).on('click','.siyou_delete_btn',function(){
            $(this).parent('.add_siyou_alls').remove();
        })

        $('.content_device div').click(function(){
            var val = $(this).html();
            var prevs = $(this).parent().prev().prev();
            var flags = prevs.find('.flag_').val();
            var flag = '';
            if(flags == 1){
                flag = 'user_manage';
            }else if(flags == 2){
                flag = 'user_client';
            }else if(flags == 3){
                flag = 'user_device';
            }
            var nums = prevs.find('.dev_brand').length;
                var aa = 0;
                for(var i=0;i<nums;i++){
                    if(prevs.find('.pinpaizhi').eq(i).val()== val){
                        aa=1;
                    }
                }
                if(!aa){
                    prevs.append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi "+flag+"' name='brand[]' readonly/><img src='./images/delete1.png'class='delete_attr'></div>")
                } 
        })
        $(document).on('click','.delete_attr',function(){
            $(this).parent('.dev_brand').remove();
        })

        $(document).on('mouseover','.dev_brand',function(){
            $(this).find('input').css('background-color','#E5EBEE');
             $(this).css('background-color','#E5EBEE');
            $(this).find('img').css('display','inline-block');
        })

        $(document).on('mouseleave','.dev_brand',function(){
            $(this).css('background-color','#fff');
            $(this).find('input').css('background-color','#fff');
            $(this).find('img').css('display','none');
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
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"> <a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=item/item" ondragstart="return false"><?=Yii::t('yii','item management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','add item');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add item');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息栏 -->
	    <form class="dev_add_form">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','item name');?><i style='color:#ea2020;'>*</i></span>
					<input type="text" style="width:300px;outline:none;float:left;" class="input item_name" placeholder='<?=Yii::t('yii','input item name');?>'>
					<div style="float:left;margin-left:20px;color:#ccc"><?=Yii::t('yii','within 40 characters')?></div>
	    		</li>
                <li style="clear:both;margin-top:10px;" class="add_siyou_all">
                    <input type="text" class="input add_siyou" placeholder="<?=Yii::t('yii','add attribute');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width:90px;text-indent:0px;" />
                    <input type="text" class="input add_siyou_val" placeholder="<?=Yii::t('yii','add attribute values');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width: 300px;padding: -4px;" />
                    <img src="./images/add1.png" class="add_siyou_btn" style="width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left: 8px;">
                    <span style="float：right;margin-left: 10px;color: #ccc;"><?=Yii::t('yii','The private property of the item is not filled')?></span>
                </li>
	    		<li style="clear:both;margin-top:30px;position: relative;">
					<span class='span'><?=Yii::t('yii','item manager');?><i style='color:#ea2020;'>*</i></span>
					<div class="span mouseover" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                        <input type="hidden" value="1" class="flag_">
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
                <li style="height: 20px;"></li>
				<li style="float: left;position: relative;">
					<span class='span'><?=Yii::t('yii','client of item');?></span>
					<div class="span mouseover" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                     <input type="hidden" value="2" class="flag_">
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
				<li style="clear:both;margin-top:5px;"></li>
                <img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add_devs2">
				<li style="position: relative;">
					<span class='span'><?=Yii::t('yii','item required');?><i style='color:#ea2020;'>*</i></span>
					<div class="span mouseover" style=" width:400px;height:90px;overflow:auto;border:1px solid #A7B5BC">
                        <input type="hidden" value="3" class="flag_">
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
                <li style="clear:both;height:0px;"></li>
                <img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add_devs3">
                <li style="clear:both;margin-top:5px;">
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea class="remark" style="border:solid 1px #a7b5bc;resize:none;width:390px;height:100px;float:left;padding-left:10px;"></textarea>
                </li>
	    		<li style="clear:both;margin-top:16px;float:left;" class="add_here">
                    <input type="button" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="dev_add_btn" onclick='check()'>
                    <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn">
                </li>
	    	</ul>
	    	<input type="hidden" name="r" value="item/item_add">
	    </form>
        <div style="clear:both;color:red;margin-left:200px;margin-top:30px;" class="tips"></div>
	</div>
</body>
<script type="text/javascript">
    // 添加按钮的操作
    function check(){
        var item_name = $('.item_name').val();
        var remark = $('.remark').val();
        var user_m_len = $('.user_manage').length;
        var user_c_len = $('.user_client').length;
        var user_d_len = $('.user_device').length;
        var add_si = $('.add_si').length;
        if(!item_name){
            $('.tips').html("<?=Yii::t('yii','The name of the item can not be empty')?>");
            return false;
        }
        if(item_name.length>40){
            $('.tips').html("<?=Yii::t('yii','The name of the item is too long')?>");
            return false;
        }
        if(!user_m_len){
            $('.tips').html("<?=Yii::t('yii','item managers can not be empty')?>");
            return false;
        }
        if(!user_d_len){
            $('.tips').html("<?=Yii::t('yii','The type of device required for the item can not be empty')?>");
            return false;
        }
        var user_manage = new Array();
        for(var j=0;j<user_m_len;j++){
            user_manage[j] = $('.user_manage').eq(j).val();
        }
        var user_device = new Array();
        for(var k=0;k<user_d_len;k++){
            user_device[k] = $('.user_device').eq(k).val();
        }
        if(user_c_len){
            var user_client = new Array();
            for(var i=0;i<user_c_len;i++){
                user_client[i] = $('.user_client').eq(i).val();
            }
        }
        if(add_si){
            var user_siyou = new Array();
            var user_siyou_val = new Array();
            for(var s=0;s<add_si;s++){
                user_siyou[s] = $('.add_si').eq(s).val();
                user_siyou_val[s] = $('.add_siyou_vals').eq(s).val();
            }
        }
        if(user_c_len){
            if(add_si){
                var date = {
                    'item_name':item_name,
                    'user_manage':user_manage,
                    'user_device':user_device,
                    'remark':remark,
                    'user_client':user_client,
                    'user_siyou':user_siyou,
                    'user_siyou_val':user_siyou_val
                } 
            }else{
                var date = {
                    'item_name':item_name,
                    'user_manage':user_manage,
                    'user_device':user_device,
                    'remark':remark,
                    'user_client':user_client
                } 
            }
        }else{
            if(add_si){
                var date = {
                    'item_name':item_name,
                    'user_manage':user_manage,
                    'user_device':user_device,
                    'remark':remark,
                    'user_siyou':user_siyou,
                    'user_siyou_val':user_siyou_val
                } 
            }else{
                var date = {
                    'item_name':item_name,
                    'user_manage':user_manage,
                    'user_device':user_device,
                    'remark':remark
                } 
            }
        }
        $.ajax({
            url:'./index.php?r=item/item_add',
            type:'get',
            data:{'ajax_add_item':date},
            dataType:'json',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
               if(msg != 'success'){
                    $('.tips').css('display','block');
                    $('.tips').html(msg);
                    return false;
               }else{
                window.location.href = './index.php?r=item/item';
               }
            }
        })   
    }
</script>
</html>