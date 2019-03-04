<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>ZWA后台管理系统</title>
	<link href="css/dev_update.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
</head>
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
        <div style="font-size:14px;margin-left:90px;margin-top:60px;" class="con">Are you sure delete this option ?</div>
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
	            <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"> <a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
	            <li><a href="./index.php?r=device/device" ondragstart="return false"><?=Yii::t('yii','device management');?>></a></li>
	            <li><a href="#" ondragstart="return false"><?=Yii::t('yii','device');?> <?=Yii::t('yii','details');?></a></li>
	        </ul>
	    </div>
	    <!-- 机种详情 -->
	    <div class="device_infor">
	    	<ul>
	    		<li>
	    			<a href="#" ondragstart="return false"><?=Yii::t('yii','update');?> <?=Yii::t('yii','device');?></a>
	    		</li>
	    	</ul>
	    </div>
	     <!-- 表单信息栏 -->
	    <form  class="dev_add_form">
	    	<ul>
	    		<li>
					<span class='span'><?=Yii::t('yii','device name');?><i style='color:#ea2020;'>*</i></span>
					<input type="text" class="input dev_name" placeholder='<?=Yii::t('yii','input device name');?>' value="<?=$dev_name?>" required>
                    <input type="hidden" value="<?=$dev_id?>" class='dev_names'/>
                    <span style="float：right;margin-left: 10px;color: #ccc;"><?=Yii::t('yii','within 32 characters');?></span>
	    		</li>
                <?php
                    $i=0;
                    foreach ($gongyou as $val) { 
                ?>
                <li class="thiss">
                    <span class='span'><?=$val['aname']?></span>
                    <input type="hidden" value="<?=$val['id']?>" class='att_id'/>
                    <div class="dev_add_jibie">
                            <input type="text" style="height:34px;border:none;margin-left:10px;"  value="<?=$val['vname']?>" class='show_'>
                            <img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
                    </div>
                    <select  class='dev_add_dec_jibie attributes'>
                        <?php
                        foreach ($val['aname_val'] as $value){
                        ?>
                            <option value="<?=$value['vname']?>" ><?=$value['vname']?></option>
                        <?php
                        }
                        ?>
                    </select>   
                </li>
                <?php
                $i++;
                }
                ?>
                <!--私有属性值 -->
                <?php
                    foreach ($siyou as $val) { 
                ?>
                <li class="thiss">
                    <span class='span'><?=$val['aname']?></span>
                    <input type="hidden" value="<?=$val['id']?>" class='att_id'/>
                    <input type="text" style="width:220px;float:left;outline:none" class="input"  value="<?=$val['vname']?>" required  readonly>
                    <img src="./images/delete1.png" style="display:<?php if($val['statue']){echo 'none';}?>;border-radius: 50%;margin-left: -4px;" class="delete_att_all" />
                </li>
                <?php
                }
                ?>
                <li style="clear:both;margin-top:10px;" class="add_siyou_all">
                    <input type="text" class="input add_siyou"  placeholder="<?=Yii::t('yii','add attribute');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width:90px;text-indent:0px;" />
                    <input type="text" class="input add_siyou_val"  placeholder="<?=Yii::t('yii','add attribute values');?>" style="border: none;border-bottom:solid 1px #a7b5bc;width: 220px;padding: -4px;" />
                    <img src="./images/add1.png" class="add_siyou_btn" style="width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left: 8px;">
                    <span style="float：right;margin-left: 10px;color: #ccc;"><?=Yii::t('yii','The private property and attribute value of the device can not be filled in');?></span>
                </li>
                <li style="clear: both;"></li>
                <li style="clear:both;position: relative;margin-top: -14px;">
                    <span class='span'><?=Yii::t('yii','brand');?></span>
                    <div class="span mouseover" style=" width:462px;height:100px;overflow:auto;border:1px solid #A7B5BC">
                        <?php
                        foreach ($pinpai as $val) {
                        ?>
                        <div class='dev_brand'><input type='text' value="<?=$val['vname']?>" class='pinpaizhi attributes' readonly/><img src='./images/delete1.png'class='delete_attr'></div>
                        <?php   
                        }
                        ?>
                    </div>
                    <div class="box"></div>
                    <div class="content_device">
                        <?php
                        foreach ($all_pinpai as $val) {
                        ?>
                        <div title="<?=Yii::t('yii','Click and add')?>" style="margin-left: 10px;"><?=$val['vname']?></div>
                        <?php
                        }
                        ?>      
                     </div>
                </li>
                <img src="./images/add1.png" style="border-radius: 50%;" class="add-devs">
                <li style="margin-top:70px;clear: both;">
                <span class='span'><?=Yii::t('yii','remark');?></span>
                    <textarea id="textarea_" style="border:solid 1px #a7b5bc;resize:none;width:454px;height:100px;float:left;font-size:10pt;padding-left:10px;"><?=$remarks['dev_re_name']?></textarea>
                </li>
	    		<li style="clear:both;margin-top:80px;" class="add_heres">
					<input type="button" value="<?=Yii::t('yii','confirm');?>" style="margin-left:100px;margin-right:50px;" class="dev_add_btn" onclick='check()'>
					<input type="reset" value="<?=Yii::t('yii','cancel');?>" class="dev_add_btn return_infor">
				</li>
                <div class="reurn_infor"></div>
            </ul>
        </form>
	</div>
</body>
	</div>
</body>
<script type="text/javascript">
    $(function(){
        // 添加私有属性
        $('.add_siyou_btn').click(function(){
            var siyou = $(this).parent('.add_siyou_all').find('.add_siyou').val();
            var siyou_val = $(this).parent('.add_siyou_all').find('.add_siyou_val').val();
           
            if((siyou)&& (siyou_val)){
                $('.add_siyou_all').before("<li style='clear:both;margin-top:10px;' class='add_siyou_alls'><input type='text' class='input add_si' value='"+siyou+"' style='border: none;width:96px;text-indent:0px;' readonly/><input type='text' class='input add_siyou_vals' value='"+siyou_val+"' style='border:solid 1px #a7b5bc;width: 220px' readonly/><img src='./images/delete1.png' class='siyou_delete_btn' style='width:25px;height:25px;border-radius: 50%;position: relative;top: 10px;left:6px;'></li>");
                $(this).parent('.add_siyou_all').find('.add_siyou').val('');
                $(this).parent('.add_siyou_all').find('.add_siyou_val').val('');
            }else{
                alert('please add relevant information first');
            }
        })
        $(document).on('mouseleave','.dev_brand',function(){
            $(this).find('input').css('background-color','#fff');
            $(this).css('background-color','#fff');
            $(this).find('img').css('display','none');
        })
        $('.content_device div').click(function(){
            var val = $(this).html();
            var nums = $('.mouseover input').length;
                var aa = 0;
                for(var i=0;i<nums;i++){
                    if($('.mouseover input').eq(i).val()== val){
                        aa=1;
                    }
                }
                if(!aa){
                    $('.mouseover').append("<div class='dev_brand'><input type='text' value='"+val+"' class='pinpaizhi attributes'  readonly/><img src='./images/delete1.png'class='delete_attr'></div>")
                } 
        })

         $('.add-devs').click(function(){
            $('.box').css('display','block');
            $('.content_device').css('display','block');
        })

        $('.content_device').mouseleave(function(){
            $('.box').css('display','none');
            $('.content_device').css('display','none');
        })

        $(document).on('mouseover','.dev_brand',function(){
            $(this).find('input').css('background-color','#E5EBEE');
            $(this).find('img').css('display','block');
            $(this).css('background-color','#E5EBEE');
        })
        $(document).on('click','.delete_attr',function(){
            $(this).parent('.dev_brand').remove();
        })
        // 删除私有属性 属性值
        $(document).on('click','.siyou_delete_btn',function(){
            $(this).parent('.add_siyou_alls').remove();
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
                var date ={
                    'att_id':val
                }
                $.ajax({
                    url:'./index.php?r=device/dev_update',
                    type:'get',
                    data:{'del_att':date},
                    dataType:'json',
                    error:function(){
                        alert('失败了');
                    },
                    success:function(msg){
                        if(msg){
                            index.remove();
                        }
                    }
                })
            })
        })  
    })
    function check(){
        var dev_name = $('.dev_name').val();
        var dev_old   = $('.dev_names').val();
        if(!dev_name){
            $('.reurn_infor').css('display','block');
            $('.reurn_infor').html("<?=Yii::t('yii','The name of the device can not be empty')?>");
            return false;
        } 

        var att_brand = $('.pinpaizhi').length;
        if( att_brand < 1 ){
            $('.reurn_infor').css('display','block');
            $('.reurn_infor').html("<?=Yii::t('yii','Brand value can not be empty')?>");
            return false;
        }

        var attribute = new Array();
        var att_len = $('.attributes').length;
        for(var i=0;i<att_len;i++){
            attribute[i] = $('.attributes').eq(i).val();
        }    
        var len = $('.add_si').length;
        if(len > 0 ){
            var arr_siyou = new Array();
            var arr_siyou_val = new Array();
            for(var i =0;i<len;i++){
                arr_siyou[i]=$('.add_si').eq(i).val();
                arr_siyou_val[i]=$('.add_siyou_vals').eq(i).val();
            } 
        }
        var dev_remarks = $('#textarea_').val(); 
        if(arr_siyou){
            var date = {
                'dev_id':dev_old,
                'dev_name':dev_name,
                'attribute':attribute,
                'arr_siyou':arr_siyou,
                'arr_siyou_val':arr_siyou_val,
                'dev_remarks':dev_remarks
            }
        }else{
            var date = {
                'dev_id':dev_old,
                'dev_name':dev_name,
                'attribute':attribute,
                'dev_remarks':dev_remarks
            }
        }
        $.ajax({
            url:'./index.php?r=device/dev_update',
            type:'get',
            data:{'ajax_update_dev':date},
            dataType:'json',
            error:function(){
                alert('失败了');
            },
            success:function(msg){
               if(msg){
                    $('.reurn_infor').css('display','block');
                    $('.reurn_infor').html(msg);
                    return false;
               }else{
                window.location.href = './index.php?r=device/device';
               }
            }
        })      
    }
</script>
</html>