$(function(){
		//级别的下拉框
		$('#user_dec_jibie').change(function(){
			var val =$(this).val();
			$('.user_jibie span').html(val);

			//PM FAE默认拥有的权限
			if(val== 'PM'){

				$('.user_input').prop('checked','');
                $('.pm').prop('checked','true'); 
               	$('.user_dev_inf').css('display','none');
			}else if(val== 'FAE'){ //普通户用 其他默认权限

				$('.user_input').prop('checked','');
                $('.pm').prop('checked','true');
				$('.user_dev_inf').css('display','block');
			}else if(val== '普通用户'||val== '其他'){ //普通户用 其他默认权限

				$('.user_input').prop('checked','');
				$('.common_power').prop('checked','true');
				$('.user_dev_inf').css('display','block');
			}else if(val== '请选择'){ //没选择
				$('.user_dev_inf').css('display','block');
				$('.user_input').prop('checked','');
			};
		})
		/**
		* 功能：将下拉框的值不重复的放入机种表单中
		*/
		$('#user_dec_type_name').change(function(){
			var dev_val = $(this).val();
			$('.user_pinpai2 span').html(dev_val);
			if(dev_val!='请选择机种'){
				var val = $('.user_add_dev_add').val();
				if(val == ''){
					$('.user_add_dev_add').val(val+' '+$(this).val());
				}else{
					var device = val.split(" ");
					var length = device.length;
					var j = 0;
					for(var i = 0;i<length;i++){
						if(device[i] == dev_val){
							j = 1;
						}
					}
					if(j == 0){
						$('.user_add_dev_add').val(val+' '+$(this).val());
					}
				}
			}
		})

		//动态追加备注信息 (append里面的不可换行)
		$(document).on('click','.add_remarks',function(){
			$(this).parent().append("<li style='clear:both;margin-top:-30px;margin-left:0px;'><span class='span'>备注</span><input type='text' style='width:442px;float:left;' class='input' name='remark[]'><span style='float:left;margin-top:5px;margin-left:10px;' class='add_remarks'><img src='./images/add.png' ></span><span style='float:left;margin-top:5px;margin-left:10px;' class='delete_remarks'><img src='./images/delete.png'></span></li>");
		})

		//动态删除备注信息
		$(document).on('click','.delete_remarks',function(){
			$(this).parent().remove();
		})

		//页面滚动效果
		if($('.user_add_tip').html()!=''){
			$(window).scrollTop(180);
		}
})