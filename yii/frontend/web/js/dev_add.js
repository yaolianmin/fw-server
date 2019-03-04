$(function(){
		//添加属性值的js
        $('#user_dec_type_name').change(function(){
           var val = $(this).val(); 
           $('.user_pinpai2 span').html(val);
         	if(val!="<?=Yii::t('yii','please choose');?>"){
	           	var nums = $('.mouseover input').length;
	            var aa = 0;
	            for(var i=0;i<nums;i++){
	                if($('.mouseover input').eq(i).val()== val){
	                    aa=1;
	                }
	            }
	            if(!aa){
	                $('.mouseover').append("<input type='text' value='"+val+"' class='pinpaizhi' name='brand[]' readonly/>")
	            } 
	        }
        })

		//设备类型的下拉框
		$('.equit').change(function(){
			var pin_val = $(this).val();
			var spans = $(this).prev().children('span');
			spans.html(pin_val);
		})
        //删除属性属性值
        $('.add_siyou_delete_btn').click(function(){
            $('.add_siyou_all input').val('');
            $('.add_siyou_all').css('display','none');
        })
	});