 $(function(){
     //全选按钮
    $(function(){
        $('.both-delete').click(function(){
            $('.choice').prop('checked',$(this).prop('checked'));       
        }); 
    });
    //文件按钮
    $('.common_dec_download').click(function(){
       $(this).addClass('common_dec_add');
       $('.common_dec_adds').removeClass('common_dec_add');
       $('.item_file_info').css('display','block');
       $('.add_item_file').css('display','none');
        $('.batch_button').css('display','block');
    })
    //添加文件按钮
    $('.common_dec_adds').click(function(){
       $(this).addClass('common_dec_add');
       $('.common_dec_download').removeClass('common_dec_add');
       $('.item_file_info').css('display','none');
       $('.add_item_file').css('display','block');
       $('.batch_button').css('display','none');
    })
    //项目ajax的替换文件
      $('.dev_file_item').change(function(){
    	var val = $(this).val();
    	$('.dev_file_items span').html(val);
    	//ajax替换机种的品牌值
        $.ajax({
            url:'./index.php?r=item/item_files',
            type:'get',
            data:{'ajax_download_item':val},
            dataType:'text',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
                var msg = msg.split('#####');
                //文件的替换
                $('.file_info').remove();
                if(msg[0]){
                    var every_file   = msg[0].split('*****');
                    var every_remark = msg[1].split('&&&&&');
                    var file_len = (every_file.length)-1;
                    for(var i=0;i<file_len;i++){
                        var file_info = every_file[i].split('%%%%%');
                        $('.add_here_file').append("<tr class='file_info'><td><input type='checkbox' name='' class='choice' value='"+file_info[0]+"'></td><td>"+(i+1)+"</td><td style='color: #83C9F5;min-width: 550px;max-width: 600px;overflow: hidden;'>"+file_info[1]+"</td><td style='width: 400px;' title='"+file_info[2]+"'>"+every_remark[i]+"</td><td class='the_last'><img src='./images/download_file.png' style='width:20px;height: 20px;margin-top:6px;'></td></tr>");
                    }
                }
            }
        })
    })
    //下载文件按钮
    $(document).on('click','.the_last img',function(){
        var val = $(this).parents('.file_info').find('.choice').val();
        window.location.href = './index.php?r=item/item_files&download_id='+val;
    })
    //批量下载文件操作
    $('.batch_download').click(function(){
        var length = $('.choice').length;
        var del_name = '';
        for(var i=0; i<length;i++){
            if($('.choice').eq(i).prop('checked')){
                del_name = del_name+$('.choice').eq(i).val()+',';
            }
        }
        var tran = del_name.length;
        if(tran){
            window.location.href = './index.php?r=device/batch_download_file&item_file_id='+del_name;
        }else{
            alert('please select file');
        }  
    })     

   //批量删除文件操作
    $('.batch_delete').click(function(){
        var length = $('.choice').length;
        var del_name = '';
        for(var i=0; i<length;i++){
            if($('.choice').eq(i).prop('checked')){
                del_name = del_name+$('.choice').eq(i).val()+',';
            }
        }
        var tran = del_name.length;
        $('.user_shadow').show();
        $('.user_shadow_content').show();

        $('.user_shadow_quxiao').click(function(){
            $('.user_shadow').hide();
            $('.user_shadow_content').hide();
        })
        $('.user_shadow_sure').click(function(){
            if(tran){
                window.location.href = './index.php?r=item/item_files&batch_delete_id='+del_name;
            }else{
                $('.user_shadow').hide();
                $('.user_shadow_content').hide();
            }
        }) 
    })
    //获得添加文件的上传名称以及限制文件上传
    $('.dev_file').change(function(){
        var file = $(".dev_file").val();
        var fileName = getFileName(file);
  
        function getFileName(o){
            var pos=o.lastIndexOf("\\");
            return o.substring(pos+1);  
        } 
        $('.show_file_names').val(fileName);

        var size = $(".dev_file")[0].files[0].size;
        if(size>1000000000){
            alert('文件只能下载小于1000M的文件');
        }
    });
})