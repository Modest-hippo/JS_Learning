# JSONP应用
> 本次学习使用了百度搜素提供的API，模拟实现输入框输入提示功能，并且做了简单的小优化。

## 什么是JSONP
**JSONP(JSON with Padding)** 是 json 的一种"使用模式"，可以让网页从别的域名（网站）那获取资料，即跨域读取数据。
上次ajax的学习中提到了**同源策略**的限制下，我们不能使用ajax直接跨域访问、获取数据。

## JSONP应用场景一
- 假设我们现在想去访问，"http://127.0.0.1/jsonp/jsonp1.php?jsoncallback=callbackFunction"
- 我们期望返回的数据是[javascript,php]
- 而从服务端返回到客户端的数据显示为callbackFunction(["javascrip","php"])

我们看下实现的代码：

### 服务端php代码


```
<?php
    //获取回调函数名
    $jsoncallback = $_GET ['jsoncallback'];
    //json数据
    $json_data = '["javascript","php"]';
    //输出jsonp格式的数据
    echo $jsoncallback . "(" . $json_data . ")";
?>
```
### 客户端代码


```
<script type="text/javascript">
	function callbackFunction(val){
		alert(val);
	}
</script>
<script src="http://127.0.0.1/jsonp/jsonp1.php?jsoncallback=callbackFunction"></script>
```
我们获取从服务端传来的数据，通过回调函数直接打印出我们期望的数据。

我们通过在浏览器运行jsonp1.html可以获取到服务端传来的数据，在浏览器上弹出数据。效果图如下：

![image](http://note.youdao.com/favicon.ico)

PS：服务端的环境由warmserver搭建，php文件在后台环境下才能生效。测试本例需要搭建后台环境。

## JSONP应用场景二
我们除了调用后台传给我们的数据之外，还可以**调用第三方提供的API**    实现我们需要的功能，下例中调用了百度搜索提示功能的API，来模拟实现输入框输入提示功能。

以下是案例代码：

1.创建一个输入框和一个div用于存放提示内容

```
<div id="wrap">
	<input type="text" id="searchword" value="" />
	<div id="searchTips"></div>
</div>
```

2.获取元素并且绑定onkeyup事件

```
var searchWd = document.getElementById("searchword");
var searchTips = document.getElementById("searchTips");

searchWd.onkeyup = function() {
    //清空提示
	searchTips.innerHTML = "";	
	//获取输入框内容
	var val = searchWd.value;
	//动态加载
	var searchScript = document.createElement("script");
	searchScript.src = "http://suggestion.baidu.com/su?wd=" + val + "&cb=callbackFunction";
	document.body.appendChild(searchScript);
	//当触发事件时显示提示框
	searchTips.style.display = "block"; 
};
```
3.上面的代码中访问了百度提供的API，我们需要根据API的返回数据去创建一个回调函数，对数据进行处理。

```
function callbackFunction(json) {	
//创建一个无序列表
var searchTipStr = document.createElement("ul");
//将获取的数据填充到列表中
for(i = 0; i < json.s.length; i++) {
	searchTipStr.innerHTML += "<li class=" + "list" + ">" + json.s[i] + "</li>";
}
//快速输入内容时会出现多个提示框的bug，此处处理
if(searchTips.innerHTML == ""){  
	searchTips.appendChild(searchTipStr);
}
//将选中点击后的提示作为输入框的内容
var targetTip = document.getElementsByClassName("list");
for(i = 0; i < targetTip.length; i++) {
	targetTip[i].onclick = function(target) {
		searchWd.value = this.innerText;
		searchTips.style.display = "none"; //选择特定提示项时隐藏提示框
	}
}
//如果输入框为空，隐藏提示框
if(!searchWd.value){
	searchTips.style.display = "none";
}
}
```

上述过程中动态的创建了一个无序列表，使用百度api返回的数据进行填充，实现输入内容时，根据输入内容提示相关内容。
效果图如下：

![image](http://note.youdao.com/favicon.ico)

## 小结
本次学习是延续上次的ajax学习，利用JSONP来解决跨域问题，以上两个案例即为JSONP主要的应用场景，还用到了部分PHP的简单知识。

