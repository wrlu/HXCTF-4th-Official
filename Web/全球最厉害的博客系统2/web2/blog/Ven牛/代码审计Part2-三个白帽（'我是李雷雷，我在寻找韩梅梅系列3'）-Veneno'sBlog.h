<!DOCTYPE HTML>

<html>
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
<meta content="yes" name="apple-mobile-web-app-capable">
<title>代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog</title>
<link href="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/highslide.css" rel="stylesheet" type="text/css"/>
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="http://www.venenof.com/usr/plugins/HighSlide/css/highslide-ie6.css" />
<![endif]-->
<meta content="勉强算个代码审计：打开连接：" name="description">
<script type="text/javascript">
(function () {
    window.TypechoComment = {
        dom : function (id) {
            return document.getElementById(id);
        },
    
        create : function (tag, attr) {
            var el = document.createElement(tag);
        
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
        
            return el;
        },

        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom('respond-post-102'), input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];

            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });

                form.appendChild(input);
            }

            input.setAttribute('value', coid);

            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id' : 'comment-form-place-holder'
                });

                response.parentNode.insertBefore(holder, response);
            }

            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';

            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }

            return false;
        },

        cancelReply : function () {
            var response = this.dom('respond-post-102'),
            holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

            if (null != input) {
                input.parentNode.removeChild(input);
            }

            if (null == holder) {
                return true;
            }

            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
})();
</script>
<script type="text/javascript">
(function () {
    var event = document.addEventListener ? {
        add: 'addEventListener',
        focus: 'focus',
        load: 'DOMContentLoaded'
    } : {
        add: 'attachEvent',
        focus: 'onfocus',
        load: 'onload'
    };

    document[event.add](event.load, function () {
        var r = document.getElementById('respond-post-102');

        if (null != r) {
            var forms = r.getElementsByTagName('form');
            if (forms.length > 0) {
                var f = forms[0], textarea = f.getElementsByTagName('textarea')[0], added = false;

                if (null != textarea && 'text' == textarea.name) {
                    textarea[event.add](event.focus, function () {
                        if (!added) {
                            var input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = '_';
                            input.value = (function () {
    var _GjWVH = //'JKZ'
'JKZ'+//'A'
'e0a'+//'Y'
'4'+//'yBg'
'4e0'+//'nRB'
'e'+'358'//'kj8'
+'2a'//'42'
+//'PQv'
'17'+'b6'//'Q'
+'c2'//'t'
+'10'//'H'
+'b'//'o'
+'8'//'ox'
+'961'//'9'
+'f6d'//'RQp'
+/* 'hz'//'hz' */''+//'1'
'54'+//'r'
'5', _IZ2JZWr = [[0,3]];
    
    for (var i = 0; i < _IZ2JZWr.length; i ++) {
        _GjWVH = _GjWVH.substring(0, _IZ2JZWr[i][0]) + _GjWVH.substring(_IZ2JZWr[i][1]);
    }

    return _GjWVH;
})();

                            f.appendChild(input);
                            added = true;
                        }
                    });
                }
            }
        }
    });
})();
</script><link href="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/style.css" rel="stylesheet"/>
<link href="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/prism.css" rel="stylesheet"/>
<link href="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/iconfont.css" rel="stylesheet"/>
<link href="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/player.css" rel="stylesheet"/>
<link href="" rel="shortcut icon"/>
</meta></meta></head>
<body>
<header>
<div class="main">
<div class="intro"> <img class="intro-logo" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/veneno.jpeg"/> <span class="intro-sitename"><a href="http://www.venenof.com/">
      Veneno's Blog      </a></span> <span class="intro-siteinfo">
      The harder you struggle today,the more glorious you will be tomorrow.      </span> <span class="social"> <a href="" target="_blank"><i class="iconfont icon-qq"></i></a> <a href="" target="_blank"><i class="iconfont icon-mail"></i></a> <a href="" target="_blank"><i class="iconfont icon-weibo"></i></a> <a href="" target="_blank"><i class="iconfont icon-github"></i></a> </span> </div>
<nav>
<div class="collapse">
<i class="iconfont icon-menu"></i></div>
<ul class="bar">
<li><a href="http://www.venenof.com/">首页</a></li>
<li><a href="http://www.venenof.com/index.php/archive.html">
          时间          </a></li>
<li><a href="http://www.venenof.com/index.php/link.html">
          友链          </a></li>
<li><a href="http://www.venenof.com/index.php/Veneno.html">
          About Me          </a></li>
</ul>
</nav>
<a class="icon-search" id="btnChange" onclick="searchbox();"></a>
<div id="search" style="display:none">
<div class="icon-close" onclick="searchbox();"></div>
<form action="/index.php" class="search" id="searchform" method="get" name="form">
<input autofocus="autofocus" id="searchText" name="s" placeholder="输入关键字查找" style="margin-top:25%" type="search"/>
</form>
</div>
</div></header><content>
<div class="main">
<div class="article">
<div class="article-title">代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'）</div>
<small class="article-time">发表于： <time datetime="2016-05-15T21:00:00+00:00" itemprop="datePublished">2016-05-15</time> | 分类： <a href="http://www.venenof.com/index.php/category/CTF/">CTF</a> | <a href="http://www.venenof.com/index.php/archives/102/#comments" itemprop="discussionUrl">评论：1 </a> | 阅读：194</small>
<div class="article-content">
<p>勉强算个代码审计：<br/>
打开连接：</p>
<blockquote>
<p><img alt="1.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/3354070293.jpg"/></p>
</blockquote>
<!--more-->
<p>随手admin登陆下，提示失败，于是注册一个用户，注册成功后，发现可以修改资料：</p>
<blockquote>
<p><img alt="2.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/796481560.jpg"/></p>
</blockquote>
<p>然后fuzz下了目录，发现有admin.php，访问，提示Error, your power is too low.猜测需要power=1，即update，抓包走一波即可提升权限为admin：</p>
<blockquote>
<p><img alt="3.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/2903131586.jpg"/><br/>
<img alt="4.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/290246674.jpg"/></p>
</blockquote>
<p>打开test.php:</p>
<blockquote>
<p><img alt="5.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/1517938634.jpg"/></p>
</blockquote>
<p>发现不知道/../authcode.php，这时候我们发现download页面f是下载参数，而在admin页面，m是目录参数，于是我们可以利用m参数去跨目录：<br/>
http://408ffe393d342329a.jie.sangebaimao.com/admin.php?m=../file/download&amp;f=admin.php<br/>
admin.php的代码：</p>
<pre><code>&lt;?php 
require_once('inc/common.php');
if ($_SESSION['power'] == 1){
    if (isset($_GET['m'])) {
        $model = "model/" . $_GET['m'] . ".php";
        if (!is_file($model)){
            echo "Model not exist!";
            exit; 
        } else {
            include_once($model);
        }
    }
} else {
    exit("Error, your power is too low.");
}
?&gt;
</code></pre>
<p>然后看下authcode.php以及flag.php：<br/>
发现是DZ的加密算法，出题人把iv的向量由四改为了三，更容易爆破出来：</p>
<pre><code>&lt;?php
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {  
   // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙  
   $ckey_length = 3;  
     
   // 密匙  
   $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);  
     
   // 密匙a会参与加解密  
   $keya = md5(substr($key, 0, 16));  
   // 密匙b会用来做数据完整性验证  
   $keyb = md5(substr($key, 16, 16));  
   // 密匙c用于变化生成的密文  
   $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
substr(hash('sha256', microtime()), -$ckey_length)) : '';  
   // 参与运算的密匙  
   $cryptkey = $keya.md5($keya.$keyc);  
   $key_length = strlen($cryptkey);  
   // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性  
   // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
   $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : 
sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
   $string_length = strlen($string);  
   $result = '';  
   $box = range(0, 255);  
   $rndkey = array();  
   // 产生密匙簿  
   for($i = 0; $i &lt;= 255; $i++) {  
     $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
   }  
   // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
   for($j = $i = 0; $i &lt; 256; $i++) {  
     $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
     $tmp = $box[$i];  
     $box[$i] = $box[$j];  
     $box[$j] = $tmp;  
   }  
   // 核心加解密部分  
   for($a = $j = $i = 0; $i &lt; $string_length; $i++) {  
     $a = ($a + 1) % 256;  
     $j = ($j + $box[$a]) % 256;  
     $tmp = $box[$a];  
     $box[$a] = $box[$j];  
     $box[$j] = $tmp;  
     // 从密匙簿得出密匙进行异或，再转成字符  
     $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
   }  
   if($operation == 'DECODE') {  
     // substr($result, 0, 10) == 0 验证数据有效性  
     // substr($result, 0, 10) - time() &gt; 0 验证数据有效性  
     // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性  
     // 验证数据有效性，请看未加密明文的格式  
     if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() &gt; 0) &amp;&amp; 
substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
       return substr($result, 26);  
     } else {  
       return '';  
     }  
   } else {  
     // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
     // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  
     return $keyc.str_replace('=', '', base64_encode($result));  
   }  
}
?&gt;
</code></pre>
<p>flag.php:</p>
<pre><code>&lt;?php
require_once('inc/common.php');
require_once('authcode.php');
echo "where is the flag?";
$flag = authcode('4da1JE+SVphprnaoZJlJTsXKmi+hkEFTlkrbShMA6Uq5npWavTX8vFAh3yGYDf6OcbZePTLJIT+rB2sHzmPO2tuVQ','DECODE',$authkey);
?&gt;
</code></pre>
<p>于是根据DZ的iv缺陷，一旦IV出现重复，就意味着XOR KEY也重复了，因此可以实施“Reused Key Attack(<a href="http://www.2cto.com/os/201111/111425.html">参考文章</a>)”。于是现在给了：</p>
<blockquote>
<p><img alt="6.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/3482678492.jpg"/></p>
</blockquote>
<p>我们先写脚本去爆破一下相同的iv的向量的test密文：</p>
<pre><code>import requests
import base64
url1='http://408ffe393d342329a.jie.sangebaimao.com/file/test.php'
url2='http://408ffe393d342329a.jie.sangebaimao.com/index.php'
a = requests.session()
data1 = {'username':'Ven','password':'Veneno','submit':'login'}
b = a.post(url2,data = data1);
c = a.get(url1)
while c.content[0:3]!='4da':
    c = a.get(url1)
    print c.content
print c.content
</code></pre>
<p>然后很快就可以得到相同密文：<br/>
4da1JE+SVphprnaoZMwdTdAfTy5hRlRHlspMHwQWPdxqCgEY/nV4uAQwTCcJjyge8HOK6eYL9/28l61TX/dNzAIf3R7wDnRqqFsj5chZoMsnjjvy1UbpdRiEg==，所以去掉iv向量逐位异或就可以了：</p>
<pre><code>import base64
tes='1JE+SVphprnaoZMwdTdAfTy5hRlRHlspMHwQWPdxqCgEY/nV4uAQwTCcJjyge8HOK6eYL9/28l61TX/dNzAIf3R7wDnRqqFsj5chZoMsnjjvy1UbpdRiEg=='
fla='1JE+SVphprnaoZJlJTsXKmi+hkEFTlkrbShMA6Uq5npWavTX8vFAh3yGYDf6OcbZePTLJIT+rB2sHzmPO2tuVQ=='
test='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'
tesa=base64.b64decode(tes)[26:]
flaa=base64.b64decode(fla)[26:]
flab=''
for i in range(0,len(flaa)):
    flab+=chr(ord(flaa[i])^ord(tesa[i])^ord(test[i]))
    print flab
</code></pre>
<p>最终flag：</p>
<blockquote>
<p><img alt="7.jpg" src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/1388839944.jpg"/></p>
</blockquote>
</div>
<div class="post-footer">
<div class=" post-tags">
<div class="tag"> 标签: none</div>
<div class="post-nav">
<li class="prev"><a href="http://www.venenof.com/index.php/archives/90/" title="代码审计Part1-三个白帽（'条条大路通罗马系列1'）">代码审计Part1-三个白帽（'条条大路通罗马系列1'）</a></li>
<li class="next">
<a href="http://www.venenof.com/index.php/archives/106/" title="代码审计Part3-三个白帽（'条条大路通罗马系列2'）">代码审计Part3-三个白帽（'条条大路通罗马系列2'）</a></li>
</div>
</div>
</div>
</div></div></content>
<div id="comments">
<!-- Duoshuo Comment BEGIN -->
<div class="ds-thread" data-author-key="1" data-thread-key="102" data-title="代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'）" data-url=""></div>
<script type="text/javascript">
	var duoshuoQuery = {short_name:"veneno1",theme:"dark"};
	(function() {
		var ds = document.createElement("script");
		ds.type = "text/javascript";ds.async = true;
		ds.src = "http://static.duoshuo.com/embed.js";
		ds.charset = "UTF-8";
		(document.getElementsByTagName("head")[0] 
		|| document.getElementsByTagName("body")[0]).appendChild(ds);
	})();
	</script>
<!-- Duoshuo Comment END -->
</div>
</body></html>
﻿<div class="willerce">
<div> </div>
<!--播放器 -->
<div id="QPlayer">
<div id="pContent">
<div id="player"> <span class="cover"></span>
<div class="ctrl">
<div class="musicTag marquee"> <strong>Title</strong> <span> - </span> <span class="artist">Artist</span> </div>
<div class="progress">
<div class="timer left">0:00</div>
<div class="contr">
<div class="rewind icon"></div>
<div class="playback icon"></div>
<div class="fastforward icon"></div>
</div>
<div class="right">
<div class="liebiao icon"></div>
</div>
</div>
</div>
</div>
<div class="ssBtn">
<div class="adf"></div>
</div>
</div>
<ol id="playlist">
</ol>
</div>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/jquery.min.js"></script>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/jquery.marquee.min.js"></script>
<script>
	var	playlist = [	
];
  var isRotate = 1;
  var autoplay = ;  
</script>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/player.js"></script>
<script>
function bgChange(){
	var lis= $('.lib');
	for(var i=0; i<lis.length; i+=2)
	lis[i].style.background = 'rgba(246, 246, 246, 0.5)';
}
window.onload = bgChange;
</script>
<!--<div class="qrcode">
  <img src="" width="126" height="136" alt=""> </div>-->
<footer>
<p> <a href="" target="_blank">网站地图</a><br/>
Copyright © 2015-2017 <a href="http://www.venenof.com/">
    Veneno's Blog    
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/highslide.packed.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
hs.graphicsDir = "http://www.venenof.com/usr/plugins/HighSlide/css/graphics/";
hs.fadeInOut = true;
hs.transitions = ["expand","crossfade"];
hs.lang.creditsText = "&copy; www.venenof.com";
hs.lang.creditsTitle = "&copy; www.venenof.com";
hs.creditsHref = "http://www.venenof.com/index.php";
hs.creditsPosition = "top left";
hs.lang={
loadingText : "载入中...",
loadingTitle : "取消",
closeText : "关闭",
closeTitle : "关闭 (Esc)",
previousText : "上一张",
previousTitle : "上一张 (←键)",
nextText : "下一张",
nextTitle : "下一张 (→键)",
moveTitle : "移动",
moveText : "移动",
playText : "播放",
playTitle : "幻灯播放 (空格键)",
pauseText : "暂停",
pauseTitle : "幻灯暂停 (空格键)",
number : "第%1张 共%2张",
restoreTitle :	"点击关闭或拖动. 左右方向键切换图片. ",
fullExpandTitle : "完整尺寸",
fullExpandText :  "原大"
};
//]]>
</script>
<script>
document.body.addEventListener('copy', function (e) {
    if (window.getSelection().toString() && window.getSelection().toString().length > 10) {
        setClipboardText(e);
    }
}); 
function setClipboardText(event) {
    var clipboardData = event.clipboardData || window.clipboardData;
    if (clipboardData) {
        event.preventDefault();
        var htmlData = ''
            + '著作权归作者所有。<br>'
            + '商业转载请联系作者获得授权，非商业转载请注明出处。<br>'
            + '作者：Veneno<br>'
            + '链接：' + window.location.href + '<br>'
            + '来源：http://www.venenof.com/<br><br>'
            + window.getSelection().toString();
        var textData = ''
            + '著作权归作者所有。\n'
            + '商业转载请联系作者获得授权，非商业转载请注明出处。\n'
            + '作者：Veneno\n'
            + '链接：' + window.location.href + '\n'
            + '来源：http://www.venenof.com/\n\n'
            + window.getSelection().toString();
        clipboardData.setData('text/html', htmlData);
        clipboardData.setData('text/plain',textData);
    }
}
</script>
</a></p></footer>
<div class="toTop">TOP</div>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/all.js"></script>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/jquery.js"></script>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/prism.js"></script>
<script src="./代码审计Part2-三个白帽（'我是李雷雷，我在寻找韩梅梅系列3'） - Veneno's Blog/search.js"></script>
</div>

