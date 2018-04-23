
<?php  if(isset($public)){ $this->display($public) ;} ?>


<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-tasks"></i>购卡统计</li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span>房卡购买统计</h2>
                </div>
                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=buy" method="post" class="form-horizontal ">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-xs-4">
                                    <input readonly type="text" class="form-control" value="<?php echo $statime = empty($_POST['statime'])?'':$_SESSION['statime'];?>"onclick="laydate()" name="statime" id="statime">
                                </div>
                                <div class="col-lg-4 col-xs-4">
                                    <input readonly type="text" class="form-control" value="<?php echo $statime = empty($_POST['endtime'])?'':$_SESSION['endtime'];?>" onclick="laydate()" name="endtime" id="endtime">
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
                            <th>购买时间</th>
                            <th>购买数量</th>
                            <th>获赠数量</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $v){ ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i:s',$v['paytime']);?></td>
                                <td><?php echo $v['goods_name']?></td>
                                <td>0</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tbody>
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
<script>
    ;!function(){
        laydate({
            elem: '#demo'
        })
    }();
</script>

</body>
</html>