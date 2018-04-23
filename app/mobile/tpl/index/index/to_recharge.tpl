<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-card"></i>玩家充值</li>
            </ol>
        </div>


        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="break"></span>玩家充值</h2>
                </div>

                <div class="panel-body">
                    <form action="/index.php?m=index&c=index&a=torecharge" method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">用 户&nbsp; I D</span>
                                <input type="text"  readonly id="play_id" name="play_id" class="form-control" value="<?php echo $_SESSION['g_user']['memberid']?>">
                                <input type="text"  readonly id="play_num" name="play_num" style="display:none;"  value="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">可用数量</span>
                                <input type="email" readonly id="nownum" name="nownum" class="form-control" value="<?php echo $_SESSION['admin']['user_coins'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">充值数量</span>
                                <input type="text" id="num" name="num" class="form-control" placeholder="请填写一个正整数">
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <button type="submit" class="btn btn-sm btn-success">确认充值</button>
                            <a href="javascript:history.back(-1);" style="color:#FFF;"><span type="submit" class="btn btn-sm btn-success">取消返回</span></a>
                        </div>
                    </form>




                </div>


            </div>





        </div>
    </div>
</div>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static/mobile/assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>
<script src="/static/mobile/assets/js/SmoothScroll.js"></script>
<script src="/static/mobile/assets/js/jquery.mmenu.min.js"></script>
<script src="/static/mobile/assets/js/core.min.js"></script>
<script type="text/javascript" src="/static/mobile/jquery/jquery.min.js"></script>
</body>
</html>