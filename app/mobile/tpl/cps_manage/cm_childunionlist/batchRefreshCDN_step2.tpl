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

    
        
        <table class="table" style="width:98%">
          <tbody>
          <tr>
            <td width="10%" align="center">子渠道ID</td>
            <td width="15%" align="center">名称</td>
            <td width="15%" align="center">渠道标识</td>
            <td width="15%" align="center">打包任务状态</td>
            <td width="15%" align="center">渠道包版本</td>
            <td width="15%" align="center">CDN包版本</td>
            <td width="15%" align="center">刷新CDN缓存</td>
          </tr>
          <?php foreach($unionList as $k=>$v){ ?>
          <tr class="channels" onclick="trSelect(this)">
            <td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['name']; ?></td>
            <td align="center"><?php echo $v['code']; ?></td>
            <td align="center">
                <?php
                    if($v['package_state'] == 0){
                        echo "未打包";
                    }elseif($v['package_state'] == 1){
                        echo "<font color='f0ad4e'>等待打包</a>";
                    }elseif($v['package_state'] == 3){
                        echo "<font color='green'>打包成功</font>";
                    }elseif($v['package_state'] == 4){
                        echo "<font color='red'>打包失败</font>";
                    }
                ?>
            </td>
            <td align="center"><?php echo $v['tmp_package_version']; ?></td>
            <td align="center"><?php echo $v['cdn_package_version']; ?></td>
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
    $(function(){
        var cur_index =0;
        $('#start_create').bind('click',function(){            
            $(this).attr('disabled',true);
            $('#y_loading').show();
            ajax_create(cur_index);

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
                $.ajax({
                    type:'post',
                    data:'child_union_id='+channel_id,
                    url:'/index.php?m=cps_manage&c=cm_childunionlist&a=batchRefreshCDN_ajax',
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
