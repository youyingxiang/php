<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>俱乐部</title>

    <link href="/static/mobile/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="heard" style="position: fixed;">
    <span class="span1">俱乐部</span>
    <span class="span2"><a href="../index.php" class="a1">返回</a></span>
</div>
<div class="main" style="padding-bottom: 200px;">
    <div class="title" style="margin-top: 50px;"><span class="span1">我的俱乐部(点击俱乐部名称进入俱乐部)</span></div>
    <div class="club"><span class="span1">俱乐部名称</span></div>
    <?php foreach($clubs as $v){ ?>
        <div class="club" style="padding:0px 0px 15px 0px;"><span class="span3" style="padding:10px 10px 10px 10px;"><a href="/index.php?m=index&c=index&a=club&club_id=<?php echo $v['id'];?>" class="a2"><?php echo $v['c_name']?></a></span></div>
    <?php } ?>

    <div style=" height:20px; border-bottom:1px #e1e1e1 solid; background-color:#ffffff; clear:both;"></div>
</div>
<div class="foot">
    <div class="add_club"><a href="index.php?m=index&c=index&a=club_add" class="a2">创建俱乐部</a></div>
    <div class="txt">
        <span class="span1">1、账户里大于200张房卡才可创建俱乐部；</span><br />
        <span class="span1">2、俱乐部创建后，房卡会直接充入俱乐部账户；</span><br />
        <span class="span1" style="text-align: left;">3、俱乐部仅为方便亲朋好友之间娱乐竞技使用，禁止利用俱乐部进行非法赌博行为，一旦发现我们将在不通知的情况下封停使用。</span>
    </div>
    <div style=" clear:both;"></div>
</div>



</body>
</html>
