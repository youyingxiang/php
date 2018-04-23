
<?php  if(isset($public)){ $this->display($public) ;} ?>


<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-bullhorn"></i>房卡充值</li>
            </ol>
        </div>
        <div class="col-lg-12">

            <div class="panel panel-warning">
                <form id="form1" name="form1" method="post" action="index.php?m=index&c=order&a=up_order">
                    <div style="background-color:#f1f1f1;color:#777980;padding-left:10px; border-bottom: solid 1px #DADADA; width:100%; line-height:40px;" id="play_type1"><img src="zfb_ioc.png" width="25"> 支付宝 <i class="fa fa-check-square-o green" id="play_img1" style="float:right; margin-top:13px; margin-right:10px;"></i></div>
                    <div style="color:#777980;padding-left:10px; width:100%; line-height:40px;" id="play_type2"><img src="wx.jpg" width="25"> 微信支付 <i class="fa fa-check-square-o green" id="play_img2" style="float:right; margin-top:13px; margin-right:10px; display:none"></i></div>

                    <div style="color:#777980;padding-left:10px; border-bottom: solid 1px #DADADA; width:100%; line-height:40px;">请选择充值金额</div>
                    <?php foreach($goods as $k => $v){ ?>
                    <div style="color:#777980;padding-left:10px; border-bottom: solid 1px #DADADA; width:100%; line-height:40px;" id="kk<?php echo $k;?>"><?php echo $v['room_cards'];?>房卡&nbsp&nbsp(1张=<?php echo sprintf("%.2f",round($v['amount']/$v['room_cards'],2));?>元)<span style="color:#FD621F;float:right; padding-right:10px;">￥<?php echo $v['amount'];?></span></div>

                    <?php } ?>
                    <div style="color:#777980;padding-left:10px; border-bottom: solid 10px #DADADA; width:100%; line-height:40px; color:red;" id="mor1"><?php echo $goods[0]['amount'].'元='.$goods[0]['room_cards'].'房卡';?></div>
                    <input type="text" name="room_card" id="room_card" value="2" style="display:none;" />
                    <input type="text" name="top_up" id="top_up" value="0.1" style="display:none;" />
                    <input type="text" name="channel_id" id="channel_id" value="0" style="display:none;" />
                    <input type="text" name="play_type" id="play_type" value="2" style="display:none;" />
                  
                    <input type="submit" name="button" id="button" value="确认支付" style=" width:100%;color:#ffffff; background-color:#00AAEF;border:1px solid #00AAEF;padding-top:10px;padding-bottom:10px;position:fixed; bottom:0; left:0px; z-index:0;"/>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/mobile/assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>
<script>
    $(document).ready(function(){

        $("#kk0").click(function(){
            var text = "<?php echo $goods[0]['amount'].'元='.$goods[0]['room_cards'].'房卡';?>";
            var room_card = "<?php echo $goods[0]['room_cards']?>";
            var top_up = "<?php echo $goods[0]['amount']?>";
            $("#mor1").text(text);
            $("#room_card").val(room_card);
            $("#top_up").val(top_up);
            $("#kk0").css("background-color","#6EC33B");
            $("#kk1").css("background-color","#ffffff");
            $("#kk2").css("background-color","#ffffff");
            $("#kk3").css("background-color","#ffffff");
            // $("#kk4").css("background-color","#ffffff");
            // $("#kk5").css("background-color","#ffffff");
        });
        $("#kk1").click(function(){
            var text = "<?php echo $goods[1]['amount'].'元='.$goods[1]['room_cards'].'房卡';?>";
            var room_card = "<?php echo $goods[1]['room_cards']?>";
            var top_up = "<?php echo $goods[1]['amount']?>";
            $("#mor1").text(text);
            $("#room_card").val(room_card);
            $("#top_up").val(top_up);
            $("#kk0").css("background-color","#ffffff");
            $("#kk1").css("background-color","#6EC33B");
            $("#kk2").css("background-color","#ffffff");
            $("#kk3").css("background-color","#ffffff");
            // $("#kk4").css("background-color","#ffffff");
            // $("#kk5").css("background-color","#ffffff");
        });
        $("#kk2").click(function(){
            var text = "<?php echo $goods[2]['amount'].'元='.$goods[2]['room_cards'].'房卡';?>";
            var room_card = "<?php echo $goods[2]['room_cards']?>";
            var top_up = "<?php echo $goods[2]['amount']?>";
            $("#mor1").text(text);
            $("#room_card").val(room_card);
            $("#top_up").val(top_up);
            $("#kk0").css("background-color","#ffffff");
            $("#kk1").css("background-color","#ffffff");
            $("#kk2").css("background-color","#6EC33B");
            $("#kk3").css("background-color","#ffffff");
            // $("#kk4").css("background-color","#ffffff");
            // $("#kk5").css("background-color","#ffffff");
        });
        $("#kk3").click(function(){
            var text = "<?php echo $goods[3]['amount'].'元='.$goods[3]['room_cards'].'房卡';?>";
            var room_card = "<?php echo $goods[3]['room_cards']?>";
            var top_up = "<?php echo $goods[3]['amount']?>";
            $("#mor1").text(text);
            $("#room_card").val(room_card);
            $("#top_up").val(top_up);
            $("#kk0").css("background-color","#ffffff");
            $("#kk1").css("background-color","#ffffff");
            $("#kk2").css("background-color","#ffffff");
            $("#kk3").css("background-color","#6EC33B");
            // $("#kk4").css("background-color","#ffffff");
            // $("#kk5").css("background-color","#ffffff");
        });

     

        $("#kk0").trigger('click');

        $("#play_type1").click(function(){
            $("#play_img1").css("display","block");
            $("#play_img2").css("display","none");
            $("#play_type1").css("background-color","#f1f1f1");
            $("#play_type2").css("background-color","#ffffff");
            $("#play_type").val('2');
            $("#form1").attr("action","index.php?m=index&c=order&a=up_order");
        });
        $("#play_type2").click(function(){
            $("#play_img1").css("display","none");
            $("#play_img2").css("display","block");
            $("#play_type2").css("background-color","#f1f1f1");
            $("#play_type1").css("background-color","#ffffff");
            $("#play_type").val('1');
            $("#form1").attr("action","index.php?m=index&c=order&a=up_order");
        });


    });

    function check(){

    }
</script>
<script src="/static/mobile/assets/js/SmoothScroll.js"></script>
<script src="/static/mobile/assets/js/jquery.mmenu.min.js"></script>
<script src="/static/mobile/assets/js/core.min.js"></script>



</body>
</html>