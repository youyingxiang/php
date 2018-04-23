
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-credit-card"></i>房卡出售统计</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><strong>总出售：<?php echo $snum;?> 房卡</strong></h2>
                </div>
                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=sale" method="post" class="form-horizontal ">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="col-sm-3"><input readonly class="form-control" onclick="laydate()" value="<?php echo $statime = empty($_POST['sstatime'])?'':$_SESSION['sstatime'];?>" name="sstatime" id="statime"></div>
                                        <div class="col-sm-3"><input readonly class="form-control" onclick="laydate()" value="<?php echo $statime = empty($_POST['sendtime'])?'':$_SESSION['sendtime'];?>" name="sendtime" id="endtime"></div>
                                        <span  class="input-group-btn"><button type="submit" class="btn btn-danger">查询</button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="170">充值时间</th>
                            <th width="150">充值数量</th>
                            <th width="150">玩家ID/俱乐部ID</th>
                            <th width="150">玩家昵称</th>
                            <th width="150">当前房卡</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($orders as $v){ ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i:s',$v['recharge_time']);;?></td>
                                <td><?php echo $v['counts'];?></td>
                                <td><?php echo $v['recharge_id'];?></td>
                                <td>
                                    <?php echo $v['recharge_name'];?>							</td>
                                <td><?php echo (int)$_SESSION['admin']['user_coins'];?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if(count($orders)==0){ ?>
                    <ul class="pagination">
                        <li><a href='todatastatistic.php?statime=&endtime=&'>当前还没有任何记录</a><li>							 </ul>
                    <?php } ?>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/mobile/assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>

<script src="/static/mobile/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/static/mobile/assets/js/bootstrap.min.js"></script>


<!-- page scripts -->
<script src="/static/mobile/assets/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
<script src="/static/mobile/assets/plugins/raphael/raphael.min.js"></script>

<!-- theme scripts -->
<script src="/static/mobile/assets/js/SmoothScroll.js"></script>
<script src="/static/mobile/assets/js/jquery.mmenu.min.js"></script>
<script src="/static/mobile/assets/js/core.min.js"></script>

<!-- inline scripts related to this page -->
<script src="/static/mobile/assets/js/pages/ui-elements.js"></script>
<script>
    ;!function(){
        laydate({
            elem: '#demo'
        })
    }();
</script>

</body>
</html>