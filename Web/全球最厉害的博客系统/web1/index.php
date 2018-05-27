<?php

define("IN_BLOG_PLATFORM", true);

require_once ("./libs/auth.php");
require_once ("./libs/sql.php");

list($state, $mysqli) = get_connect();
!$state && die("数据库连接失败");

?>



<html>
<head>
    <link href="./static/css/global-compat.css" rel="stylesheet" type="text/css" >
    <link href="./static/css/table.css" rel="stylesheet" type="text/css">
    <link href="./static/css/bee.css" rel="stylesheet" type="text/css" >
    <link href="./static/css/break.css" rel="stylesheet" type="text/css" >
    <link href="./static/css/buttons.css" rel="stylesheet" type="text/css">
    <link href="./static/images/head.jpg" rel="icon" type="image/x-icon">
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <title>Blog Site</title>
    <style>
        .left_list{
            background-color:rgb(213, 226, 239);color:rgb(88, 99, 118);cursor:auto;display:inline-block;font-family:PingFangSC-Light, 'helvetica neue', 'hiragino sans gb', tahoma, 'microsoft yahei ui', 'microsoft yahei', simsun, sans-serif;font-size:14px;font-weight:bold;height:36px;line-height:36px;margin-left:25px;vertical-align:middle;-webkit-font-smoothing:antialiased;
        }

        .icon-search{
            background-color:rgba(0, 0, 0, 0);
            background-image:url("/static/images/search_2.png");
            height:50px;
            width:50px;
            position:absolute;
            top:6px;
            right:6px;
            background-size:35px 35px;
            display:block;
        }

        .new_window{

            background-color:rgba(255, 255, 255, 0.901961);
            color:rgb(51, 51, 51);
            display:none;
            font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Hiragino Sans GB', 'WenQuanYi Micro Hei', Verdana, Aril, sans-serif;
            font-size:30px;
            height:100%;
            position:absolute;
            top: 0px;
            width:100%;
        }

        #search_form{
            color:rgb(51, 51, 51);
            display:block;
            font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Hiragino Sans GB', 'WenQuanYi Micro Hei', Verdana, Aril, sans-serif;
            font-size:15px;
            height:384px;
            line-height:27px;
            margin-bottom:0px;
            margin-left:0px;
            margin-right:0px;
            margin-top:0px;
            padding-bottom:0px;
            padding-left:0px;
            padding-right:0px;
            padding-top:0px;
            width:1349px;

        }

        #searchText{
            box-sizing:border-box;
            color:rgb(0, 0, 0);
            cursor:auto;
            display:inline-block;
            font-size:20px;
            font-stretch:normal;
            font-style:normal;
            font-variant:normal;
            font-weight:normal;
            padding-left: 3%;
            height:47px;
            letter-spacing:normal;
            line-height:normal;
            margin-top: 20%;
            margin-left:15%;
            margin-right:15%;
            width:70%;
            word-spacing:0px;
            writing-mode:horizontal-tb;
        }
    </style>

</head>
<body>


<div id="pageWrapper">
    <div class="qc-header-nav" id="topnav">
        <div class="qc-nav-logo">
            <a class="qc-logo-inner" href="./index.php" title="heheda">
                <img src="./static/images/logo_3.png">
            </a>
        </div>
        <div class="qc-nav-service">
            <ul class="qc-service-inner">
            </ul>
        </div>
        <ul class="qc-nav-user">
            <li><a>Hello! <?php echo htmlspecialchars($_SESSION['username'])?></a></li>
            <li style="height: 49px;">
                <div class="qc-user-panel"></div>
                <div class="tip-notice-win"></div>
            </li>
            <li><a href="./api.php?cmd=logout">注销</a></li>
        </ul>
    </div>



    <div class="container" id="container" style="top: 50px; left: 0px;">
        <div class="aside" id="sidebar">
            <div class="menu">
                <h2>
                    <span>博客列表</span>
                </h2>
                <hr class="line-mod">
                <dl class="menu-list">
                    <?php
                    list($state, $blog) = get_blog($mysqli);
                    !$state && die($blog);
                    foreach ($blog as $blog_name){
                        echo "<dd>
                                    <a class='menu-lv2 xie' href='javascript:void(0);' onclick='generate_list(this)'><span>{$blog_name}</span></a>
                                  </dd>";
                    }
                    ?>
                </dl>
            </div>
        </div>

        <div class="main" id="appArea">
            <div class="manage-area cvm">
                <div class="manage-area-title">
                    <h2 id="article_number">
                        <?php
                        echo INIT_BLOG." 共收录文章".get_article_number($mysqli, INIT_BLOG)."篇";
                        ?>
                    </h2>
                    <a class="icon-search" id="btnChange" href="javascript:;" onclick="searchbox();"></a>
                </div>
                <div class="manage-area-main">
                    <div data-grid-panel class="tc-15-table-panel">
                        <div data-grid-head class="tc-15-table-fixed-head" style="width:auto;padding-right: 0px; display: block; ">
                            <table class="tc-15-table-box" style="min-width: 100%; width: 988px;">
                                <colgroup>
                                    <col style="width: 700px;">
                                    <col style="width: 100px;">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th  class="text-left">
                                        <div><span class="text-overflow" title="文章名">文章名</span></div>
                                    </th>
                                    <th  class="text-left">
                                        <div><span class="text-overflow" title="大小">大小</span></div>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!--table表与表头分开div大概是为了设置不同的样式-->
                        <div data-grid-body="" class="tc-15-table-fixed-body" style="min-height: 350px; height: auto; ">
                            <table style="min-width: 100%; width: 988px;" class="tc-15-table-box">
                                <colgroup>
                                    <col style="width: 700px;">
                                    <col style="width: 100px;">
                                </colgroup>
                                <tbody id="xie">

                                <?php
                                list($state, $retu) = get_article($mysqli, 'Ben师傅');

                                !$state && die($retu);
                                $retu = json_decode($retu);

                                foreach ($retu as $article) {
                                    echo "   
                                                <tr class=\"item-row\">
                                                <td class=\"text-left\">
                                                    <div>
                                                        <a href={$article[1]}>
                                                            {$article[0]}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class=\"text-left\">
                                                    <div>{$article[2]}KB</div>
                                                </td>
                                                </tr>
                                            ";
                                }
                                ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="new_window" id="search">

    <button onclick="searchbox()" class="button button-glow button-rounded button-raised button-primary" style="position: absolute;margin-bottom: 0px; margin-right: 0px; top: 30px; right: 50px;">Back</button>

    <form name="form" method="get" action="javascript:;" id="search_form">
        <input name="s" placeholder="输入关键字" autofocus="autofocus" type="search" id="searchText">
        <button onclick="search(this)" class="button  button-pill button-primary" style="position: absolute;margin-bottom: 0px; margin-right: 0px; top: 60%; right: 45%; left: 45%">Search</button>
    </form>


</div>

<div class="new_window" id="state">

    <button onclick="statebox()" class="button button-glow button-rounded button-raised button-primary" style="position: absolute;margin-bottom: 0px; margin-right: 0px; top: 30px; right: 50px;">Back</button>

    <!--计划的模式：一直是1s刷新一次，但是没有点开的时候，不会更新表，只是更新小标签。激活的时候将会更新面板上的数据。如何判定是否激活呢？？？通过判断下其属性就可以！！-->
    <div class="plans" id="table">
    </div>

</div>



</body>
</html>

<script>
    function generate_list(woshi){
        //传过来的是DOM标签，需要转化成jquery操作
        var $haha = $(woshi);

        var $xie = $("#xie");
        $xie.children().remove();

        $.get("./api.php?cmd=get_article_list&blog_name="+$haha.find("span").html(),
            function(data, textstates, fn){
                if (textstates == "success"){

                    for (i in data){
                        var $tr = $(
                            '<tr class="item-row">' +
                            '<td class="text-left">' +
                            '<div>' +
                            '<a href="'+data[i][1]+'">' +
                            data[i][0] +
                            '</a>' +
                            '</div>' +
                            '</td>' +
                            '<td class="text-left">' +
                            '<div>'+data[i][2]+'KB</div>' +
                            ' </td>' +
                            ' </tr>'
                        );

                        $xie.append($tr);
                    }

                    //修改对应的标题
                    var $article_number = $("#article_number");
                    var str = $haha.find("span").html() + " 共收录文章" + data.length + "篇";
                    $article_number.html(str);
                }
            });

    }

    function searchbox(){
        var divDisp = document.getElementById("search").style.display;
        if (divDisp == "block"){
            document.getElementById("search").style.display = "none";
        } else {
            document.getElementById("search").style.display = "block";
        }
    }

    function statebox(){
        var divDisp = document.getElementById("state").style.display;
        if (divDisp == "block"){
            document.getElementById("state").style.display = "none";
        } else {
            document.getElementById("state").style.display = "block";
        }
    }

    function search(woshi){
        searchbox();

        var searchText = $(woshi).prev().val();

        $.get("./api.php?cmd=search&searchText="+searchText,
            function(data, textstates, fn){
                if (textstates == "success"){

                    var $xie = $("#xie");
                    $xie.children().remove();

                    for (i in data){
                        var $tr = $(
                            '<tr class="item-row">' +
                            '<td class="text-left">' +
                            '<div>' +
                            '<a href="'+data[i][1]+'">' +
                            data[i][0] +
                            '</a>' +
                            '</div>' +
                            '</td>' +
                            '<td class="text-left">' +
                            '<div>'+data[i][2]+'KB</div>' +
                            ' </td>' +
                            ' </tr>'
                        );

                        $xie.append($tr);
                    }

                    //修改对应的标题
                    var $article_number = $("#article_number");
                    var str = searchText + " 共搜索到" + data.length + "篇";
                    $article_number.html(str);
                }
            });

    }


    function delete_success(woshi){

        var blog = $(woshi).prev().prev().prev().prev().html();
        $.get("./api_admin.php?cmd=deletecrawlerstate&blog="+blog,
            function(data, textstates, fn){});
    }

    //轮询函数
    function poll() {
        $(document).ready(function () {

            $.ajax({
                type: "GET",
                url: "./api.php?cmd=get_state",
                dataType: "json",
                success: function (data) {

                    if ( $("#state").css("display") == "none"){
                        //没有打开详情页面的时候，只更新邮件通知值
                        $("#remind").html(data.length);

                    } else{
                        //打开详情页面的时候，更新图表的值
                        var $table = $("#table");
                        $table.children().remove();

                        for (i in data){
                            var display = '';
                            if (data[i][5] == "running"){
                                display = ' disabled="disabled" ';
                            }

                            var $tr = $(
                                '<div class="plan">'+
                                '<h2 class="plan-title">'+data[i][0]+'</h2>'+
                                '<p class="plan-state">'+data[i][3]+'<span>/'+data[i][2]+'</span></p>'+
                                '<ul class="plan-features">'+
                                '<li><strong>'+data[i][4]+'</strong> New article</li>'+
                                '<li><strong>'+data[i][1]+'</strong> Page Total</li>'+
                                '</ul>'+
                                '<h2 class="plan-bottom">'+data[i][5]+'</h2>'+
                                '<button class="button button-raised button-caution" onclick="delete_success(this)" '+ display +'>Delete</button>'+
                                '</div>'
                            );
                            $table.append($tr);
                        }


                    }
                }
            });
        });
    }
    //循环执行
    setInterval('poll()', 1000);


</script>


