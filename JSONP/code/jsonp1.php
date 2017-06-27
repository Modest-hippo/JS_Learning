<?php
	//获取回调函数名
	$jsoncallback = $_GET ['jsoncallback'];
	//json数据
	$json_data = '["javascript","php"]';
	//输出jsonp格式的数据
	echo $jsoncallback . "(" . $json_data . ")";
?>