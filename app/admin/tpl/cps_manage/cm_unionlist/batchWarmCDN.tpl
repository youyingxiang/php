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
        <br />
        

        <form method="post" action="/index.php?m=cps_manage&c=cm_unionlist&a=batchWarmCDN&product_id=<?php echo $_GET['product_id']; ?>" enctype="multipart/form-data" class="form-horizontal text-left" id="linemeta_line" role="form">

        <table class="table" style="width:98%">
          <tbody>
          <tr>
            <td width="10%" align="center"><input type="checkbox" id="selectbox">选择</td>
            <td width="10%" align="center">渠道ID</td>
            <td width="15%" align="center">名称</td>
            <td width="15%" align="center">渠道标识</td>
            <td width="15%" align="center">已推送CDN</td>
            <td width="15%" align="center">打包任务状态</td>
            <td width="15%" align="center">渠道包版本</td>
            <td width="15%" align="center">CDN包版本</td>

          </tr>
          <?php foreach($unionList as $k=>$v){ ?>
          <tr class="channels" onclick="trSelect(this)">
            <td align="center"><input type="checkbox" name="union_id[]" value="<?php echo $v['id']; ?>" onclick="trSelect($(this).parents('.channels'))"></td>
            <td align="center"><?php echo $v['id']; ?></td>
            <td align="center"><?php echo $v['name']; ?></td>
            <td align="center"><?php echo $v['code']; ?></td>
            <td align="center"><?php if($v['state'] >=3){ ?><span style="color:green">Y</span><?php }else{ ?><span style="color:red">N</span> <?php } ?></td>
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
          </tr>
          <?php } ?>
          
          </tbody>
        </table>
        <br>
        <br>
        <div class="form-group"><div class="col-sm-4 col-sm-offset-4"><button class="btn btn-primary" type="submit" name="submitSelectCode">&nbsp;&nbsp;&nbsp;提交&nbsp;&nbsp;&nbsp;</button></div></div>
        </form>
       
</div>
<script>
   FileUploadify("file_upload_1","file_upload_queue_1","上传附件",session_id,"index.php?m=cps_manage&c=cm_attachment&a=upload_ajax&id=<?php echo $_GET['game_id'];?>");
  
</script>
<style>
.panel{min-height:400px}
#linemeta_line{margin-left:50px}
.form-control{max-width:600px}
</style>
<script>
    $(function(){
        $("#selectbox").bind("click",function(){
            if($("#selectbox").prop("checked")){
                $("input[name='union_id[]']").prop("checked",true);  
            }else{
                $("input[name='union_id[]']").prop("checked",false);  
            }
        })
    })
    function trSelect(obj){
        $(obj).find('input').prop("checked", !$(obj).find('input').prop("checked"));
    }
</script>
<?php $this->display('footer.tpl'); ?>
