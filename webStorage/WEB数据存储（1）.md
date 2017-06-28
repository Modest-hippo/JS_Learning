# WEB数据存储（1）
> 本次学习是从前端的角度去探究一下web客户端存储的几种方式，主要包括cookie和HTML5存储（localStorage和sessionStorage）

首先我们先来了解一些相关的概念：
- #### 会话（session）：

>  **理解一**：用户开一个浏览器，访问某一个web站点，在这个站点点击多个超链接，访问服务器多个web资源，然后关闭浏览器，整个过程称之为一个会话。


> **理解二**：是一个客户与服务器之间的不中断的请求响应序列。对客户的每个请求，服务器能够识别出请求来自于同一个客户。当一个未知的客户向Web应用程序发送第一个请求时就开始了一个会话。当客户明确结束会话或服务器在一个预定义的时限内不从客户接受任何请求时，会话就结束了。当会话结束后，服务器就忘记了客户以及客户的请求。

- #### 会话跟踪：

> 记录用户一段时间内的逻辑上相关联的不同访问请求个过程叫“会话跟踪”。通过用户在每次对服务请求时的唯一标识，可以跟踪会话。

- #### 无状态协议：

 > 无状态协议是指比如客户获得一张网页之后关闭浏览器，然后再一次启动浏览器，再登陆该网站，但是服务器并不知道客户关闭了一次浏览器。**例如HTTP协议就是无状态协议（Web服务器不保存发送请求的Web浏览器进程的任何信息，包括状态信息，因此在很短时间间隔内再次对服务器发起相同请求时，不会因为第一次服务器已经作出相应而拒绝第二次响应）**。
 
 下面进入正题，我们来分析一下cookie和HTML5存储的一些机制。
 
 

---

 
 ## cookie
 web应用程序是通过HTTP协议来传输数据的，但是我们上面的概念中提到，HTTP是一种无状态的协议，一旦数据的交换完成后，客户端和服务器端的连接就会断开，再次交换数据的时候就要重新建立新的连接，服务器端就没办法从连接上去跟踪会话。
 
 比方说，A买了一件商品放在购物车中，这个动作完成后，当前连接数据交换完成，连接断开，这时候服务器端就没办法去通过连接判断这个商品是A买的还是B买的，即无法判断是A的会话还是B的会话。
 
 这个时候就需要引入cookie，来弥补HTTP作为一种无状态协议的不足。
 
 ### 什么是cookie？
 cookie 是存储于访问者的计算机中的变量。每当同一台计算机通过浏览器请求某个页面时，就会发送这个 cookie。
 
 通俗点讲，**cookie就是服务器端给客户端办理的一个通行证**，每个客户端在访问服务器端的时候都带上自己的通行证（cookie），服务器端就根据这个（cookie）来判断访问者的身份，这就是**cookie的工作原理**。
 
 ### cookie的工作流程
 
 Cookie实际上是一小段的文本信息。客户端请求服务器信息，如果服务器需要记录该用户状态（例如登录场景），就使用response向客户端浏览器颁发一个Cookie。客户端浏览器会把Cookie保存起来。当浏览器再请求该网站时，浏览器把请求的网址连同该Cookie一同提交给服务器。服务器检查该Cookie，以此来辨认用户状态。服务器还可以根据需要修改Cookie的内容。
 
 下面用示意图表示这个过程：
 
 ![image](https://github.com/Modest-hippo/JS_Learning/blob/master/webStorage/img/eg.png?raw=true)
 
 ### cookie的不可跨域名性
 
 Cookie在客户端是由浏览器来管理的。
 
 浏览器判断一个网站是否能操作另一个网站Cookie的依据是域名。Google与Baidu的域名不一样，因此Google不能操作Baidu的Cookie。
 
 注：此处如果对cookie做特殊处理，会产生跨域也能生效的结果。例如：百度文库登录状态下，访问百度百科登录信息仍有效。
 
 ### cookie保存中文
 
 中文与英文字符不同，中文属于Unicode字符，在内存中占4个字符，而英文属于ASCII字符，内存中只占2个字节。
 
 Cookie中使用Unicode字符时需要对Unicode字符进行编码，否则会乱码。
 
 ### cookie的大小和数量
 cookie很小，单个的cookie一般不超过1KB，一般浏览器都限制在4K以内，cookie太大或者太多都会增加服务器的负担，因为每次客户端请求服务器端时都会带上cookie。
 
 ### cookie的生命周期
 cookie的默认周期是会话级别（参考会话概念），但是我们可以手动去设置cookie的有效时间。 单位一般为秒或者毫秒（js中单位是毫秒）
 
 ### cookie的安全隐患
 cookie是不安全的，容易被窃取，通常的解决方案是增加多重校验，例如很多网站或者web应用登录的时候，还要验证短信验证码，这是一种安全防护措施。此处不展开讨论。
 
 ### 那么如何用javascrip设置cookie呢
 
 语法格式：
 
 
```
document.cookie = "name=Value; expires=expiration_time; path=domain_path; domain=domain_name;  secure";
//name=Value 是要存储的信息
//expires=expiration_time 设置cookie的生命周期
//path=domain_path 设置cookie的保存（有效）路径

```


创建一个cookie的例子：

```
<scrip>
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
</scrip>
```



> 参数注意事项：
> 
> 1、名称值对每次只能设置一个，设置多个需要多次设置，作用域相同的会自动连接到一块。
> 
> 2、日期时间注意事项推荐转换成：date.toUTCString() 否则可能会出现浏览器兼容性问题。
> 
> 3、路径有效范围 path=/a/ 与 path=/a 会被认为是不同的路径，保存为不同的文件。但是读取方法是一样的。一般用前者。
> 
> 4、域名一般可省略默认是与设置cookie的域名相同。
> 
> 5、删除cookie的方法就是重新设置cookie把时间修改为过去的任意时间。

### javascript读取cookie

很简单，如下：


```
   document.writeln(document.cookie);

```
cookie可以通过document对象读取，读取结果所有cookie会以字符串形式连接到一块。

## 小结
本次简单介绍了cookie的基本工作原理和一些特性，并对javascrip操作cookie作了简单的介绍，下次会对cookie的应用做一些简单的demo，并且继续学习HTML5存储的方法。
