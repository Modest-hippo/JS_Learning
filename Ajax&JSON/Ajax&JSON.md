# Ajax基础和JSON基础
> 本次学习是对Ajax基础有个较为详细的小总结，同时再次复习了与Ajax息息相关的JSON。

## 什么是Ajax？
英文名称：Asynchronous Javascript And XML 现在这个名称应该翻译成：**异步JS数据交互模块**比较贴切。

## Ajax用来做什么的？
实现前后端或跨页面间的**异步**数据通信。

## Ajax有什么限制？

**==同源策略==** ：
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

![image](img/pic1.png)
 
5.点击按钮后的状态

![image](img/pic1.png)

可以看到文本内容已经被替换成data.txt文本中的内容，这个txt文件充当的就是数据库的角色，此时这个过程只有这个div中的内容刷新了，页面其它位置实际上是没有刷新的，这就是 **==局部刷新==** 。

前面的代码注释中提到了，后台返回数据会保存到：xhr.responsText，以字符串形式。那么我们需要从这些字符串形式的数据中获取自己所需要的信息，例如我们要获取某一个属性的值，该怎么去处理这些数据呢？所以接下来我们要复习与Ajax息息相关的JSON。

## 什么是JSON？
JSON(JavaScript Object Notation) 翻译：JavaScript 对象表示法，简单来说就是一种数据格式。

## JSON核心作用
用于数据交换（例如前后台数据交换，或跨站点数据交换）

## JSON语法规则
JSON的属性：无论是字符串还是数字都必须加双引号。  

JSON 值可以是：
1. 数字（整数或浮点数）
2. 字符串（必须在双引号中）
3. 逻辑值（true 或 false）
4. 数组（在方括号中）
5. 对象（在花括号中）
6. null

注意：跟JS一般对象比 **==没有方法==** ，属性必须加双引号，注意不能是单引号。


```
var div = {
    "width":"100px",
    "height":"200px",
    "offsetWidth":220,
    "5":68
};
```
上面的div即是一个标准的JSON对象

如果改写成下面这样：

```
var div = {
    "width":"100px",
    "height":"200px",
    "offsetWidth":220,
    "5":68,
    "say":function(){
        alert('666');
    }
};

```
那么此时的div不再是JSON对象，而是一个普通对象，应为它包含了一个say方法，而JSON中是不能有方法的。

那如果要把这个改写的div转化成JSON对象该怎么做呢？

还有一个问题就是，我们通常在传输的过程中通常使用的是JSON字符串而非JSON对象，那么JSON字符串和JSON对象之间又该如何转换呢？

这就要用到下面JSON的两大核心方法。

## JSON对象常用方法
### JSON.parese(jsonString)
这个方法是将JSON语法规则的字符串转换成JSON对象。

例如：

```
var div = `{
	"width": "100px",
	"height": "50px"
}`;
```
我们重新定义了div为一个JSON字符串，注意上面这个div，是由 ==**``**== 括起来的内容，这个反引号是什么意思呢？

反引号与单、双引号功能相同，但是有一个不同就是，在javascrip中，由反引号括起来的字符串内容可以换行，而单双引号不行。

此时我们开始转换这个div，变成一个JSON对象。

```
var jsn = JSON.parse(div);
console.log(div.width); //undefined
console.log(jsn.width); //100px
```
此时可以看到，转换后的jsn对象可以去到width属性值，而无法通过div去去到这个值，因为div是一个字符串，不是对象。

### JSON.stringify(jsonString)

这个方法是把JS对象转化成符合JSON标准的字符串。

此时我们再定义一个普通对象：

```
var div1 = {
	width: "100px",
	height: "50px",
	say:function(){
		alert(1);
	}
};
```
注意，div1中是包含了一个say方法的，它是一个普通的对象。

此时我们调用JSON.stringify()方法对它进行转换：

```
div1 = JSON.stringify(div1);
console.log(div1); //{"width":"100px","height":"50px"}
```

我们看这个打印结果，可以看到，属性名都加上了双引号，转换成了标准的JSON对象，并且原来对象中的say()方法被直接丢掉了，因为JSON是不要方法的，**==JSON是用键值对描述数据的，不绑定功能==**。

## 小结
本次介绍了Ajax的基本使用和各种属性、方法，还介绍了JSON这种流行的数据传输格式。关于Ajax的跨域问题并没有详细探讨，后续讲单独讨论。

