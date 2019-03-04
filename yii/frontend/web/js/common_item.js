$(function(){
		//添加 删除Class的切换
		$('.device_infor ul li').click(function(){
			//获取当前的位置
			var common_index = $(this).index();
			$('.device_infor ul li').removeClass('common_dec_add');
			$(this).addClass('common_dec_add');
			//判断是添加还是删除
			$('.common_flag').val(common_index);
			if(common_index == 1){
				$('.tips').css('display','block');
			}else{
				$('.tips').css('display','none');
			}
		});

		//机种的下拉框
		$('#common_add_dec_jibie').change(function(){
			$('.common_add_jibie span').html($(this).val());
		})

		var val = $('#common_add_dec_jibie').val();
		$('.common_add_jibie span').html(val);
	})