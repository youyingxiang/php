<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-user"></i><a href="/index.php?m=index&c=index&a=myinfo">我的信息</a></li>
                <li><i class="fa fa-pencil"></i><a href="/index.php?m=index&c=index&a=up_myinfo">修改信息</a></li>
            </ol>
        </div>


        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span><i class="fa fa-pencil red"></i>修改信息</h2>
                </div>

                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=up_myinfo" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i> 昵称</span>
                                <input type="text" id="name" name="nick_name" class="form-control" placeholder="<?php echo $_SESSION['admin']['nick_name'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comments"></i> 微信号</span>
                                <input readonly type="text" id="wechat" name="wexin" class="form-control" placeholder="<?php echo $_SESSION['admin']['wexin'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-apple"></i> 手机号</span>
                                <input type="text" readonly id="phone" name="phone" class="form-control" placeholder="<?php echo $_SESSION['admin']['phone'];?>">
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <button type="submit" class="btn btn-sm btn-success"> 确认修改</button>
                        </div>
                    </form>



                </div>

            </div>





        </div>
    </div>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
    </script>
    <script src="assets/js/SmoothScroll.js"></script>
    <script src="assets/js/jquery.mmenu.min.js"></script>
    <script src="assets/js/core.min.js"></script>
</body>
</html>