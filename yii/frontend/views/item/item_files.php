<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZWA后台管理系统</title>
    <link rel="stylesheet" type="text/css" href="css/dev_files.css">
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    .file_foreach li:hover{cursor: pointer;}
    .file_re{margin-left:46px;border-bottom: 4px solid #0E8BC5;font-size: 16px;}
    </style>
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script> 
    <script type="text/javascript" src='./js/item_files.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="./utf8-php/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
        <div style="font-size:14px;margin-left:90px;margin-top:60px;" class="con">Are you sure delete this document ?</div>
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
                <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?=Yii::t('yii','home page');?>></a></li>
                <li><a href="./index.php?r=item/item" ondragstart="return false"><?=Yii::t('yii','item management');?>></a></li>
                <li><a href="#" ondragstart="return false"><?=Yii::t('yii','file');?></a></li>
            </ul>
        </div>
         <!-- 按钮 -->
        <div class="device_infor">
            <ul>
                <li style="float:left;margin-left:-36px;" class="common_dec_add common_dec_download">
                    <a href="#" ondragstart="return false"><?=Yii::t('yii','file');?></a>
                </li>
                <li style="float:left;<?php if(!$power[5]){echo 'display:none';}?>" class="common_dec_adds">
                    <a href="#" ondragstart="return false"><?=Yii::t('yii','add');?><?=Yii::t('yii','file');?></a>
                </li>
                <li style="float: right;width:260px;display: block" class="batch_button" >
                    <div style="float: right;margin-right: 3%;margin-bottom: 10px;">
                        <button class="piliang batch_download"><?=Yii::t('yii','batch download');?></button>
                        <button class="piliang batch_delete" style="<?php if(!$power[5]){echo 'display:none';}?>" > <?=Yii::t('yii','batch deleting');?> </button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="dev_add_form item_file_info">
            <table class="tablest">
                <tr style="height: 36px;background-color: #F0F5F7">
                    <th style="width: 30px;"><?=Yii::t('yii','item name');?></th>
                    <th style="width:250px;">
                        <div class="common_add_jibie dev_file_items">
                            <span style="height:34px;border:none;width:180px;float:left;overflow:hidden;padding-left:10px;">
                                <?php if(isset($item[0]['item_name'])){echo $item[0]['item_name'];}?>
                            </span>
                            <img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
                        </div>
                        <select class="common_add_dec_jibie dev_file_item file_dowload_dev">
                            <?php
                            if(isset($item[0]['item_name'])&& $item[0]['item_name']){
                                foreach ($item as $val) {
                                ?>
                                <option value="<?=$val['item_name']?>"><?=$val['item_name']?></option>
                                <?php
                                }}
                            ?>
                        </select>
                    </th>
                </tr>
            </table>
            <table class="tablest add_here_file">
                <tr style="height: 30px;background-color: #F0F5F7;border-bottom: 1px solid #ccc;">
                    <th style="width:60px;"><input type="checkbox" name="" class="both-delete"></th>
                    <th style="width:60px;"><?=Yii::t('yii','order');?></th>
                    <th><?=Yii::t('yii','file name');?></th>
                    <th><?=Yii::t('yii','remark');?></th>
                    <th style="width:60px;"><?=Yii::t('yii','operation');?></th>
                </tr>
                <?php
                    if(isset($files[0]['path'])&& $files[0]['path']){
                        $i=1;
                    foreach ($files as $val){
                    ?>
                    <tr class='file_info' style="height: 30px;">
                        <td><input type="checkbox" name="" class="choice" value="<?=$val['id']?>"></td>
                        <td><?=$i?></td>
                        <td style="color: #83C9F5;min-width: 550px;max-width: 600px;overflow: hidden;"><?=substr($val['path'],34)?></td>
                        <td style="width: 400px;" title="<?=$val['file_remarks']?>"><?php if(mb_strlen($val['file_remarks'],'utf-8')>35){echo mb_substr($val['file_remarks'],0,34).'...';}else{echo $val['file_remarks'];}?></td>
                        <td class="the_last">
                            <img src="./images/dow1.png" style="width:20px;height: 20px;margin-top: 6px;;border-radius: 50%;">
                        </td>
                    </tr>
                        <?php
                        $i++;
                        }
                    }
                ?>
            </table>
        </div>
        <!-- 添加文件 -->
        <form  class="dev_add_form add_item_file"  method="post" enctype="multipart/form-data" style="display: none;">
            <ul>
                <li>
                    <span class='span' style="margin-top: 6px;"><?=Yii::t('yii','item name');?></span>
                     <div class="common_add_jibie file_add_devs">
                            <span><?php if(isset($item[0]['item_name'])){echo $item[0]['item_name'];}?></span>
                            <img src="./images/uew_icon.png" style="float:right;margin-top:8px;">
                        </div>
                        <select class="common_add_dec_jibie file_add_dev" name="add_file_item">
                            <?php
                            if(isset($item[0]['item_name']) && $item[0]['item_name']){
                                foreach ($item as $val) {
                                ?>
                                <option value="<?=$val['item_name']?>"><?=$val['item_name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                </li>
                <li style="margin-top:40px;">
                    <input type="file" style='width:90px;float:left;' class="dev_file" name="file">
                    <input type="text" class="input show_file_names" placeholder='<?=Yii::t('yii','file');?>' readonly >
                    <p style="color: #ccc;float:left;margin-left: 20px"><?=Yii::t('yii','file less than 1GB');?></p>
                </li>
                <div class="dev_file_up"><?=Yii::t('yii','upload file');?></div>
                <span class="file_re"><?=Yii::t('yii','file remark');?></span>
                <!-- 这里是百度编辑器的存放位子 -->
                <script id="editor" type="text/plain" style="width:70%;height:200px;margin-left:46px;"></script>
                <script type="text/javascript">
                    var ue = UE.getEditor('editor');
                </script>
                <li>
                    <input type="submit" class="piliang" value="<?=Yii::t('yii','confirm');?>">
                </li>
            </ul> 
            <input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
        </form>
    </div>
    <div class='tips'><?php if(isset($tips)){echo $tips;}?></div>
</body>
</html>