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
		      			var arr = str.split(' ');
		      			var length = arr.length;
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
		      			var arr = str.split(' ');
		      			var length = arr.length;
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