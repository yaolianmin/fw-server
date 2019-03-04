$(function(){
        //添加属性属性值
        $('.add_att').click(function(){
            $('.add_attri_val').css('display','block');
        })
        //删除属性属性值
        $('.delete_att').click(function(){
            $('.add_attri_val input').val('');
            $('.add_attri_val').css('display','none');
        })
        //添加属性值的js
        $('#user_dec_type_name').change(function(){
           var val = $(this).val(); 
           $('.user_pinpai2 span').html(val);
           
            var nums = $('.mouseover input').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if($('.mouseover input').eq(i).val()== val){
                    aa=1;
                }
            }
            if(!aa){
                $('.mouseover').append("<input type='text' value='"+val+"' class='pinpaizhi' name='pinpaizhi[]' readonly/>")
            }
        })
        //删除属性值的js
        $('#user_dec_type').change(function(){
           var val = $(this).val(); 
           $('.user_pinpai span').html(val);

            var nums = $('.mouseover input').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if($('.mouseover input').eq(i).val()== val){
                    $('.mouseover input').eq(i).remove();
                }
            }
        })
        //属性值的下拉框
        $('.dev_add_dec_jibie').change(function(){
            var val = $(this).val();
            $(this).parent().find('.dev_add_jibie').find('.show_').val(val); 
        })

        //删除机种私有属性值
        $('.delete_att_all').click(function(){
            var index= $(this).parents('.thiss');
            $('.user_shadow').css('display','block');
            $('.user_shadow_content').css('display','block');

            //取消按钮
            $('.user_shadow_quxiao').click(function(){
                $('.user_shadow').css('display','none');
                $('.user_shadow_content').css('display','none');
            })

            //确定按钮
            $('.user_shadow_sure').click(function(){
                $('.user_shadow').css('display','none');
                $('.user_shadow_content').css('display','none');

                var val = index.find('.att_id').val();
                $.ajax({
                    url:'./index.php?r=device/dev_update',
                    type:'get',
                    data:{'del_att':val},
                    dataType:'text',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        
                           index.remove();
                    }
                })
            })
        })
    })