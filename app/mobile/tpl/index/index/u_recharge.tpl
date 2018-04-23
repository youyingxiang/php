
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-bullhorn"></i><a href="#">玩家充值</a></li>
            </ol>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-table red"></i><span class="break"></span><strong>玩家信息查询</strong></h2>
                    <div class="panel-actions">
                        <div class="form-group pull-right">
                            <a href="#" class="btn btn-danger" style="padding-left:10px; color:#FFF; padding-right:10px;">售卡详情</a>
                        </div>
                    </div>

                </div>

                <div class="panel-body">
                    <form name="form1" method="post" action="?m=index&c=index&a=u_recharge">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="playid" value="<?php echo $memberid;?>" name="uid" class="form-control" placeholder="玩家ID">
                                <span class="input-group-btn"><button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 查询</button></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if(isset($user)){ ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-sitemap red"></i><span class="break"></span><strong>玩家信息</strong></h2>

                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>玩家id</th>
                            <th>玩家昵称</th>
                            <th>当前房卡</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td><?php echo $user['memberid'];?></td>
                            <td><?php echo $user['name'];?></td>
                            <td><?php echo $user['roomcards'];?></td>
                            <td><a href="?m=index&c=index&a=torecharge&uid=<?php echo $user['memberid'];?>">充值</a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php }else{ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2><i class="fa fa-sitemap red"></i><span class="break"></span><strong>玩家信息</strong></h2>

            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                <?php if(!empty($msg)) echo $msg;?>
                </table>
            </div>
        </div>
        <?php } ?>
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h2><span class="break"></span>通知/提醒/购卡方式</h2>
                    <div class="panel-actions">

                        <a href="#" class="btn-minimize"><i class="fa fa-chevron-up black"></i></a>
                        <a href="#" class="btn-close"><i class="fa fa-times black"></i></a>
                    </div>
                </div>
                <div class="panel-body alerts">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>通知：</strong> 近期发现不少代理乱价，凡发现价格低于1-1.5元/张出售者将在不通知的情况下封号!另欢迎相互监督并举报，举报者将获得被封卡数额的一半作为奖励！							</div>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>提醒：</strong> 充值500张房卡后启用该账号							</div>
                </div>

            </div>
        </div>




    </div>
</div>
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
<script src="assets/js/pages/ui-elements.js"></script>

</body>
</html>