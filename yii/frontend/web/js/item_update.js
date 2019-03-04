   $(function(){
        //下拉框添加的选项值
        $('.user_dec_type_name').change(function(){
            var val = $(this).val(); 
            $(this).prev('.user_pinpai2').find('span').html(val);
        })
        
        //添加属性值的js
        $('.manager').change(function(){
            var val = $(this).val(); 
            var item_id = $('.item_id').val();
            var nums = $('.managers input').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if($('.managers input').eq(i).val()== val){
                    aa=1;
                }
            }
            if(!aa){ 
                $.ajax({
                    url:'./index.php?r=item/item_update',
                    type:'get',
                    data:{'manager':val,'item_id':item_id},
                    dataType:'text',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg){
                           $('.managers').append("<input type='text' value='"+val+"' class='pinpaizhi' name='managers[]' readonly/>"); 
                        }
                    }
                }) 
            }
        })
        //添加属性值的js
        $('.suoshu_user').change(function(){
            var val = $(this).val();
            var item_id = $('.item_id').val(); 
            var nums = $('.suoshu_users input').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if($('.suoshu_users input').eq(i).val()== val){
                    aa=1;
                }
            }
            if(!aa){
                 $.ajax({
                    url:'./index.php?r=item/item_update',
                    type:'get',
                    data:{'suoshu_user':val,'item_id':item_id},
                    dataType:'text',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg){
                           $('.suoshu_users').append("<input type='text' value='"+val+"' class='pinpaizhi' name='users[]' readonly/>"); 
                        }
                    }
                })
            }
        })
        //添加属性值的js
        $('.suoxu_device').change(function(){
            var val = $(this).val(); 
            var item_id = $('.item_id').val(); 
            var nums = $('.suoxu_devices input').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if($('.suoxu_devices input').eq(i).val()== val){
                    aa=1;
                }
            }
            if(!aa){
                $.ajax({
                    url:'./index.php?r=item/item_update',
                    type:'get',
                    data:{'suoxu_device':val,'item_id':item_id},
                    dataType:'text',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg){
                           $('.suoxu_devices').append("<input type='text' value='"+val+"' class='pinpaizhi' name='device[]' readonly/>"); 
                        }
                    }
                })
            }
        })

        //删除属性值的js
        $('.ajax_delete').change(function(){
           var val = $(this).val(); 
            var item_id = $('.item_id').val(); 
            $(this).prev('.user_pinpai').find('span').html(val);
            var remove_html =  $(this).parents('li').find('.mouseover').find('input');
            var nums = remove_html.length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if( $(this).parents('li').find('.mouseover').find('input').eq(i).val()== val){
                    $.ajax({
                        url:'./index.php?r=item/item_update',
                        type:'get',
                        data:{'delete_ajax_user':val,'item_id':item_id},
                        dataType:'text',
                        error:function(){
                            alert('失败了');
                        },
                        success:function(msg){
                            if(msg){
                              // alert(msg); 
                            }
                        }
                    })
                    remove_html.eq(i).remove();  
                }
            }
        })

        //删除属性值的js
        $('.delete_ajax_device').change(function(){
           var val = $(this).val(); 
            var item_id = $('.item_id').val(); 
            $(this).prev('.user_pinpai').find('span').html(val);
            var remove_html =  $(this).parents('li').find('.mouseover').find('input');
            var nums = remove_html.length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if( $(this).parents('li').find('.mouseover').find('input').eq(i).val()== val){
                    $.ajax({
                        url:'./index.php?r=item/item_update',
                        type:'get',
                        data:{'delete_ajax_device':val,'item_id':item_id},
                        dataType:'text',
                        error:function(){
                            alert('失败了');
                        },
                        success:function(msg){
                            if(msg){
                              // alert(msg); 
                            }
                        }
                    })
                    remove_html.eq(i).remove();  
                }
            }
        })

        //ajax 删除私有的属性属性值
        $('.delete_siyou_btn').click(function(){
            var siyou_id = $(this).parent().next().val();
            var par = $(this).parents('li');
            $('.user_shadow').css('display','block');
            $('.user_shadow_content').css('display','block');

            $('.user_shadow_quxiao').click(function(){
                $('.user_shadow').css('display','none');
                $('.user_shadow_content').css('display','none');
            })

             $('.user_shadow_sure').click(function(){
                $.ajax({
                    url:'./index.php?r=item/item_update',
                    type:'get',
                    data:{'siyou_id':siyou_id},
                    dataType:'text',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg == 'success'){ 
                            par.remove();
                        }else{
                          
                        }
                    }
                })    
                $('.user_shadow').css('display','none');
                $('.user_shadow_content').css('display','none');
            })
         })


        // 添加私有属性
        $('.add_siyou_btn').click(function(){
            var siyou = $(this).parent('.add_siyou_all').find('.add_siyou').val();
            var siyou_val = $(this).parent('.add_siyou_all').find('.add_siyou_val').val();
           
            if((siyou)&& (siyou_val)){
                $('.add_siyou_all').before("<li style='clear:both;margin-top:10px;' class='add_siyou_alls'><input type='text' class='input add_si' value='"+siyou+"' style='border: none;width:96px;text-indent:0px;' readonly/><input type='text' class='input add_siyou_vals' value='"+siyou_val+"' style='border:solid 1px #a7b5bc;width: 300px' readonly/><img src='./images/delete1.png' class='siyou_delete_btn' style='width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left:6px;'></li>");
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

        $(document).on('mouseover','.dev_brand',function(){
            $(this).find('input').css('background-color','#E5EBEE');
             $(this).css('background-color','#E5EBEE');
            $(this).find('img').css('display','inline-block');
        })

        $(document).on('mouseleave','.dev_brand',function(){
            $(this).css('background-color','#fff');
            $(this).find('input').css('background-color','#fff');
            $(this).find('img').css('display','none');
        })

         $('.add-devs').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(0).css('display','block');
            $('.content_device').eq(0).css('display','block');
        })
        $('.content_device').mouseleave(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
        })
        $('.add_devs1').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(1).css('display','block');
            $('.content_device').eq(1).css('display','block');
        })
        $('.add_devs2').click(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
            $('.box').eq(2).css('display','block');
            $('.content_device').eq(2).css('display','block');
        })

        $(document).on('click','.content_device div',function(){
            var item_id = $('.item_id').val();
            var val = $(this).html();
            var prevs = $(this).parent().prev().prev();
            var flags = prevs.find('.flag_').val();
            var flag = '';
            if(flags == 1){
                flag = 'user_manage';
            }else if(flags == 2){
                flag = 'user_client';
            }else if(flags == 3){
                flag = 'user_device';
            }
            var nums = prevs.find('.dev_brand').length;
            var aa = 0;
            for(var i=0;i<nums;i++){
                if(prevs.find('.pinpaizhi').eq(i).val()== val){
                    aa=1;
                }
            }
            if(!aa){
                var date ={
                    'flag':flag,
                    'item_id':item_id,
                    'item_att':val
                }
                $.ajax({
                    url:'./index.php?r=item/item_update',
                    type:'get',
                    data:{'ajax_add_item_att':date},
                    dataType:'json',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg == 'success'){ 
                            prevs.append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi "+flag+"' name='brand[]' readonly/><img src='./images/delete1.png'class='delete_attr'></div>")
                        }else{
                           $('.tips').html(msg);
                        }
                    }
                })   
            }
        })

        $(document).on('click','.delete_attr',function(){
            var val = $(this).prev().val();
            var par = $(this).parent('.dev_brand');
            var item_id = $('.item_id').val();
            var flag_vals = $(this).parents('.mouseover').find('.flag_').val();
            var date = {
                'flag':flag_vals,
                'item_id':item_id,
                'val':val
            };
            $.ajax({
                url:'./index.php?r=item/item_update',
                type:'get',
                data:{'ajax_delete_item_att':date},
                dataType:'json',
                error:function(){
                    alert('失败了');
                },
                success:function(msg){
                    if(msg == 'success'){ 
                        par.remove(); 
                        $('.user_shadow1').css('display','none');
                        $('.user_shadow_content1').css('display','none');
                    }else{
                        $('.tips').html(msg);
                    }
                }
            }) 
        })
    })

function check(){
    var item_name = $('.dev_name').val();
    var item_id = $('.item_id').val();
    var remark = $('.remark').val(); 
    var item_siyou_len = $('.add_si').length;
    var user_n_len = $('.user_manage').length;
    var user_d_len = $('.user_device').length;
    if(!item_name){
        $('.tips').html('项目名不能为空');
        return false;
    } 
    if(item_name.length>40) {
        $('.tips').html('项目名称过长');
        return false;
    }
    if(!user_n_len){
        $('.tips').html('项目管理者不能为空');
        return false;
    }
    if(!user_d_len){
        $('.tips').html('项目所需机种不能为空');
        return false;
    }
    if(item_siyou_len){
        var item_siyou = new Array();
        var item_siyou_val = new Array();
        for(var i=0;i<item_siyou_len;i++){
            item_siyou[i] = $('.add_si').eq(i).val();
            item_siyou_val[i] = $('.add_siyou_vals').eq(i).val();
        }
        var date ={
            'item_id':item_id,
            'item_name':item_name,
            'remark':remark,
            'item_siyou':item_siyou,
            'item_siyou_val':item_siyou_val
        }
    }else{
        var date ={
            'item_id':item_id,
            'item_name':item_name,
            'remark':remark
        } 
    }
    $.ajax({
        url:'./index.php?r=item/item_update',
        type:'get',
        data:{'ajax_update_item':date},
        dataType:'json',
        error:function(){
            alert('失败了');
        },
        success:function(msg){
            if(msg == 'success'){ 
                window.location.href = './index.php?r=item/item';
            }else{
                $('.tips').html(msg);
            }
        }
    }) 
}