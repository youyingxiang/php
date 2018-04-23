
<!DOCTYPE html>
<html lang="en">
<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-sitemap"></i><a href="index.php?m=index&c=index&a=myagent">我的代理</a></li>
            </ol>
        </div>


        <!--<div class="col-lg-12">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h2><span class="break"></span>购卡方式 / 最新预告</h2>
                                    <div class="panel-actions">

                                        <a href="#" class="btn-minimize"><i class="fa fa-chevron-up black"></i></a>
                                        <a href="#" class="btn-close"><i class="fa fa-times black"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body alerts">
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>通知：</strong> 近期发现不少代理乱价，凡发现价格低于1.5元/张出售者将在不通知的情况下封号!另欢迎相互监督并举报，举报者将获得被封卡数额的一半作为奖励！							</div>
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>购卡方式：</strong>                                 </div>
                                </div>

                            </div>
                        </div>      -->


        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-sitemap red"></i><span class="break"></span><strong>代理列表</strong></h2>
                    <div class="panel-actions">
                        <div class="form-group pull-right">
                            <a href="index.php?m=index&c=index&a=addagent" class="btn btn-danger" style="padding-left:10px; color:#FFF; padding-right:10px;">添加代理</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>昵称</th>
                            <th>代理昵称</th>
                            <th>房卡剩余数量</th>
                            <th>加入时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                                <?php foreach($agents as $v){ ?>
                                    <tr>
                                        <td><?php echo $v['nick_name']?></td>
                                        <td><?php echo $v['bnick_name']?></td>
                                        <td><?php echo $v['user_coins']?></td>
                                        <td><?php echo date('Y-m-d H:i:s',$v['addtime']);?></td>
                                        <td><a data-id="<?php echo $v['id'];?>"  class="btn btn-danger cz" href="javascript:void(0)">充值</a></td>
                                    </tr>
                                <?php } ?>

                        </tbody>
                    </table>
                    <?php if(count($agents)==0){ ?>
                    <ul class="pagination">
                        <li><a href='tomyagent.php?'>当前还没有任何记录</a><li>                             </ul>
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
    $('.cz').on('click',function(){
        var user_id = $(this).attr('data-id')
        layer.prompt({num: '输入充值金额，并确认', formType: 1}, function(num, index){
            if (num < 0) {
                layer.msg('充值金额不能为负!');
                return
            } 
              $.ajax({
                    url: "index.php?m=index&c=index&a=recharg", 
                    data: {"user_id":user_id,'num':num,},
                    type:'post', 
                    dataType: "json", 
                    error:function(data){
                         layer.close(index);
                         showErrMsg("服务器错误");
                         return;
                    },  
                    success:function(result){
                        if (result.code == 0 ) {
                            layer.msg('充值成功！');
                            window.location.reload();
                        } else {
                            layer.msg(result.info);
                        }
                        layer.close(index);
                    },
            })       
          
        });
    })
</script>
</body>
</html>
