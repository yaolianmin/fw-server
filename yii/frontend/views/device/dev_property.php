<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
    <link href="css/dev_property.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
	<script type="text/javascript" src='./js/exit.js'></script>
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
	<div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
		<div class="place">
	        <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
	        <ul class="placeul">
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','attribute (values)');?></a></li>
	        </ul>
	    </div>
	    <!-- 添加 -->
	    <div class="device_infor">
	    	<ul>
	    		<li style="float:left;margin-left:-36px;" class="common_dec_add">
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add attribute');?></a>
	    		</li>
	    		<li style="float:left;" >
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','delete attribute');?></a>
	    		</li>
	    		<li style="float:left;" >
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','add attribute values');?></a>
	    		</li>
	    		<li style="float:left;width:120px;" >
	    			<a href="#" style="width:120px;" ondragstart="return false"><?=Yii::t('yii','delete');?> <?=Yii::t('yii','attribute values');?></a>
	    		</li>
	    	</ul>
	    </div>
	    <!-- 已有属性（值） -->
        <div class="dev_add_form">
        	<ul>
        		<li>
        			<span style='display:block;width:100px;'><?=Yii::t('yii','attribute (values)');?></span>
					<div class="common_add_jibie attributes">
					    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose');?></span>
						<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='common_add_dec_jibie' class="attribute">
					    <?php 
 							foreach ($attributes as $val) {
 							?>
							<option value="<?=$val['aname']?>"><?=$val['aname']?></option>
 						<?php
 							}
					    ?>	
					</select>

					<div class="common_add_jibie2 attribute_vals">
					    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose');?></span>
						<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
					</div>
					<select  id='common_add_dec_jibie2' class="attribute_val">
						<?php
							foreach ($aval as $val) {
						?>
							<option value="<?=$val['vname']?>"><?=$val['vname']?></option>
						<?php
						}
						?>
					</select>
        		</li>
        	</ul>
        </div>
        <!-- 添加属性 -->
        <div class="shuixing_add display_same" >
            <form action="" method="get" style="width:435px;">
            	<span class='span'><?=Yii::t('yii','add attribute');?></span>
        		<input type="text" placeholder='<?=Yii::t('yii','input attribute');?>' class="shuxing" name="add_attribute" required>
        		<span style="margin-left: 6px;color: #ccc;"><?=Yii::t('yii','within 14 characters');?></span>
        		<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="shuxing_btn" style='margin-left: 76px;'>
        		<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="shuxing_btn">
        		<input type="hidden" name="r" value="device/dev_property">
            </form>
        </div>
        <!-- 删除属性 -->
        <div class="shuixing_delete display_same" style="display:none;">
	        	<span style='display:block;width:100px;height:32px;line-height:62px;margin-left:54px;'><?=Yii::t('yii','delete attribute');?></span>
				<div class="common_add_jibie del_attributes">
					<span style="height:34px;border:none;margin-left:10px;line-height:34px;"><?=Yii::t('yii','please choose');?></span>
					<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
				</div>
				<select  id='common_add_dec_jibie' class="del_attribute" name="del_attribute">
					<?php 
 						foreach ($attributes as $val) {
 					?>
						<option value="<?=$val['aname']?>"><?=$val['aname']?></option>
 					<?php
 						}
					?>	
				</select>
				<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="shuxing_btn del_attribute_btn">
	        	<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="shuxing_btn1">
        </div>
        <!-- 添加属性值 -->
        <div class="shuixingzhi_add display_same" style="display:none;">
        	<div class="dev_add_form" style="margin-top:100px;">
        		<form action="" method="get">
        			<ul>
	        			<li style="width:800px;">
		        			<span style='display:block;width:100px;'><?=Yii::t('yii','add attribute values');?></span>
							<div class="common_add_jibie add_attribute_vals">
							    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please');?></span>
								<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
							</div>
							<select  id='common_add_dec_jibie' class="add_attribute_val" name="add_attribute_val">
								 <?php 
 									foreach ($attributes as $val) {
 								?>
									<option value="<?=$val['aname']?>"><?=$val['aname']?></option>
 								<?php
 								}
					    		?>	
							</select>
							<input type="text" class="input_shuxingzhi" name="add_attribute_vals">
							<input type="text" class="input_shuxingzhi" style="border: none;color:#ccc" value='<?=Yii::t('yii','within 20 characters');?>'>
		        		</li>
		        		<li>
		        		    <input type="hidden" name='r' value="device/dev_property">
		        			<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="shuxing_btn" style="margin-left:180px;">
	        				<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="shuxing_btn">
		        		</li>
        			</ul>
        		</form>
        	</div>
        </div>
        <!-- 删除属性值 -->
        <div class="shuixingzhi_delete display_same" style="display:none;">
        	<div class="dev_add_form" style="margin-top:100px;">
        			<ul>
	        			<li>
		        			<span style='display:block;width:100px;'><?=Yii::t('yii','delete');?> <?=Yii::t('yii','attribute values');?></span>
							<div class="common_add_jibie del_attribute_s">
							    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose');?></span>
								<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
							</div>
							<select  id='common_add_dec_jibie' class="del_attribute_" name="del_attribute_val">
								<?php 
 									foreach ($attributes as $val) {
 								?>
									<option value="<?=$val['aname']?>"><?=$val['aname']?></option>
 								<?php
 								}
								?>	
							</select>
							<div class="common_add_jibie2 del_attribute_vals">
							    <span style="height:34px;border:none;margin-left:10px;"><?=Yii::t('yii','please choose');?></span>
								<img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
							</div>
							<select  id='common_add_dec_jibie2' class="del_attribute_val" name='del_attribute_vals'>
								<?php
									foreach ($aval as $val) {
								?>
									<option value="<?=$val['vname']?>"><?=$val['vname']?></option>
								<?php
								}
							?>
							</select>
		        		</li>
		        		<li>
		        			<input type="submit" value="<?=Yii::t('yii','confirm');?>" class="shuxing_btn del_attribute_vals_btn" style="margin-left:180px;">
	        				<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="shuxing_btn ">
		        		</li>
        			</ul>
        	</div>
        </div>
        <div style="color:red;margin-top:100px;margin-left:40%;display:<?php if(isset($infor)){echo 'block';}else{echo 'none';}?>" class='tip_infor'><?php if(isset($infor)){echo $infor;}?></div>
	</div>
</body>
<script type="text/javascript">
	$(function(){
		//添加 删除Class的切换
		$('.device_infor ul li').click(function(){
			// //获取当前的位置
			var common_index = $(this).index();
            //切换按钮的样式
			$('.device_infor ul li').removeClass('common_dec_add');
			$(this).addClass('common_dec_add');
			//显示对应的提交模块
			if(common_index == 0){  //添加属性模块显示

				$('.display_same').css('display','none');
				$('.shuixing_add').css('display','block');

			}else if(common_index == 1){ //删除属性模块显示

				$('.display_same').css('display','none');
				$('.shuixing_delete').css('display','block');

			}else if(common_index == 2){ //添加数字能够值模块显示

				$('.display_same').css('display','none');
				$('.shuixingzhi_add').css('display','block');

			}else if(common_index == 3){ //删除属性值模块显示

				$('.display_same').css('display','none');
				$('.shuixingzhi_delete').css('display','block');
			}

            //隐藏提示信息
			$('.tip_infor').css('display','none');
		});
		//已有属性的下拉框
		$('.attribute').change(function(){
			var val  = $(this).val();
			$('.attributes span').html(val);
			if(val!= "<?=Yii::t('yii','please choose');?>"){
				//ajax提交 交换该属性拥有的属性值
				$.ajax({
		      		url:'./index.php?r=device/dev_property',
		      		type:'post',
		      		data:{'attribute':val,'<?php echo \Yii::$app->request->csrfParam;?>':'<?php echo \Yii::$app->request->csrfToken?>'},
		      		dataType:'text',
		      		error:function(){
		      			alert('失败了');
		      		},
		      		success:function(msg){
		      			//清空select下面的option
		      			$('.attribute_val').empty();

		      			var str = $.trim(msg);
		      			var arr = str.split('$$$$');
		      			var length = (arr.length)-1;
		      			for (var i =0; i<length; i++) {
		      				$('.attribute_val').append("<option value="+arr[i]+">"+arr[i]+"</option>");
		      			};

		      			$('.attribute_vals span').html(arr[0]);
		      		}
		      	})
			}
		})
		//已有属性值的下拉框
		$('.attribute_val').change(function(){
			$('.attribute_vals span').html($(this).val());
		})

		//删除属性的下拉框
		$('.del_attribute').change(function(){
			$('.del_attributes span').html($(this).val());
		})

		//添加属性值的下拉框
		$('.add_attribute_val').change(function(){
			$('.add_attribute_vals span').html($(this).val());
		})
		//删除属性值的下拉框
		$('.del_attribute_').change(function(){
			var del_att = $(this).val();
			$('.del_attribute_s span').html(del_att);

			if(del_att!= "<?=Yii::t('yii','please choose');?>"){

				//ajax提交 交换该属性拥有的属性值
				$.ajax({
		      		url:'./index.php?r=device/dev_property',
		      		type:'post',
		      		data:{'attribute':del_att,'<?php echo \Yii::$app->request->csrfParam;?>':'<?php echo \Yii::$app->request->csrfToken?>'},
		      		dataType:'text',
		      		error:function(){
		      			alert('失败了');
		      		},
		      		success:function(msg){
		      			//清空select下面的option
		      			$('.del_attribute_val').empty();

		      			var str = $.trim(msg);
		      			var arr = str.split('$$$$');
		      			var length = (arr.length)-1;
		      			for (var i =0; i<length; i++) {
		      				$('.del_attribute_val').append("<option value="+arr[i]+">"+arr[i]+"</option>");
		      			};

		      			$('.del_attribute_vals span').html(arr[0]);
		      		}
		      	})
			}
		})
		$('.del_attribute_val').change(function(){
			var del_val = $(this).val();
			$('.del_attribute_vals span').html(del_val);
		})
       //开始获得属性值
       var attribute = $('.attribute').val();
       $('.attributes span').html(attribute);
       //开始获得属性
       var attribute_val = $('.attribute_val').val();
       $('.attribute_vals span').html(attribute_val);
       
       //开始获得属性
       var attribute_val = $('.add_attribute_val').val();
       $('.add_attribute_vals span').html(attribute_val);

       //开始获得属性
       var del_attribute = $('.del_attribute').val();
       $('.del_attributes span').html(del_attribute);

       //开始获得属性
       var del_attribute_ = $('.del_attribute').val();
       $('.del_attribute_s span').html(del_attribute_);

       //开始获得属性值
       var del_attribute_val = $('.del_attribute_val').val();
       $('.del_attribute_vals span').html(del_attribute_val);

       	//点击删除属性按钮
        $('.del_attribute_btn').click(function(){
       	    
       		$('.user_shadow').css('display','block');
       		$('.user_shadow_content').css('display','block');


       		$('.user_shadow_quxiao').click(function(){
       			$('.user_shadow').css('display','none');
       			$('.user_shadow_content').css('display','none');
       		});

       		$('.user_shadow_sure').click(function(){
       			var val = $('.del_attribute').val();
       			window.location.href = './index.php?r=device/dev_property&del_attribute='+val;
       		});
        })
        //点击删除属性值按钮
        $('.del_attribute_vals_btn').click(function(){
       		$('.user_shadow').css('display','block');
       		$('.user_shadow_content').css('display','block');


       		$('.user_shadow_quxiao').click(function(){
       			$('.user_shadow').css('display','none');
       			$('.user_shadow_content').css('display','none');
       		});

       		$('.user_shadow_sure').click(function(){
       			var attr = $('.del_attribute_').val();
       			var attr_val = $('.del_attribute_val').val();
       			window.location.href = './index.php?r=device/dev_property&del_attribute_val='+attr+'&del_attribute_vals='+attr_val;
       		});
        })
	})
</script>
</html>