<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-user"></i><a href="/index.php?m=index&c=index&a=myinfo">我的信息</a></li>
                <li><i class="fa fa-lock"></i><a href="/index.php?m=index&c=index&a=pass_ch">修改密码</a></li>
            </ol>
        </div>


        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span><i class="fa fa-lock red"></i>修改密码</h2>
                </div>

                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=pass_ch" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i> 当前密码</span>
                                <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="请填写当前密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock red"></i> 新的密码</span>
                                <input type="password" id="newspassword1" name="newspassword1" class="form-control" placeholder="设置新的密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock red"></i> 确认密码</span>
                                <input type="password" id="newspassword2" name="newspassword2" class="form-control" placeholder="确认新设置的密码">
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