<?php
use yii\widgets\LinkPager;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ZWA后台管理系统</title>
    <link href="css/device.css" rel="stylesheet" type="text/css" />
    <link href="css/position.css" rel="stylesheet" type="text/css" />
    <link href="css/mask.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript" src='./js/item.js'></script>
</head>
<body>
    <!-- 遮罩层 -->
    <div class='user_shadow'></div >
    <div class="user_shadow_content">
        <div style="font-size:14px;margin-left:20px;margin-top:60px;"><?=Yii::t('yii','Delete the item, the file will also be deleted, confirm the deletion ?');?></div>
        <div>
            <input type="submit" value="<?=Yii::t('yii','confirm');?>" class="user_shadow_sure" />
            <input type="reset" value="<?=Yii::t('yii','cancel');?>" class="user_shadow_quxiao" />
        </div>
    </div>
    <!-- 遮罩层结束 -->
    <div style="min-width:980px;font-size: 9pt;">
       <!--  位置 -->
        <div class="place">
            <span style='margin-left:10px;'><?=Yii::t('yii','position');?>：</span>
            <ul class="placeul">
                <li style="display:<?php if(\Yii::$app->session['power'] <14){echo 'none';}?>"><a href="./index.php?r=index/main"><?=Yii::t('yii','home page');?>></a></li>
                <li><a href="./index.php?r=item/item"><?=Yii::t('yii','item management');?>></a></li>
                <li><a href="#"><?=Yii::t('yii','basic content');?></a></li>
            </ul>
        </div>
        <!--  按钮搜索区 -->
        <div class= 'device-tool'>
            <ul class="device-left">
                <li class="first" style="margin-left:10px;display:<?php if(!$power[3]){echo 'none';}?>">
                    <a href="./index.php?r=item/item_add" ondragstart="return false">
                        <img src="./images/add1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;" />
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','add item');?></span>
                    </a>
                </li>
                <li class="first" <?php if(!$power[2]){echo "style='margin-left:10px;'";}?>>
                    <a href="./index.php?r=item/common_item" ondragstart="return false">
                        <img src="./images/add1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;" />
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','common item');?></span>
                    </a>
                </li>
                <li class="first" <?php if(!$power[4]){echo "style='display:none;'";}?>>
                    <a href="./index.php?r=item/item_files" ondragstart="return false">
                        <img src="./images/add1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;" />
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','file');?></span>
                    </a>
                </li>
                <li id="device-delete" style="margin-left:6px;display:<?php if(!$power[3]){echo 'none';}?>">
                        <img src="./images/delete1.png" alt=""  style="margin-top:6px;float:left;border-radius: 50%;"/>
                        <span style='float:left;margin-top:10px;margin-left:4px;'><?=Yii::t('yii','batch deleting');?></span>
                </li>
            </ul>
            <ul class="device-right" >
                <form action="" method="get">
                <li>
                    <span><?=Yii::t('yii','input item name');?></span>
                    <input type="text" class="search" name="search_item_name" value="<?php if($search_name){echo $search_name;}?>" />
                </li>
                <li>
                    <input type="submit"  value="<?=Yii::t('yii','search');?>"  class="sou" />
                </li>
                <input type="hidden" name="r" value="item/item">
                </form>
            </ul>
        </div>
        <!-- 机种表格区 -->
        <table style="border:solid 1px #cbcbcb;width:99%;margin-left:10px;margin-top:10px;;border-collapse:collapse;border-spacing:0;" class="tablest">
            <tr>
                <th style="margin-left:10px;width:60px;" >
                    <input type="checkbox" class="both" />
                </th>
                <th><?=Yii::t('yii','order');?></th>
                <th><?=Yii::t('yii','item name');?></th>
                <th><?=Yii::t('yii','item manager');?></th>
                <th><?=Yii::t('yii','client of item');?></th>
                <th><?=Yii::t('yii','device');?></th>
                <th <?php if(!$power[3]){echo "style='display:none;'";}?>><?=Yii::t('yii','edit');?></th>
                <th><a href="#"><?=Yii::t('yii','details');?></a></th>
            </tr>
            <?php
            $i=1;
            foreach ($it_infor as $val) {
            ?>
            <tr>
                <td style="margin-left:10px;">
                    <input type="checkbox" class="choice" value="<?=$val['iid']?>"  />
                </td>
                <td><?=$i?></td>
                <td title='<?=$val['item_name']?>'><?php if(strlen($val['item_name'])>26){echo mb_substr($val['item_name'],0,25,'UTF-8').'...';}else{echo $val['item_name'];}?></td>
                <td title='<?php if(isset($val['manager'])){echo $val['manager'];}?>'><?php if(isset($val['manager'])){if(strlen($val['manager'])>30){echo mb_substr($val['manager'],0,30,'UTF-8').'...';}else{echo $val['manager'];}}?></td>
                <td title='<?php if(isset($val['item_user'])){echo $val['item_user'];}?>'><?php if(isset($val['item_user'])){if(strlen($val['item_user'])>26){echo mb_substr($val['item_user'],0,26,'UTF-8').'...';}else{echo $val['item_user'];}}?></td>
                <td title='<?=$val['device']?>'><?php if(strlen($val['device'])>60){echo mb_substr($val['device'],0,59,'UTF-8').'...';}else{echo $val['device'];}?></td>
                <td <?php if(!$power[3]){echo "style='display:none;'";}?>>
                    <a href="./index.php?r=item/item_update&item_id=<?=$val['iid']?>"><?=Yii::t('yii','update');?></a>
                </td>
                <td title="<?=Yii::t('yii','click');?><?=Yii::t('yii','look');?><?=Yii::t('yii','details');?>">
                    <a href="./index.php?r=item/item_look&item_id=<?=$val['iid']?>">...</a>
                </td>
            </tr> 
            <?php 
            $i++;  
            }
            ?> 
        </table>
        <footer class='pages'>
            <div style="font-style:normal;margin-left:12px; margin-top:6px;">
                <?=Yii::t('yii','total have');?>&nbsp;<i><?=$page->totalCount?></i>&nbsp;<?=Yii::t('yii','strip');?> <?=Yii::t('yii','record');?> <?=Yii::t('yii','current display');?><?=Yii::t('yii','No.');?>&nbsp;<i><?= $page->getPage()+1;?></i>&nbsp;<?=Yii::t('yii','page');?>
            </div>
            <div style="float:right;margin-top:-16px;">
                <?= LinkPager::widget(['pagination' => $page, 'maxButtonCount' =>5]);?>
            </div>
        </footer>
</body>
</html>