# Ajax基础和JSON基础
> 本次学习是对Ajax基础有个较为详细的小总结，同时再次复习了与Ajax息息相关的JSON。

## 什么是Ajax？
英文名称：Asynchronous Javascript And XML 现在这个名称应该翻译成：**异步JS数据交互模块**比较贴切。

## Ajax用来做什么的？
实现前后端或跨页面间的**异步**数据通信。

## Ajax有什么限制？
==同源策略==：
Ajax默认只能在同一个网站（站点）中使用，**不能跨域**， 最好在网站环境下测试。

## Ajax核心的对象属性方法
Ajax其实是对于XMLHttpRequest对象的应用。
XMLHttpRequest的组成如下：
- 成员属性：
1. **==responseText==** 
2. **==readyState==**
3. status
4. responseXML
5. statusText

- 监听事件：
  **==onreadystatechange==**

- 成员方法：

1.  **==open==**(method, url [, async = true [, username = null [, password = null]]]) 
2.  **==send==**(body)
3.  setRequestHeader(name, value)
4.  abort()
5.  getAllResponseHeaders()
6.  getResponseHeader()
---
### 下面用一个简单的demo来详细描述Ajax的各个属性方法
1. 首先创建一个div和一个绑定点击事件的按钮
    
``` 
<div id="box">我是文本</div>
<button id="btn" type="button">点我改变文本内容</button>

```

2. 创建变量并且绑定点击事件
    
```
var box = document.getElementById("box");
var btn = document.getElementById("btn");
btn.onclick = Fn;
```

3. 创建Fn函数，在其中完成ajax的应用过程


```
function Fn() {
//创建XMLHttpRequest对象
//IE8以上、移动端都支持
/*
 局部刷新
 性能更高
 * */
//xhr.readyState: 0 1 2 3 4
var xhr = new XMLHttpRequest(); //0
/*
 * 系统记录状态
 1.open 
 2.send
 3.数据正在传输中
 4.数据接收完毕
 */

/*
 规定：后台返回数据会保存到：xhr.responsText，以字符串形式
 xhr.responsText，返回是XML类型，后台给的必须是XML
 * */
//第二步：当xhr对象有状态改变时候，自动调用该函数
xhr.onreadystatechange = function(data) {
	//console.log(xhr.readyState)
	//console.log(xhr.responseText)
	box.innerHTML = xhr.responseText;
}

//第三步： 向一个地址发出请求   // POST - GET  //此时才开始调用事件
//POST：表单数据提交，用户名密码
//GET：取数据
//Ajax可以同时POST和GET数据到后台
xhr.open("GET", "data.txt"); //会调用xhr.onreadystatechange


//确认发送请求
xhr.send(null); //会调用xhr.onreadystatechange
}
```


4.此时去看页面的状态
![image](img/pic1)