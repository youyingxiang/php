<?php $this->display($menu);  ?>
<script>
var js_para=<?php echo( $this->val('js_para') ? json_encode($js_para ): "[]" )?>;
session_id=js_para["session_id"];
</script>
<script src="/static/js/jquery/jquery-1.9.1.min.js"></script>
<script src="/static/js/md5.js"></script>

<link href="/static/js/uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script src="/static/js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<script src="/static/page_js/uploadify_pic.js"></script>
<div class="panel panel-default">
        <?php
            if(isset($navs_tpl)){
                $this->display($navs_tpl);
            }
        ?>
		<div class="panel-body">	
			<h1><b class="page-title"><?php echo $title ?></b><b><small class="page-subtitle"><?php echo empty($sub_title)?"":$sub_title;?></small></b></h1>
		</div>
        <form role="form" id="linemeta_line" class="form-horizontal text-left" method="post" action="/index.php?m=cps_manage&c=cm_childunionlist&a=batchCreatePackage&parent_id=<?php echo $_GET['parent_id'];?>">            

        <div class="form-group">
            <label for="sl_must_known" class="col-sm-2 control-label"><b>选择母程序包:</b><span style="color:red">*</span></label>
            <div class="col-sm-10">
                <p class="form-control-static">
                    <select name="package_id" class="form-control" id="package_id">
                        <?php foreach($soucePackageList as $v){ ?>
                        <option value="<?php echo $v['id']; ?>" is_android="<?php echo $v['is_android']; ?>" ><?php echo $v['name']; ?>&nbsp;—&nbsp;游戏版本:<?php echo $v['version']; ?> </option>
                        <?php } ?>
                    </select>
                </p>
            </div>
        </div>
        <div class="form-group android_package" <?php if(!$soucePackageList[0]['is_android']){echo 'style="display:none"';} ?> >
            <label for="sl_must_known" class="col-sm-2 control-label"><b>选择证书</b><span style="color:red">*</span></label>
            <div class="col-sm-10">
                <p class="form-control-static">
                    <select class="form-control" name="keystore_id" id="keystore_id">
                        <?php foreach($keystoreList as $v){ ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?>&nbsp;—&nbsp;游戏版本:<?php echo $v['version']; ?> </option>
                        <?php } ?>
                    </select>
                </p>
            </div>
        </div>

        <div class="form-group android_package" <?php if(!$soucePackageList[0]['is_android']){echo 'style="display:none"';} ?> >
            <label for="sl_must_known" class="col-sm-2 control-label"><b>包名：</b><span style="color:red">*</span></label>
            <div class="col-sm-10">
                <p class="form-control-static"><input type="text" name="package_name"  class="form-control" required id="package_name"></p>
            </div>
        </div>
        
        <br />
        <table class="table" style="width:98%">
          <tbody>
          <tr>
            <td width="10%" align="center">子渠道ID</td>
            <td width="15%" align="center">名称</td>
            <td width="15%" align="center">渠道标识</td>
            <td width="15%" align="center">已生成渠道包</td>
            <td width="15%" align="center">已推送CDN</td>
            <td width="15%" align="center">成功进入打包队列</td>
          </tr>
          <?php foreach($unionList as $k=>$v){ ?>
          <tr class="channels" onclick="trSelect(this)">
            <td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['name']; ?></td>
            <td align="center"><?php echo $v['code']; ?></td>
            <td align="center"><?php if($v['state'] >=2){ ?><span style="color:green">Y</span><?php }else{ ?><span style="color:red">N</span> <?php } ?></td>
            <td align="center"><?php if($v['state'] >=3){ ?><span style="color:green">Y</span><?php }else{ ?><span style="color:red">N</span> <?php } ?></td>
            <td align="center" id="channel_id_<?php echo $v['id']; ?>" class="channel_ids" channel_id= <?php echo $v['id']; ?> ><span style="color:red">N</span></td>
          </tr>
          <?php } ?>
          
          </tbody>
        </table>
        <br>
        <br>
        <div class="form-group" style="height:100px">
            <div class="col-sm-4 col-sm-offset-4">
                <button class="btn btn-primary" type="button" id="start_create">&nbsp;&nbsp;&nbsp;提交&nbsp;&nbsp;&nbsp;</button>
                <img src="/static/img/busy_anim.gif" style="width:90px;height:90px;margin-right:300px;margin-top:-20px;display:none;float:right" id="y_loading">

            </div>

         </div>
        
        </form>
       
</div>

<style>
.panel{min-height:400px}
#linemeta_line{margin-left:50px}
.form-control{max-width:600px}
</style>
<script>
    $("#package_id").bind("change",function(){
        var is_android = $("#package_id ").find("option:selected").attr("is_android");
        if(is_android == 1){
            $(".android_package").show();
        }else{
            $(".android_package").hide();
        }
       
    })
    $(function(){
        var package_id;
        var keystore_id;
        var package_name;
        var cur_index =0;
        var package_file_id;
        var is_android
        $('#start_create').bind('click',function(){            
            package_id = $.trim($('#package_id').val());
            keystore_id = $.trim($('#keystore_id').val());
            package_name = $.trim($('#package_name').val());
            is_android = $("#package_id ").find("option:selected").attr("is_android");
            if(package_name =='' && is_android == 1){
                alert("请填写包名");
                return;
            }
            $(this).attr('disabled',true);
            //$('#y_loading').show();
            //上传渠道包
            $.ajax({
                type:'post',
                data:'package_id='+package_id,
                url:'/index.php?m=cps_manage&c=cm_unionlist&a=uploadPackageFile_ajax',
                //async: false,
                success:function(msg){
                    var res = eval("("+msg+")");
                    if(res.state != 0){
                        alert(res.msg);
                    }else{
                        package_file_id = res.data;
                        ajax_create(cur_index);
                    }
                }
            })
            //ajax_create(cur_index);

            //alert('操作完成');
            //window.location="?m=game&c=pubChannel&a=batchCreate&id="+game_id;
        
        }); 
        
        function ajax_create(cur_index){
                var channel_id = $('.channel_ids').eq(cur_index).attr('channel_id');
                if(cur_index+1 > $('.channel_ids').length){
                    $('#y_loading').hide();
                    return;
                }
                cur_index = cur_index+1;
                var postdata = 'package_file_id='+package_file_id+'&child_union_id='+channel_id+'&package_id='+package_id;
                if(is_android == 1){
                    postdata+='&package_name='+package_name+'&keystore_id='+keystore_id
                }
                $.ajax({
                    type:'post',
                    data: postdata,
                    url:'/index.php?m=cps_manage&c=cm_childunionlist&a=batchCreatePackage_ajax',
                    //async: false,
                    success:function(msg){
                        var res = eval("("+msg+")");
                        if(res.state == 0){
                            $("#channel_id_"+channel_id).html('<span style="color:green">成功</span>');
                        }else{
                            $("#channel_id_"+channel_id).html('<span style="color:red">失败:'+res.msg+'</span>');
                        }
                        ajax_create(cur_index);
                    }

                })
        }
    
    
    })
</script>
<?php $this->display('footer.tpl'); ?>
