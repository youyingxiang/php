
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-users"></i>申请成为总代</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h2><span class="break"></span>总代申请条件说明</h2>
                    <div class="panel-actions">
                    </div>
                </div>
                <div class="panel-body alerts">

                    <div class="alert alert-danger">
                        <strong>总代理说明：</strong> 1.可自由开通主管、副主管、普通返卡代理账号；2.可获得直属代理充值金额的20%返利；3：可获得主管/副主管下面代理充值金额的5%返利。<a href="#jump" id="open1">[详细查看]</a>
                    </div>
                    <div class="alert alert-danger">
                        <strong>申请条件：</strong> 累计总充值达到<?php echo $scon/10000;?>万元，可以申请成为总代理！
                    </div>

                    <div class="alert alert-info">
                        <strong>当前总充值：</strong> <?php echo $smount;?> 元<?php if($smount<$scon){ ?> 离申请总代理还差：<?php echo $scon-$smount;?>元<?php } ?>
                        							</div>
                <?php if(@$_SESSION['isup']!=1){ ?>
                    <?php if($smount<$scon){ ?>
                    <span class="btn btn-default" id="bounce_box1" style="padding-left:10px; padding-right:10px;">申请总代理</span>
                    <?php }else{ ?>
                    <span class="btn btn-default" id="bounce_box2" style="padding-left:10px; padding-right:10px;">申请总代理</span>
                    <?php } ?><?php } ?>
                </div>
            </div>
        </div>


        <div class="col-lg-12" id="open2" style="display:none">
            <p id="jump" style="padding-top:50px;"></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span>总代理详细说明</h2>
                    <div class="panel-actions">
                    </div>
                </div>
                <div class="panel-body alerts" style="line-height:35px;">
                    <div style=" width:100%; float:left;font-size:18px;">摸摸游戏总代理说明</div>
                    <div style=" width:100%; float:left;font-size:14px;">一、总代理：公司将提供独立的后台给总代理，后台可以开通主管账号，也可以开通普通代理号，充值流水等数据会在后台体现；</br><span style="color:#C60;">总代理利润：</span></br>1、名下所有主管及副主管充值流水*5%</br>2、自己直接开通普通代理充值总流水*20%</br>二、主管：主管后台由总代理开通；主管后台可以添加副主管账号，也可以开通普通代理号，充值流水等数据会在后台体现；</br><span style="color:#C60;">主管利润：</span></br>1、名下所有副主管充值流水*5%</br>2、自己直接开通普通代理充值总流水*15%</br>3、官方额外返利：名下所有副主管代理月充值流水满3W，官方额外返利2%；即月充值流水*2%；</br>三、副主管：副主管后台由主管开通，副主管可以添加普通代理，普通代理返卡模式和官方同步（具体请见附言详解）；</br><span style="color:#C60;">副主管利润：</span></br>1、普通代理充值流水*10%；</br>2、副主管官方额外返利：</br>
                        <table width="100%" border="0" class="table table-bordered table-hover">
                            <tr height="35">
                                <td>月充值金额</td>
                                <td>官方额外返利</td>
                                <td>返利金额</td>
                            </tr>
                            <tr height="35">
                                <td>10000</td>
                                <td>1%</td>
                                <td>100</td>
                            </tr>
                            <tr height="35">
                                <td>20000</td>
                                <td>2%</td>
                                <td>400</td>
                            </tr>
                            <tr height="35">
                                <td>30000</td>
                                <td>3%</td>
                                <td>900</td>
                            </tr>
                            <tr height="35">
                                <td>40000</td>
                                <td>4%</td>
                                <td>1600</td>
                            </tr>
                            <tr height="35">
                                <td>50000</td>
                                <td>5%</td>
                                <td>2500</td>
                            </tr>
                            <tr height="35">
                                <td>60000</td>
                                <td>6%</td>
                                <td>3600</td>
                            </tr>
                            <tr height="35">
                                <td>70000</td>
                                <td>7%</td>
                                <td>4900</td>
                            </tr>
                            <tr height="35">
                                <td>80000</td>
                                <td>8%</td>
                                <td>6400</td>
                            </tr>
                        </table>
                        四、普通返卡代理：普通返卡代理后台可以由总代理、主管、副主管开通；
                        </br>

                        普通返卡代理同时可以开通其他同等级普通返卡代理返卡</br>
                        流程见附件；</br>
                        <span style="color:#C60;">普通返卡代理利润：500元1000张房卡；房卡售价不低于1.5元每张出售；</span></br>
                        <span style="color:#C60;">晋升总代理：</span></br>
                        1、当累积充值金额达到30000元时可以升级为总代理；</br>
                        2、后台提交升级总代理后，官方进行审核，审核通过后将在当月结算后的第一天开通总代理账号；</br>
                        3、升级成为总代理后以前的普通代理号自动归属到新总代理号下面；</br>
                        4、升级前发展的代理充值将不再返卡；</br>
                        <span style="color:#C60;">(房卡售价规定：代理房卡售价必须与官方规定的价格统一，以免乱价影响到整个市场的运作，如出现乱价官方将对该主管和总代理做出处罚）；</span></br>
                        五、结算：每个月第一个工作日</br>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<script>

    //弹出一个页面层
    $('#bounce_box1').on('click', function(){

        layer.open({
            title:'总代理申请-请根据提示填写正确的信息',
            type: 1,
            area: ['75%'],
            shadeClose: true, //点击遮罩关闭
            content: "<div class='panel-body'><div class='alert alert-danger'>当前充值金额不足30000元，不能申请为总代理</div></div>"
        });
    });

    $('#bounce_box2').on('click', function(){
        $.ajax({
            url:"/index.php?m=index&c=index&a=sapply",
            type:"post",
            data:"",
            success: function (result){
                if(result == 1){
                    alert('申请成功，请等待管理员审核');
                }else{
                    alert('申请未通过');
                }
            }
        })
    });

    $('#open1').on('click',function(){

        $("#open2").toggle();

    });
</script>

<script src="assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
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

<!-- inline scripts related to this page -->

<script type="text/javascript" src="assets/js/jquery.cityselect.js"></script>
<script type="text/javascript">
    $(function(){
        $("#city_4").citySelect({
            prov: "湖南",
            city: "长沙",
            dist: "天心区",
            nodata: "none"
        });
    });
</script>



</body>

</body>
</html>
