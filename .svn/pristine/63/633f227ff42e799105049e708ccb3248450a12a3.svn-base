<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>摸摸棋牌推广员系统</title>

</head>
</head>
<body>

<div class="user_info_head" style="margin-top: 10px;font-size: 12px">
    <div class="user_info_cell" style="width: 28%;margin: 0px 0px 0px 10px;height: auto;float: left;">
        <p>昵称:<?php if (mb_strlen($_SESSION['admin']['nick_name'],'utf-8')>7) echo mb_substr($_SESSION['admin']['nick_name'],0,5,'utf-8').'...';else echo $_SESSION['admin']['nick_name']; ?></p>
        <p>剩余房卡:<?php echo (int)$_SESSION['admin']['user_coins'] ?></p>
    </div>
    <div class="user_info_cell" style="width: 42%;margin: 0px 0px;height: auto;float: left;">
        <p>登录账号:<?php echo $_SESSION['admin']['user_name'] ?></p>
        <p><a href='javascript:void(0)'>绑定手机:</a><?php echo $_SESSION['admin']['phone'] ?></p>
    </div>
    <div class="user_info_cell" style="margin: 0px 0px;height: auto;">
        <p>今日售卡: ...</p>
        <p>本月售卡: ...</p>
    </div>
</div>
<div class="navbar" role="navigation" style="padding-left:10px;">

    <a class="btn btn-danger btn-sm" style="width:23%" href="/index.php">活动公告</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=myclub">俱乐部</a>
    <a id="club_zhuan_room_card" class="btn btn-primary btn-sm" style="width:23%" href="javascript:void(0)">赠送房卡</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=c_recharge">房卡充值</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=u_recharge">玩家充值</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=myagent">我的代理</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=myrebate">返利详情</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=sale">售卡统计</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=buy">购卡统计</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=myinfo">我的信息</a>
    <a class="btn btn-primary btn-sm" style="width:23%" href="/index.php?m=index&c=index&a=to_up">申请总代</a>
    <a class="btn btn-danger btn-sm" style="width:23%" href="/index.php?m=index&c=login&a=logout">安全退出</a>
</div>
<script src="/static/mobile/jquery/jquery.min.js"></script>
<script src="/static/mobile/layer/layer.js"></script>
<script src="/static/mobile/laydate/laydate.js"></script>
<script type="text/javascript">
    $('#club_zhuan_room_card').on('click', function(){
        layer.open({
            type: 2,
            title: '赠送房卡',
            skin: 'layui-layer-rim', //加上边框
            shadeClose: true,
            shade: 0.5,
            area: ['75%','60%'],
            scrollbar: false,
            content: '/index.php?m=index&c=index&a=sysmsg'
        });

        $(".layui-layer").css('top','50px');
    });

</script>