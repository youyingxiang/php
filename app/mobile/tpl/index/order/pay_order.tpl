<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><strong style="color:#ff0000">充值金额:<?php echo $amount;?>元，获得房卡:<?php echo $goods_name;?></strong></h2>
                </div>
                <div class="panel-body" style="text-align:center;">
                    <img alt="扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($codeurl);?>" style="width:150px;height:150px;"/>
                </div>
            </div>
        </div>
        <div class="col-lg-12" style="margin-top:-20px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>操作提示</h2>

                </div>
                <div class="panel-body alerts" style="display: block;">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>方案一：</strong> 1.先将付款二维码保存至手机，2.打开微信扫一扫，3.点击扫一扫右上角“...”，选择"从相册选取二维码"即可成支付
                    </div>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>方案二：</strong> 1.直接手机截图，2.分享到微信自己的账号上，3.再微信上打开刚刚分享的截图，长按选择"识别途中二维码"即可完成支付
                    </div>
                </div>
                <input type="submit" name="button" id="query_pay" value="查看支付结果" style=" width:100%;color:#ffffff; background-color:#00AAEF;border:1px solid #00AAEF;padding-top:10px;padding-bottom:10px;position:fixed; bottom:0; left:0px; z-index:0;"/>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
    var order_sn = "<?php echo $order_sn;?>";
    $('#query_pay').on('click',function(){
        $.ajax({
            url:"/index.php?m=index&c=order&a=query_pay",
            type:"post",
            data:{'order_sn':order_sn},
            dataType: "json", 
            success: function (result){
               if (result.trade_state == 'SUCCESS') {
                    window.location.href="/index.php?m=index&c=index&a=buy";
               } else {
                    alert(result.trade_state_desc);
               }
            }
        })
    })
</script>


<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


<!-- page scripts -->
<script src="assets/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>

<!-- theme scripts -->
<script src="assets/js/SmoothScroll.js"></script>
<script src="assets/js/jquery.mmenu.min.js"></script>
<script src="assets/js/core.min.js"></script>


</body>
</html>