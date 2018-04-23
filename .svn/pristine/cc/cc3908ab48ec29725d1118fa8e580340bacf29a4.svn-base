
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-user"></i>我的信息</li>
            </ol>
        </div>


        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span>我的信息</h2>
                </div>

                <div class="panel-body">

                    <div class="alert alert-danger">

                        <strong>我的信息</strong>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>昵称</th>
                            <td><?php echo $_SESSION['admin']['nick_name'];?></td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <th>代理ID</th>
                            <td><?php echo $_SESSION['admin']['id'];?></td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <th>帐号</th>
                            <td><?php echo $_SESSION['admin']['user_name'];?></td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <th>手机号码</th>
                            <td><?php echo $_SESSION['admin']['phone'];?></td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <th>微信号</th>
                            <td><?php echo $_SESSION['admin']['wexin'];?></td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr>
                            <th>加入时间</th>
                            <td><?php echo date('Y-m-d H:i:s',$_SESSION['admin']['addtime']);?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="panel-footer">
                    <a href="/index.php?m=index&c=index&a=up_myinfo" style="color:#FFF;"><div class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> 修改信息</div></a>
                    <a href="/index.php?m=index&c=index&a=pass_ch" style="color:#FFF;"><div class="btn btn-sm btn-warning"><i class="fa fa-unlock-alt"></i> 修改密码</div></a>
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