
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>俱乐部</title>

    <link href="/static/mobile/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/static/mobile/jquery/jquery.min.js"></script>
    <script src="/static/mobile/layer/layer.js"></script>
    <script src="/static/mobile/laydate/laydate.js"></script>
</head>
<body>
<div class="heard">
    <span class="span1">战绩查询</span>
    <span class="span2"><a href="javascript:history.back(-1);" class="a1">返回</a></span>
</div>
<div class="main">
    <div class="title"><span class="span1">俱乐部名称:</span></div>
    <div class="club_add">
        <form name="form1" method="post" action="/index.php?m=index&c=index&a=play_log" style="background-color:#ffffff;">

            <input type='hidden' name='type' value="select" />
            <div class="club_main" style="width: 90%">
                <span class="span4" style="width: 24%">查询时间</span><input style="width: 46%" readonly="" class="input1" onClick="laydate()" value="" name="endtime" id="endtime">
            </div>
            <br>
            <div class="club_main" style="margin-bottom:10px; width: 90%">
                <span class="span4" style="width: 24%">查询玩家</span><input  class="input1"   name="select_val" id="select_val" style="width: 46%" value="">
                <input type="submit" name="Submit" class="submit" value="查询" style="width: 15%;float: right;">
            </div>
        </form>

    </div>
    <div style=" height:20px; border-bottom:1px #e1e1e1 solid; background-color:#ffffff; clear:both;"></div>


    <div class="title" style=" font-weight:bold;"><span class="span1">房卡总消耗：0</span></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="120">成员</td>
            <td><div align="center">总赢分</div></td>
            <td><div align="center">大赢家次数</div></td>
            <td><div align="center">消耗房卡</div></td>
        </tr>

<?php if(isset($plays)){
         ?>
        <tr>
            <td width="120"><?php echo $v['homeowner'];?></td>
            <td><div align="center">总赢分</div></td>
            <td><div align="center">大赢家次数</div></td>
            <td><div align="center">消耗房卡</div></td>
        </tr>
        <?php
         } ?>
    </table>





    <div style=" height:20px; border-bottom:1px #e1e1e1 solid; background-color:#ffffff; clear:both;"></div>
</div>
</body>
</html>
