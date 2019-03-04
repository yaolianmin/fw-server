<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ZWA后台管理系统</title>
</head>
<frameset rows="88,*" cols="*" frameborder="no" border="0" framespacing="0">
	<!--头部页面-->
    <frame src="./index.php?r=index/top" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
    <frameset cols="200,*" frameborder="no" border="0" framespacing="0">
    	<!--左侧的下拉框菜单-->
	    <frame src="./index.php?r=index/left" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" border='1'/>
	    <!--右侧的内容部分-->
	    <frame src="./index.php?r=index/main" name="rightFrame" id="rightFrame" title="rightFrame" />
    </frameset>
</frameset>
</html>