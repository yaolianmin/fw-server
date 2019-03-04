
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
            clearInterval(times); 
            top.location.href = './index.php?r=login/index';
        }
    }
