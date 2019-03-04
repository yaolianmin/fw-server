$(function(){

/**
* 主页显示模块操作
*/
$('.main').click(function(){
    $('.show').html('主页');

    window.location.href="/index.php?r=index/main";
})

/**
* 日志管理模块
*/
$('.log_management').click(function(){
    window.location.href="/index.php?r=log/log"; 

})

/**
* 文件管理模块
*/
$('#document').click(function(){
    window.location.href="/index.php?r=file_management/file_management"; 

})

/**
* 用户管理模块
*/
$('.user_management').click(function(){
    window.location.href="/index.php?r=user-management/user-management"; 

})

/**
* 项目管理模块
*/
$('.project_management').click(function(){
    window.location.href="/index.php?r=project-management/project-management"; 

})

/**
* 管理模块操作
*/
$('.manage_').mouseover(function(){
	$('.items').show();
    $(this).css('backgroung-color','rgba(51,81,188,0.6)');


})

$('.items').mouseleave(function(){
	$('.items').hide();
})
	

/**
* 当前用户名
*/
$('.user-centos').click(function(){
    window.location.href="/index.php?r=user-center/user-center";
})

/**
*  用户中心模块
*/

$('.user_center').click(function(){
	window.location.href="/index.php?r=user-center/user-center";
})



/**
* 升级管理
*
*/
$('.upgrades').click(function(){
    window.location.href="/index.php?r=upgrade/upgrade";
})

/**
* 机种管理模块
*/
$('.device').click(function(){
   window.location.href = '/index.php?r=device/device';
})

//点击退出按钮，传递至到后台
$('.quit').click(function(){

    window.location.href="/index.php?r=index/main&action=exit"; //传递到主页面

})





/*****************检测用户半小时有没有操作*****************/
    var ii = 0;
    var times = setInterval(add_time,1000);
    document.onmousemove = function(){ //鼠标移动，代表进行操作
         clearInterval(times); 
         ii=0;
         times = setInterval(add_time,1000);
    }  

    function add_time(){
        ii++;
        if(ii>1800){ //检测是否超过半个小时
            window.location.href="/index.php?r=index/main&action=exit";
        }
    }



     
})


