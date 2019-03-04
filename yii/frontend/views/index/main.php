<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ZWA后台管理系统</title>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src='./js/jquery-1.10.2.min.js'></script>
    <script type="text/javascript" src='./js/exit.js'></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript">
        //获取相应的语言
        var title1 = "<?=Yii::t('yii','CPU usage');?>";
        var title2 = "<?=Yii::t('yii','Memory usage');?>";
        var cpu_used = "<?=Yii::t('yii','CPU used');?>";
        var cpu_unused = "<?=Yii::t('yii','CPU unused');?>";
        var mem_used = "<?=Yii::t('yii','Memory used');?>";
        var mem_unused = "<?=Yii::t('yii','Memory unused');?>"; 
    var chart;  
    $(document).ready(function () {   
        var cpu = parseFloat($('#hidden1').val());//获得cpu使用情况 
        var mem = parseFloat($('#hidden2').val());//获得内存使用情况  
        if(mem>75){
            if("<?=\Yii::$app->session['power']?>" ==15){
                alert("<?=Yii::t('yii','The memory space is not close enough, please deal with it quickly');?>");
            }
        } 
         if(cpu>75){
            if("<?=\Yii::$app->session['power']?>" ==15){
                alert("<?=Yii::t('yii','CPU is close to use, please deal with it quickly');?>");
            }
        } 
        //内存饼状图1初始化  
        chart = new Highcharts.Chart({  
            chart: {
                renderTo: 'container3',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: title2
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                data: [
                    [mem_unused, 100-mem],
                    [mem_used, mem],
                    
                ]
            }]  
            });  
        //CPU饼状图初始化
        chart = new Highcharts.Chart({ 
            chart: {
                renderTo: 'container4',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: title1
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                data: [
                    [cpu_unused, 100-cpu],
                    [cpu_used, cpu],
                    
                ]
            }]
        });
    }); 
</script> 
</head>
<body>
    <div class="system">
        <table class="table">
            <tr>
                <td><?=Yii::t('yii','System version');?>：</td>
                <td><?=$version?></td>
            </tr>
            <tr>
                <td><?=Yii::t('yii','Runtime length');?>：</td>
                <td><?=$system_itme[0]?><?=Yii::t('yii',' days');?>&nbsp;<?=$system_itme[1]?><?=Yii::t('yii',' hours');?>&nbsp;<?=$system_itme[2]?><?=Yii::t('yii',' minutes');?></td>
            </tr>
            <tr>
                <td><?=Yii::t('yii','System time');?>：</td>
                <td><?=date('Y-m-d H:i:s',time())?></td>
            </tr>
        </table>
         <input type="hidden" id="hidden1" value="<?=$cup_mem[0]?>" />
         <input type="hidden" id="hidden2" value="<?=$cup_mem[1]?>" />
        <hr style="height:1px;border:none;border-top:1px solid #ccc;margin-top:-60px;width:90%;margin:1px auto;" />
        <div class="radio">  
            <div id="container3" style="width: 50%; height: 100%;"></div> 
            <div id="container4" style="width: 50%; height: 100%;"></div>  
        </div>  
    </div>
</body>
</html>



