
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>俱乐部</title>

    <link href="/static/mobile/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/static/mobile/assets/jquery/jquery.min.js"></script>
    <script src="/static/mobile/layer/layer.js"></script>
    <script src="/static/mobile/laydate/laydate.js"></script>
</head>
<script>
    alert = function(name){
        var iframe = document.createElement("IFRAME");
        iframe.style.display="none";
        iframe.setAttribute("src", 'data:text/plain,');
        document.documentElement.appendChild(iframe);
        window.frames[0].window.alert(name);
        iframe.parentNode.removeChild(iframe);
    }
</script>
<body>
<div class="heard">
    <span class="span1">俱乐部</span>
    <span class="span2"><a href="index.php" class="a1">返回</a></span>
    <span class="span3" style="float: right;margin-right: 10px;" id="club_zhuan_room_card">赠送房卡</span>
</div>
<div class="main">
    <div class="title"><span class="span1" style="color:red;">摸摸游戏俱乐部活动</span></div>
    <div class="daikai"><span class="span1" style="line-height:27px;">
		活动时间：3天</br>
            01月23日零点-01月25日二十四点</br>
            活动内容</br>
            <!--<span style="color:red">代理创建：</span></br>
            1、首次创建，免费（有且仅有第一次）</br>
            2、送88张房卡</br>
            <3、若解散俱乐部（没有免费机会）</br>
            &nbsp;&nbsp;&nbsp;&nbsp;消耗房卡大于等于88张，则直接返还俱乐部剩余房卡</br>
            &nbsp;&nbsp;&nbsp;&nbsp;消耗房卡小于88张，则扣除88张后，返还剩余房卡</br>-->
		<span style="color:red">新开代理充值后创建</span></br>
            1、免费可以创建（有且仅有第一次）</br>
            2、送188房卡</br>
            <!--3、若解散俱乐部（没有免费机会）</br>
            &nbsp;&nbsp;&nbsp;&nbsp;俱乐部总消耗房卡大于等于188张，则直接返还俱乐部剩余房卡</br>
            &nbsp;&nbsp;&nbsp;&nbsp;消耗房卡小于188张，则扣除188张后，返还剩余房卡</br>-->
	</span></div>
    <div class="title"><span class="span1">创建俱乐部</span></div>
    <form name="form1" id="form1" method="post" action="index.php?m=index&c=index&a=club_add" onsubmit="return pd();">
        <input type="hidden" value="<?php echo $_SESSION['csrf_token'];?>" name='csrf_token'>
        <div class="club_add">
            <div class="club_main">
                <span class="span4">选择游戏包</span>
                <select name="app" class="input1">
                    <option value="0">请先选择一个游戏包</option>
                    <?php foreach($game as $v){?>
                        <?php if ($v['gamename'] == '湖南大厅') continue;?>
                        <?php if (empty($have_clud)){?>
                            <option value="<?php echo $v['gamepath'];?>"><?php echo $v['gamename'];?></option>
                        <?php } else {?>
                            <?php if (empty(in_array($v['gamepath'], $have_clud))){?>
                                <?php if ($v['gamepath'] == 'game_hunanmajiang'||empty(array_intersect($have_clud,['game_paodekuai','game_niuniu','game_hunanzipainew']))){?>
                                <option value="<?php echo $v['gamepath'];?>"><?php echo $v['gamename'];?></option>
                                <?php }?>
                            <?php }?>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="club_add">
            <div class="club_main">
                <span class="span4">俱乐部名称</span><input name="club_name" type="text" class="input1" id="club_name" >
            </div>
        </div>




        <div class="club_add">
            <div class="club_main">
                <span class="span4">绑定游戏ID</span><input name="player_id" type="text" class="input1"  value=""  style="width:98px;" id="player_id"><span class="span5" id="check_player_id">检测ID</span>
            </div>
            <div style="clear:both;"></div>

            <div class="submit1">
                <input name="onclick" type="text" class="input1" id="onclick" value="0" style="display:none;">
                <input type="submit" name="Submit" id="submit" class="submit" value="创建俱乐部">
            </div>
            <div class="txt" style="text-align: left;padding-left: 10px;padding-right: 10px;width: auto;">
                1、账户里大于100张房卡才可创建俱乐部；</br>
                2、俱乐部创建后，房卡会直接充入俱乐部账户。</br>
                3、俱乐部仅为方便亲朋好友之间娱乐竞技使用，禁止利用俱乐部进行非法赌博行为，一旦发现我们将在不通知的情况下封停使用。
            </div>
        </div>
    </form>





    <div style=" height:20px; border-bottom:1px #e1e1e1 solid; background-color:#ffffff; clear:both;"></div>
</div>
<script language="javascript">
    $('#check_player_id').on('click', function(){
        var player_id = $("input[name='player_id']").val();
        var app_id = $("input[name='app_id']").val();
        var club_name = $("input[name='club_name']").val();
        if(app_id==0){
            alert("请先选择一个游戏包！");
            return false;
        }
        if(club_name==""){
            alert("请填写您的俱乐部名称！");
            return false;
        }
        if(player_id==""){
            alert("绑定的游戏ID不能为空");
            return false;
        }
        //location='club_add.php?player_id='+player_id+'&app_id='+app_id+'&club_name='+club_name+'&action=check_player&onclick=1';

        $.ajax({
            url:"/index.php?m=index&c=index&a=check_user&gid="+player_id,
            type:"get",
            success:function (res){
                if(res == 1){
                    alert('真实的用户');
                    <?php $click = 2;?>;
                } else if(res == 2) {
                    alert('系统错误')
                } else {
                    alert('用户不存在');
                }
            }
        })

        /*
         layer.open({
         type: 2,
         title: '绑定游戏ID',
         skin: 'layui-layer-rim', //加上边框
         shadeClose: true,
         shade: 0.5,
         area: ['75%','50%'],
         scrollbar: false,
         content: 'bd_player_id.php?player_id='+player_id+'&app_id='+app_id
         });*/
    });

</script>


<script type="text/javascript">
    function pd()
    {
        var club_name = $('#club_name').val();
        var special_char = ['元','角','分'];
        var flag = 1;
        console.log(flag);
        $(special_char).each(function(){
            console.log(this);
            if(club_name.indexOf(this)>0){
                alert('俱乐部名称不能含有"'+this+'"');
                flag = 0;
                return false;
            }
        });
        console.log(flag);
        if(0 === flag){
            return false;
        }
        var onclick_num = <?php echo $click?>;
        if(onclick_num!=2){
            alert("请先点击检测id！");
            return false;
        }

    }
    $('#club_zhuan_room_card').on('click', function(){
        layer.open({
            type: 2,
            title: '转入房卡',
            skin: 'layui-layer-rim', //加上边框
            shadeClose: true,
            shade: 1,
            area: ['75%','60%'],
            scrollbar: false,
            content: 'club_zhuan_room_card.php'
        });
    });

</script>
</body>
</html>
