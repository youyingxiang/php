
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-cny"></i>返利详情</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span>一级代理返钻：0&nbsp;&nbsp;二级代理返钻：0&nbsp;&nbsp;官方补偿：0&nbsp;&nbsp;合计返钻：0</h2>
                </div>
                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=myrebate" method="post" class="form-horizontal ">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-xs-4">
                                    <input readonly type="text" class="form-control" value="<?php echo $statime = empty($_POST['rstatime'])?'':$_SESSION['rstatime'];?>" onclick="laydate()" name="rstatime" id="statime">
                                </div>
                                <div class="col-lg-4 col-xs-4">
                                    <input readonly type="text" class="form-control" value="<?php echo $endtime = empty($_POST['rendtime'])?'':$_SESSION['rendtime'];?>" onclick="laydate()" name="rendtime" id="endtime">
                                </div>
                                <div class="col-lg-4 col-xs-4">
                                    <button type="submit" class="btn btn-primary">查询</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>比例</th>
                            <th>返卡数量</th>
                            <th>返现代理商</th>
                            <th>返卡时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($rebates as $v){ ?>
                        <tr>
                            <td><?php echo $v['rebate']?></td>
                            <td><?php echo $v['counts']?></td>
                            <td><?php echo $v['user_name']?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v['re_time']);?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php if(count($rebates)==0){ ?>
                    <ul class="pagination">
                        <li><a href='tomyrebatepage.php?action=lookup&statime=&endtime=&'>当前还没有任何记录</a><li>							 </ul>
                    <?php } ?>
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

<script>
    ;!function(){
        laydate({
            elem: '#demo'
        })
    }();
</script>

</body>
</html>