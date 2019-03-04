<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/device_add.css" rel="stylesheet" type="text/css" />
	<link href="css/position.css" rel="stylesheet" type="text/css" />
	<link href="css/mask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#"><?=Yii::t('yii','add device');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href=""><?=Yii::t('yii','add device');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 表单信息栏 -->
	    <form class="dev_add_form">
	    	<ul class="insert_parent">
	    		<li>
					<span class='span'><?=Yii::t('yii','device name');?><i style='color:#ea2020;'>*</i></span>
					<input type="text" style="width:220px;outline:none;float:left;" class="input dev_name" placeholder='' required name="dev_name" value="">
					<span style="float：right;margin-left: 10px;color: #ccc;"><?=Yii::t('yii','within 32 characters');?></span>
	    		</li>
				<?php
					foreach ($arrtibute as $key => $val){
				?>
				<li style="clear:both;margin-top:20px;">
					<span class='span'><?=$val['attribute']?></span>
					<div class="dev_add_jibie equitment">
					    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose')?></span>
						<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='dev_add_dec_jibie' class='equit attributes' required >
					    <option value="<?=Yii::t('yii','please choose');?>"><?=Yii::t('yii','please choose');?></option>
						<?php
						    $length = count($val)-1;
							for($i=0;$i<$length;$i++){
						?>
							<option value="<?=$val[$i]?>" ><?=$val[$i]?></option>
						<?php
						}
						?>
					</select>
				</li>
				<?php		
				}
				?>
				<li style="clear:both;margin-top:10px;" class="add_siyou_all">
					<input type="text" class="input add_siyou" placeholder="<?=Yii::t('yii','add attribute');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width:90px;text-indent:0px;" />
					<input type="text" class="input add_siyou_val" placeholder="<?=Yii::t('yii','add attribute values');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width: 220px;padding: -4px;" />
					<img src="./images/add1.png" class="add_siyou_btn" style="width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left: 8px;">
					<span style="float：right;margin-left: 10px;color: #ccc;"><?=Yii::t('yii','The private property and attribute value of the device can not be filled in')?></span>
				</li>
				<li style="clear: both;"></li>
				<li style="clear:both;position: relative;margin-top: -14px;">
					<span class='span'><?=Yii::t('yii','brand');?></span>
					<div class="span mouseover" style=" width:462px;height:100px;overflow:auto;border:1px solid #A7B5BC">
				    </div>
					<div class="box"></div>
					<div class="content_device" style="overflow:auto;">
						<?php
                        foreach ($pinpai_val as $val) {
                        ?>
							<div title="<?=Yii::t('yii','Click and add')?>" style="margin-left: 10px;"><?=$val['vname']?></div>
                        <?php
                        }
						?>    	
					 </div>
				</li>
				<img src="./images/add1.png" style="border-radius: 50%;z-index: 222;" class="add-devs">
	    		<li style="clear: both;margin-top: 70px;">
	    		<span class='span'><?=Yii::t('yii','remark');?></span>
	    			<textarea id="textarea_"></textarea>
	    		</li>
	    		<li style="clear:both;margin-top:16px;float:left;" class="add_here">
                    <input type="button" value="<?=Yii::t('yii','confirm');?>" class="dev_add_btn add_dev_btn" onclick='check()'>
                    <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn">
                </li>
	    	</ul>
	    </form>
	    <div class="reurn_infor"></div>
	</div>
</body>
<script type="text/javascript">
	$(function(){
		//设备类型的下拉框
		$('.equit').change(function(){
			var pin_val = $(this).val();
			var spans = $(this).prev().children('span');
			spans.html(pin_val);
		})

        $('.add-devs').click(function(){
        	$('.box').css('display','block');
        	$('.content_device').css('display','block');
        })
        $('.add-devs').mouseover(function(){
        	$('.mouseover').css('background-color','#fff');
        })

        $('.content_device').mouseleave(function(){
        	$('.box').css('display','none');
        	$('.content_device').css('display','none');
        })

        $(document).on('mouseover','.dev_brand',function(){
        	$(this).find('input').css('background-color','#E5EBEE');
        	$(this).find('img').css('display','block');
        })

        $(document).on('mouseleave','.dev_brand',function(){
        	$(this).find('input').css('background-color','#fff');
        	 $(this).find('img').css('display','none');
        })

        // 添加私有属性
        $('.add_siyou_btn').click(function(){
        	var siyou = $(this).parent('.add_siyou_all').find('.add_siyou').val();
 			var siyou_val = $(this).parent('.add_siyou_all').find('.add_siyou_val').val();
           
 			if((siyou)&& (siyou_val)){
 				$('.add_siyou_all').before("<li style='clear:both;margin-top:10px;' class='add_siyou_alls'><input type='text' class='input add_si' value='"+siyou+"' style='border: none;width:96px;text-indent:0px;' readonly/><input type='text' class='input add_siyou_vals' value='"+siyou_val+"' style='border:solid 1px #a7b5bc;width: 220px' readonly/><img src='./images/delete1.png' class='siyou_delete_btn' style='width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left:6px;'></li>");
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
        	var nums = $('.mouseover input').length;
	            var aa = 0;
	            for(var i=0;i<nums;i++){
	                if($('.mouseover input').eq(i).val()== val){
	                    aa=1;
	                }
	            }
	            if(!aa){
	                $('.mouseover').append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi' name='brand[]' readonly/><img src='./images/delete1.png'class='delete_attr'></div>")
	            } 
        })
        $(document).on('click','.delete_attr',function(){
        	$(this).parent('.dev_brand').remove();
        })
    
	});
    //提交表单
	function check(){
		var dev_name = $('.dev_name').val();
		if(!dev_name){
			$('.reurn_infor').css('display','block');
			$('.reurn_infor').html("<?=Yii::t('yii','The name of the device can not be empty')?>");
			return false;
		}

		var att_len = $('.attributes').length;  
		if(att_len < 3){
			$('.reurn_infor').css('display','block');
			$('.reurn_infor').html("<?=Yii::t('yii','Attribute value can not be empty')?>");
			return false;
		}
		var att_brand = $('.pinpaizhi').length;
		if( att_brand < 1 ){
			$('.reurn_infor').css('display','block');
			$('.reurn_infor').html("<?=Yii::t('yii','Brand value can not be empty')?>");
			return false;
		}
		var attribute = new Array();
		for(var k=0;k<3;k++){
			if( $('.attributes').eq(k).val() == '请选择'){
				$('.reurn_infor').css('display','block');
				$('.reurn_infor').html("<?=Yii::t('yii','Attribute value can not be empty')?>");
				return false;
			}
		}
		for(var s=0;s<att_len;s++){
			attribute[s] = $('.attributes').eq(s).val();
		}                                                                        
		for(var j=0;j<att_brand;j++){
			attribute[att_len+j] = $('.pinpaizhi').eq(j).val();
		}                                                                                                                        
		var len = $('.add_si').length;
		if(len > 0 ){
			var arr_siyou = new Array();
			var arr_siyou_val = new Array();
			for(var i =0;i<len;i++){
				arr_siyou[i]=$('.add_si').eq(i).val();
				arr_siyou_val[i]=$('.add_siyou_vals').eq(i).val();
			} 
		}
		var dev_remarks = $('#textarea_').val();
		if(arr_siyou){
            var date = {
            	'dev_name':dev_name,
            	'attribute':attribute,
            	'arr_siyou':arr_siyou,
            	'arr_siyou_val':arr_siyou_val,
            	'dev_remarks':dev_remarks
            }
		}else{
			var date = {
            	'dev_name':dev_name,
            	'attribute':attribute,
            	'dev_remarks':dev_remarks
            }
		}
		 $.ajax({
            url:'./index.php?r=device/device_add',
            type:'get',
            data:{'ajax_add_dev':date},
            dataType:'json',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
               if(msg){
               		$('.reurn_infor').css('display','block');
					$('.reurn_infor').html(msg);
					return false;
               }else{
               	window.location.href = './index.php?r=device/device';
               }
            }
        })                                                                                      
	}
</script>
</html>