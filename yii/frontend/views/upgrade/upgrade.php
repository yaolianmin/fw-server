<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ZWA后台管理系统</title>
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    .old_view{margin-top: 20px;float: left;min-width: 100%;margin-left: 50px;overflow: hidden;}
    .now_div li,.old_view li{width: 100px;border: 1px solid #D3DBDE;height: 30px;text-align: center;line-height: 30px;border-radius: 4px;margin-right: 20px;margin-top: 20px;float: left;}  
    .now_div{margin-top: 40px;float: left;min-width: 100%;}
    .upload_yuanmabao,.backups,.upgrade{background-color: #3B95C8;color: #fff;border-radius: 6px;width: 100px;height:34px;}
    .upload_yuanmabao,.backups:hover{cursor: pointer;}
    .upgrade:hover{cursor: pointer;}
    .qianyan{float: left;width:140px;}
    .upload_yuanmabao{position: relative;z-index: 1;}
    .yuanmabao{position: relative;left:-445px;top:20px;z-index: 222;opacity: 0;width:100px;overflow:hidden;height:30px;}
    .now_div .show_file_names{border:none;}
    .tips p{font-size: 9pt;color:#00f;}
    </style>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript">
    $(function(){
        //备份操作
        $('.backups').click(function(){
            window.location.href = './index.php?r=upgrade/upgrade&backups=backups';
        })
         //获得添加文件的上传名称以及限制文件上传
        $('.yuanmabao').change(function(){
             var file = $(".yuanmabao").val();
             var fileName = getFileName(file);
  
            function getFileName(o){
                var pos=o.lastIndexOf("\\");
                return o.substring(pos+1);  
            }
            $('.show_file_names').html(fileName);
            var size = $(".yuanmabao")[0].files[0].size;
            if(size>900000000){
                alert('文件只能下载小于900M的文件');
            }
        });
    })
    </script>
</head>
<body>
    <div style="min-width:980px;font-size: 9pt;overflow:hidden">
       <!--  位置 -->
        <div class="place">
            <span style='margin-left:10px;'><?= Yii::t('yii','position')?>：</span>
            <ul class="placeul">
                <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main" ondragstart="return false"><?= Yii::t('yii','home page')?>></a></li>
                <li><a href="./index.php?r=upgrade/upgrade" ondragstart="return false"><?= Yii::t('yii','upgrade management')?>></a></li>
                <li><a href="#" ondragstart="return false"><?= Yii::t('yii','basic content')?></a></li>
            </ul>
        </div>
        <div class="old_view">
            <div style="max-width:980px;">
                <span class='qianyan'><?= Yii::t('yii','historical version')?></span>
                <ul style="margin-left:140px;float: left;"> 
                    <?php
                    foreach ($history_ver as $val) {
                    ?>
                    <li><?=$val?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="now_div" style="margin-left:50px;">
            <span class='qianyan'><?= Yii::t('yii','current version')?></span>
            <ul style="margin-left:86px;">
                <li><?=$version_now?></li>
            </ul>
        </div>
        <div class="now_div" style="margin-left:50px;">
            <span class='qianyan'><?= Yii::t('yii','database backup')?></span>
            <ul style="float:left;">
                <li class="backups" style="float:left;"><?= Yii::t('yii','backups')?></li>
            </ul>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="now_div" style="margin-left:50px;margin-top:40px;">
                <span class='qianyan'><?= Yii::t('yii','upgrade system')?></span>
                <ul style="float:left;">
                    <input type="file"  name="yuanmabao" class="yuanmabao" />
                    <li class="upload_yuanmabao" style="float:left;"><?= Yii::t('yii','upload file')?></li>
                    <li style="width:300px;" class='show_file_names'><?php if(isset($file_name)){echo $file_name;}?></li>
                </ul>
            </div>
            <div class="now_div" style="margin-left:190px;margin-top:20px;">
                <ul style="float:left;">
                    <input type='submit' class="upgrade" style="float:left;" value="<?= Yii::t('yii','upgrade')?>">
                </ul>
            </div>
            <input type="hidden" id="_csrf" name="<?= \Yii::$app->request->csrfParam;?>" value="<?= \Yii::$app->request->csrfToken?>">
        </form>
        <div style="color:red;margin:30px 40%;float:left;"><?php if(isset($infor)){echo $infor;}?></div>
    </div>
    <div class="tips">
        <p><?= Yii::t('yii','Update instructions')?>：</p>
        <p>1. <?= Yii::t('yii','Before upgrading the website, please backup the database information and notice the information leakage of the database')?>。</p>
        <p>2. <?= Yii::t('yii',"If the update has database fields, tables, and other updates, you need to update the upgrade.sh script in this package, otherwise the database can't complete the update")?>.</p>
    </div>
</body>
</html>