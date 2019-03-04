<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZWA后台管理系统</title>
    <link rel="stylesheet" href="css/dev_files.css" type="text/css" >
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script> 
    <script type="text/javascript" src='./js/dev_files.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/lang/zh-cn/zh-cn.js"></script>
</head> 
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
        <div class="con">Are you sure delete this document ?</div>
        <div>
            <input type="submit" value="<?=Yii::t('yii','confirm');?>" class="user_shadow_sure" />
            <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_shadow_quxiao" />
        </div>
    </div>
    <div class="dev_file_top">
       <!--  位置 -->
        <div class="place">
            <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
            <ul class="placeul">
                <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
                <li><a href="./index.php?r=device/device"><?=Yii::t('yii','device management');?>></a></li>
                <li><a href="#"><?=Yii::t('yii','file');?></a></li>
            </ul>
        </div>
        <!-- 按钮 -->
        <div class="device_infor">
            <ul>
                <li style="float:left;margin-left:-36px;" class="common_dec_add common_dec_download common_dec_btn">
                    <a href="#" ondragstart="return false"><?=Yii::t('yii','file');?></a>
                </li>
                <li style="float:left;<?php if(!$power[5]){echo 'display:none';}?>" class="common_dec_btn common_dec_adds">
                    <a href="#" ondragstart="return false"><?=Yii::t('yii','add file');?></a>
                </li>
                <li style="float:left;<?php if(!$power[5]){echo 'display:none';}?>" class="common_dec_btn common_dec_update">
                    <a href="#" ondragstart="return false" ><?=Yii::t('yii','add version');?></a>
                </li>
                <li class="batch_button">
                    <div>
                        <button class="piliang batch_download"><?=Yii::t('yii','batch download');?></button>
                        <button class="piliang batch_delete" style="<?php if(!$power[5]){echo 'display:none';}?>" > <?=Yii::t('yii','batch deleting');?> </button>
                    </div>
                </li>
            </ul>
        </div>
        <!--批量按钮-->
        <div class="dev_add_form file_download_del">
            <table class="tablest" cellspacing="0" cellpadding="0">
                <tr style="height: 36px;background-color: #F0F5F7">
                    <th style="width: 130px;"><?=Yii::t('yii','device name');?></th>
                    <th style="width:250px;">
                        <div class="common_add_jibie dev_file_devices">
                            <span><?php if(isset($dev_pin_ban['device'][0]['name'])){echo $dev_pin_ban['device'][0]['name'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie dev_file_device file_dowload_dev">
                            <?php
                            if(isset($dev_pin_ban['device'][0]['name']) && $dev_pin_ban['device'][0]['name']){
                                foreach ($dev_pin_ban['device'] as $val) {
                                ?>
                                <option value="<?=$val['name']?>"><?=$val['name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </th>
                    <th style="width: 100px;"><?=Yii::t('yii','brand');?></th>
                    <th style="width: 290px;">
                        <div class="common_add_jibie file_dowload_pins">
                            <span><?php if(isset($dev_pin_ban['pinpai'][0]['vname'])){echo $dev_pin_ban['pinpai'][0]['vname'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie file_dowload_pin">
                            <?php
                            if(isset($dev_pin_ban['pinpai'][0]['vname']) &&$dev_pin_ban['pinpai'][0]['vname']){
                                foreach ($dev_pin_ban['pinpai'] as $val) {
                                ?>
                                <option value="<?=$val['vname']?>"><?=$val['vname']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </th>
                    <th style="width: 100px;"><?=Yii::t('yii','version');?></th>
                    <th>
                        <div class="common_add_jibie file_dowload_vers">
                            <span><?php if(isset($dev_pin_ban['version'][0]['version_name'])){echo $dev_pin_ban['version'][0]['version_name'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie file_dowload_ver">
                            <?php
                            if(isset($dev_pin_ban['version'][0]['version_name']) && $dev_pin_ban['version'][0]['version_name']){
                                foreach ($dev_pin_ban['version'] as $val) {
                                ?>
                                <option value="<?=$val['version_name']?>"><?=$val['version_name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </th>
                </tr>
            </table>
            <table  class="tablest add_here_file" cellspacing="0" cellpadding="0">
                <tr class="table_tr">
                    <th style="width:60px;"><input type="checkbox" name="" class="both-delete"></th>
                    <th style="width:60px;"><?=Yii::t('yii','order');?></th>
                    <th><?=Yii::t('yii','file name');?></th>
                    <th><?=Yii::t('yii','remark');?></th>
                    <th style="width:60px;"><?=Yii::t('yii','operation');?></th>
                </tr>
                <?php
                if(isset($dev_pin_ban['file'][0]['path']) && $dev_pin_ban['file'][0]['path']){ $i=1;
                    foreach ($dev_pin_ban['file'] as $val) {
                ?>
                <tr class='file_info' style="height: 34px;">
                    <td><input type="checkbox" name="" class="choice" value="<?=$val['id']?>"></td>
                    <td><?=$i?></td>
                    <td class="file_path"><?=substr($val['path'],34)?></td>
                    <td style="width: 400px;" title="<?=$val['file_remarks']?>"><?php if(mb_strlen($val['file_remarks'],'utf-8')>35){echo mb_substr($val['file_remarks'],0,34).'...';}else{echo $val['file_remarks'];}?></td>
                    <td class="the_last">
                        <img src="./images/dow1.png">
                    </td>
                </tr>
                <?php
                   $i++; }
                }
                ?>
            </table>
        </div>
        <!-- 添加文件 -->
        <form  class="dev_add_form add_file" style="display:none;" method="post" enctype="multipart/form-data" onsubmit="return chk()">
            <ul>
                <li>
                    <span class='span'><?=Yii::t('yii','device name');?></span>
                     <div class="common_add_jibie file_add_devs">
                            <span><?php if(isset($dev_pin_ban['device'][0]['name'])){echo $dev_pin_ban['device'][0]['name'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie file_add_dev" name="file_add_dev">
                            <?php
                            if(isset($dev_pin_ban['device'][0]['name']) &&$dev_pin_ban['device'][0]['name']){
                                foreach ($dev_pin_ban['device'] as $val) {
                                ?>
                                <option value="<?=$val['name']?>"><?=$val['name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                </li>
                <li>
                    <span class='span'><?=Yii::t('yii','brand');?></span>
                    <div class="common_add_jibie file_add_pins">
                            <span><?php if(isset($dev_pin_ban['pinpai'][0]['vname'])){echo $dev_pin_ban['pinpai'][0]['vname'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie file_add_pin" name="file_add_pin">
                            <?php
                            if(isset($dev_pin_ban['pinpai'][0]['vname']) && $dev_pin_ban['pinpai'][0]['vname']){
                                foreach ($dev_pin_ban['pinpai'] as $val) {
                                ?>
                                <option value="<?=$val['vname']?>"><?=$val['vname']?></option>
                                <?php
                            }}
                            ?>
                        </select>
                </li>
                 <li>
                    <span class='span'><?=Yii::t('yii','version');?></span>
                    <div class="common_add_jibie file_add_vers">
                        <span><?php if(isset($dev_pin_ban['version'][0]['version_name'])){echo $dev_pin_ban['version'][0]['version_name'];}?></span>
                        <img src="./images/uew_icon.png">
                    </div>
                        <select class="common_add_dec_jibie file_add_ver" name="file_add_ver" id="dev_file_version">
                        <?php
                        if(isset($dev_pin_ban['version'][0]['version_name']) &&$dev_pin_ban['version'][0]['version_name']){
                            foreach ($dev_pin_ban['version'] as $val) {
                            ?>
                            <option value="<?=$val['version_name']?>"><?=$val['version_name']?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </li>
                <li style="margin-top:40px;">
                    <input type="file" class="dev_file" name="file">
                    <input type="text" class="input show_file_names" placeholder='<?=Yii::t('yii','file');?>' readonly >
                    <p style="color: #ccc;float:left;margin-left: 20px"><?=Yii::t('yii','file less than 1GB');?></p>
                </li>
                <div class="dev_file_up"><?=Yii::t('yii','upload file');?></div>
                <span class="file_remar"><?=Yii::t('yii','file remark');?></span>
                <!-- 这里是百度编辑器的存放位子 -->
                <script id="editor" type="text/plain" style="width:70%;height:200px;margin-left:46px;"></script>
                <script type="text/javascript">
                    var ue = UE.getEditor('editor');
                </script>
                <!-- 百度编辑器结束 -->
                <li>
                    <input type="submit" class="piliang" value="<?=Yii::t('yii','confirm');?>">
                </li>
            </ul> 
            <input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
        </form>
        <!-- 添加版本 -->
        <form  class="dev_add_form update_file" method="get" style="display:none;">
            <input type="hidden" name="r" value="device/dev_files">
            <ul>
                <li>
                    <span class='span'><?=Yii::t('yii','device name');?></span>
                    <div class="common_add_jibie version_add_devs">
                            <span class="table_tr" style="background-color: #fff;"><?php if(isset($dev_pin_ban['device'][0]['name'])){echo $dev_pin_ban['device'][0]['name'];}?></span>
                            <img src="./images/uew_icon.png" >
                        </div>
                        <select class="common_add_dec_jibie version_add_dev" name="ver_add_dev">
                            <?php
                            if(isset($dev_pin_ban['device'][0]['name']) && $dev_pin_ban['device'][0]['name']){
                                foreach ($dev_pin_ban['device'] as $val) {
                                ?>
                                <option value="<?=$val['name']?>"><?=$val['name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                </li>
                <li>
                    <span class='span'><?=Yii::t('yii','brand');?></span>
                    <div class="common_add_jibie version_add_pins">
                            <span><?php if(isset($dev_pin_ban['pinpai'][0]['vname'])){echo $dev_pin_ban['pinpai'][0]['vname'];}?></span>
                            <img src="./images/uew_icon.png">
                        </div>
                        <select class="common_add_dec_jibie version_add_pin" name="ver_add_pin">
                            <?php
                            if(isset($dev_pin_ban['pinpai'][0]['vname']) && $dev_pin_ban['pinpai'][0]['vname']){
                                foreach ($dev_pin_ban['pinpai'] as $val) {
                                ?>
                                <option value="<?=$val['vname']?>"><?=$val['vname']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                </li>
                 <li>
                    <span class='span'><?=Yii::t('yii','version');?></span>
                    <input type="text" class='input' name="version_name" style="width:280px;float: left;">
                    <p style="float: left;margin-left: 20px;color: #ccc;"><?=Yii::t('yii','within 25 characters');?></p>
                </li>
                <li>
                    <input type="submit" class="piliang" value="<?=Yii::t('yii','confirm');?>" style="margin-left: 112px;">
                    <input type="resert" class="piliang" value="<?=Yii::t('yii','cancel');?>">
                </li>
            </ul>
        </form> 
    </div>
    <div class='tips'><?php if(isset($re_version)){echo $re_version;}?></div>
</body>
</html>