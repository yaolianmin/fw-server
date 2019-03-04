$(function(){
    $('.file_dowload_dev').click(function(){
        $('.dev_file_devices span').html($(this).val());
    })
    //下载s删除按钮
    $('.common_dec_download').click(function(){
        $('.common_dec_btn').removeClass('common_dec_add');
        $(this).addClass('common_dec_add');
        $('.dev_add_form').css('display','none');
        $('.file_download_del').css('display','block');
        $('.batch_button').css('display','block');
    })
    //添加按钮
    $('.common_dec_adds').click(function(){
        $('.common_dec_btn').removeClass('common_dec_add');
        $(this).addClass('common_dec_add');

        $('.dev_add_form').css('display','none');
        $('.add_file').css('display','block');
        $('.batch_button').css('display','none');
    })
    //添加版本按钮
    $('.common_dec_update').click(function(){
        $('.common_dec_btn').removeClass('common_dec_add');
        $(this).addClass('common_dec_add');
        $('.dev_add_form').css('display','none');
        $('.update_file').css('display','block');
        $('.batch_button').css('display','none');
    })
    //文件的机种替换
    $('.dev_file_device').change(function(){
        var val = $(this).val();
        $('.dev_file_devices span').html(val); 
        //ajax替换机种的品牌值
        $.ajax({
            url:'./index.php?r=device/dev_files',
            type:'get',
            data:{'ajax_download_device':val},
            dataType:'text',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
                var msg = msg.split('#####');
                //品牌值的替换
                var pinpai = msg[0].split('@@@@@');
                var pin_len = (pinpai.length)-1;
                $('.file_dowload_pin').empty();
                for(var i=0;i<pin_len;i++){
                    $('.file_dowload_pin').append("<option value='"+pinpai[i]+"'>"+pinpai[i]+"</option>")
                }
                $('.file_dowload_pins span').html(pinpai[0]);
                //版本号的替换
                $('.file_dowload_ver').empty();
                $('.file_dowload_vers span').html('');
                if(msg[1]){
                    var version = msg[1].split('$$$$$');
                    var ver_len = (version.length)-1;
                    for(var j = 0;j < ver_len;j++){
                        $('.file_dowload_ver').append("<option value='"+version[j]+"'>"+version[j]+"</option>");
                    }
                    $('.file_dowload_vers span').html(version[0]);
                }
                // 文件的替换
                $('.file_info').remove();
                if(msg[2]){
                    var every_file   = msg[2].split('*****');
                    var every_remark = msg[3].split('&&&&&');
                    var file_len = (every_file.length)-1;
                    for(var i=0;i<file_len;i++){
                        var file_info = every_file[i].split('%%%%%');
                        $('.add_here_file').append("<tr class='file_info'><td><input type='checkbox' name='' class='choice' value='"+file_info[0]+"'></td><td>"+(i+1)+"</td><td style='color: #83C9F5;min-width: 550px;max-width: 600px;overflow: hidden;'>"+file_info[1]+"</td><td style='width: 400px;' title='"+file_info[2]+"'>"+every_remark[i]+"</td><td class='the_last'><img src='./images/dow1.png' style='width:20px;height: 20px'></td></tr>");
                    }
                }
            }
        })
    })
    //文件的品牌替换
    $('.file_dowload_pin').change(function(){
        var val = $(this).val();
        $('.file_dowload_pins span').html(val);
        var ajax_device = $('.file_dowload_dev').val();
        //ajax替换版本名 文件 第一个文件的详情
        $.ajax({
            url:'./index.php?r=device/dev_files',
            type:'get',
            data:{'ajax_download_pinpai':val,'ajax_download_dev':ajax_device},
            dataType:'text',
            error:function(){
                alert('失败了');
            },
            success:function(msg){ 
                var msg = msg.split('#####');
                //版本号的替换
                $('.file_dowload_ver').empty();
                $('.file_dowload_vers span').html('');
                if(msg[0]){
                    var version = msg[0].split('$$$$$');
                    var ver_len = (version.length)-1;
                    for(var j = 0;j < ver_len;j++){
                        $('.file_dowload_ver').append("<option value='"+version[j]+"'>"+version[j]+"</option>");
                    }
                    $('.file_dowload_vers span').html(version[0]);
                }
                // 文件的替换
                $('.file_info').remove();
                if(msg[1]){
                    var every_file   = msg[1].split('*****');
                    var every_remark = msg[2].split('&&&&&');
                    var file_len = (every_file.length)-1;
                    for(var i=0;i<file_len;i++){
                        var file_info = every_file[i].split('%%%%%');
                        $('.add_here_file').append("<tr class='file_info'><td><input type='checkbox' name='' class='choice' value='"+file_info[0]+"'></td><td>"+(i+1)+"</td><td style='color: #83C9F5;min-width: 550px;max-width: 600px;overflow: hidden;'>"+file_info[1]+"</td><td style='width: 400px;' title='"+file_info[2]+"'>"+every_remark[i]+"</td><td class='the_last'><img src='./images/dow1.png' style='width:20px;height: 20px'></td></tr>");
                    }
                }
            }
        })
    })
    // 文件的版本替换
    $('.file_dowload_ver').change(function(){
        var val = $(this).val();
        $('.file_dowload_vers span').html(val);
        var ajax_dev = $('.file_dowload_dev').val();
        var ajax_pinpai = $('.file_dowload_pin').val();

        //ajax替换文件 第一个文件的详情
        $.ajax({
            url:'./index.php?r=device/dev_files',
            type:'get',
            data:{'ajax_download_ver':val,'ajax_down_dev':ajax_dev,'ajax_down_pin':ajax_pinpai},
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
                        $('.add_here_file').append("<tr class='file_info'><td><input type='checkbox' name='' class='choice' value='"+file_info[0]+"'></td><td>"+(i+1)+"</td><td style='color: #83C9F5;min-width: 550px;max-width: 600px;overflow: hidden;'>"+file_info[1]+"</td><td style='width: 400px;' title='"+file_info[2]+"'>"+every_remark[i]+"</td><td class='the_last'><img src='./images/dow1.png' style='width:20px;height: 20px'></td></tr>");
                    }
                }
            }   
        })
    })
    // 添加文件的机种替换
    $('.file_add_dev').change(function(){
        var val = $(this).val();
        $('.file_add_devs span').html(val);
        //ajax替换机种的品牌值
        $.ajax({
            url:'./index.php?r=device/dev_files',
            type:'get',
            data:{'ajax_file_device':val},
            dataType:'text',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
                var index = msg.indexOf('#####')-5;
                var pinpai = msg.substr(0,index);
                var version = msg.slice(index+10);
                //品牌值的修改
                var pinpai = pinpai.split('@@@@@');
                $('.file_add_pin').empty();
                var pin_len = pinpai.length;
                for(var i=0;i<pin_len;i++){
                    $('.file_add_pin').append("<option value='"+pinpai[i]+"'>"+pinpai[i]+"</option>"); 
                }
                $('.file_add_pins span').html(pinpai[0]);
                //版本的修改
                $('.file_add_ver').empty();
                $('.file_add_vers span').html('');
                if(version){
                    var version = version.split('$$$$$');
                    var ver_len = (version.length)-1;
                    for(var j=0;j<ver_len;j++){
                        $('.file_add_ver').append("<option value='"+version[j]+"'>"+version[j]+"</option>"); 
                    }
                    $('.file_add_vers span').html(version[0]);
               }
            }
        })
    })
    // 添加文件的品牌替换
    $('.file_add_pin').change(function(){
        var val = $(this).val();
        $('.file_add_pins span').html(val);
        var val_dev = $('.file_add_dev').val();
        //ajax替换机种的品牌值
        $.ajax({
            url:'./index.php?r=device/dev_files',
            type:'get',
            data:{'ajax_file_pinpai':val,'ajax_file_dev':val_dev},
            dataType:'text',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
                $('.file_add_ver').empty();
                $('.file_add_vers span').html('');
                if(msg){ //传输的版本不为空
                    var version = msg.split('@@@@@'); 
                    var len = (version.length)-1;
                    for(var i=0;i<len;i++){
                        $('.file_add_ver').append("<option value='"+version[i]+"'>"+version[i]+"</option>")
                    }
                    $('.file_add_vers span').html(version[0]); 
                }
            }
        })
    })
    // 添加文件的版本替换
    $('.file_add_ver').change(function(){
         var val = $(this).val();
        $('.file_add_vers span').html(val);
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
                alert('Files can only download files less than 1G');
            }
        });

        // 添加版本机种替换
        $('.version_add_dev').change(function(){
            var val = $(this).val();
            $('.version_add_devs span').html(val);
            //ajax替换机种的品牌值
            $.ajax({
                url:'./index.php?r=device/dev_files',
                type:'get',
                data:{'ajax_file_device':val},
                dataType:'text',
                error:function(){
                    alert('失败了');
                },
                success:function(msg){
                   var index = msg.indexOf('#####')-5;
                   var pinpai = msg.substr(0,index);
                   var version = msg.slice(index+10);
                   //品牌值的修改
                   var pinpai = pinpai.split('@@@@@');
                   $('.version_add_pin').empty();
                   var pin_len = pinpai.length;
                   for(var i=0;i<pin_len;i++){
                       $('.version_add_pin').append("<option value='"+pinpai[i]+"'>"+pinpai[i]+"</option>"); 
                   }
                   $('.version_add_pins span').html(pinpai[0]);
                }
            })
    })
         //全选按钮
        $(function(){
            $('.both-delete').click(function(){
                $('.choice').prop('checked',$(this).prop('checked'));       
            }); 
        });
        // 添加版本品牌的替换
        $('.version_add_pin').change(function(){
            var val = $(this).val();
            $('.version_add_pins span').html(val);
        })
        //下载文件按钮
        $(document).on('click','.the_last img',function(){
            var val = $(this).parents('.file_info').find('.choice').val();
            window.location.href = './index.php?r=device/dev_files&download_id='+val;
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
                window.location.href = './index.php?r=device/batch_download_file&fil_id='+del_name;
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
                    window.location.href = './index.php?r=device/dev_files&batch_delete_id='+del_name;
                }else{
                    $('.user_shadow').hide();
                    $('.user_shadow_content').hide();
                }
            }) 
        })
    })
    //检测版本是否为空 添加备注值输入框中
    function chk(){
        var version_ = document.getElementById('dev_file_version');
        if(!version_.value){
            alert('no version,please add version first !');
             return false;
        }
        return true;
    }

   