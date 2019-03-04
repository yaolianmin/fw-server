$(function(){
        //遮罩层显示
        $('#device-delete').click(function(){
            $('.user_shadow').show();
            $('.user_shadow_content').show();

            //取消遮罩层
            $('.user_shadow_quxiao').click(function(){
                $('.user_shadow').hide();
                $('.user_shadow_content').hide();
            })

            //弹出层确定按钮
            $('.user_shadow_sure').click(function(){
                var length = $('.choice').length;
                var del_name = '';
                for(var i=0; i<length;i++){
                    if($('.choice').eq(i).prop('checked')){
                        del_name = del_name+$('.choice').eq(i).val()+',';
                    }
                }
                var tran = del_name.length;
                if(!tran){
                    $('.user_shadow').hide();
                    $('.user_shadow_content').hide();   
                }else{
                    window.location.href = './index.php?r=item/item&del_items='+del_name;
                }
            })
        })
         //全部删除按钮
        $('.both').click(function(){
       
            $('.choice').prop('checked',$(this).prop('checked'));       
        }); 

        $('.active a').removeAttr("href");
    })