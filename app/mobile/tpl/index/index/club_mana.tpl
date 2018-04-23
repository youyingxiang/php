<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>俱乐部</title>

    <link href="/static/mobile/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/static/mobile/jquery/jquery.min.js"></script>
    <script src="/static/mobile/layer/layer.js"></script>
</head>
<body>
<div class="heard">
    <span class="span1" style="width:100px; overflow:hidden;height:45px;">俱乐部---号</span>


    <span class="span2">代理账户剩余房卡：<?php echo $_SESSION['admin']['user_coins'];?> <a href="javascript:history.back(-1);" class="a1">返回</a></span>
</div>
<div class="main">
    <div class="title"><span class="span1">俱乐部管理 地区：
	<?php echo $club['c_name'];?></span></div>
    <div class="club_add">
        <div class="club_info">
            <div class="club_1"><img src="http://wx.qlogo.cn/mmopen/vi_32/ta3w0KSBEZsvJiaEbyUtjTtoTFYQO71SSE3ibSVdgw3ArnKN1WAX3ASgiaW1ibtuzian1PSEIkpCfjZPJDuJ9ewUTpw/96" width="70px"></div>
            <div class="club_2"><span class="span15" id="club_name" style="margin-left:0px;"><?php echo $club['c_name'];?></span></div>
            <div class="club_2">俱乐部ID：<?php echo $club['id'];?></div>
            <div class="club_2">
                <span>当前房卡：<?php echo $_SESSION['admin']['user_coins'];?></span>
                <!-- <span class="span15" id="club_room_card">充值</span> -->
            </div>
        </div>

        <div class="club_info">
            <span class="span6"><a href="/index.php?m=index&c=index&a=play_log" class="a2">战绩查询</a></span>



        </div>


    </div>
    <div style=" height:20px; border-bottom:1px #e1e1e1 solid; background-color:#ffffff; clear:both;"></div>
</div>


<div class="foot">
    <div class="txt">
        <span class="span1">1、账户里大于200张房卡才可创建俱乐部；</span></br>
        <span class="span1">2、俱乐部创建后，房卡会直接充入俱乐部账户。</span><br />
        <span class="span1" style="text-align: left;">3、俱乐部仅为方便亲朋好友之间娱乐竞技使用，禁止利用俱乐部进行非法赌博行为，一旦发现我们将在不通知的情况下封停使用。</span>
    </div>
    <div style=" clear:both;"></div>
</div>
<script language="javascript">
    $('#club_room_card').on('click', function(){
        layer.open({
            type: 2,
            title: '转入房卡',
            skin: 'layui-layer-rim', //加上边框
            shadeClose: true,
            shade: 0.5,
            area: ['75%','50%'],
            scrollbar: false,
            content: 'club_room_card.php?club_id=125667'
        });
    });


    $('#club_name').on('click', function(){
        layer.open({
            type: 2,
            title: '修改俱乐部名称',
            skin: 'layui-layer-rim', //加上边框
            shadeClose: true,
            shade: 0.5,
            area: ['75%','50%'],
            scrollbar: false,
            content: 'club_name_edit.php?club_id=125667'
        });
    });

</script>

</body>
</html>
