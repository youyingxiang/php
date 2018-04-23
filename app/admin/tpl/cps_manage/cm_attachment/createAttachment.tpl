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
			<h1><b class="page-title"<?php echo $title ?></b><b><small class="page-subtitle"><?php echo empty($sub_title)?"":$sub_title;?></small></b></h1>
		</div>
        <br />
        <form role="form" id="linemeta_line" class="form-horizontal text-left" method="post" action="index.php?m=cps_manage&c=cm_attachment&a=createAttachment&game_id=<?php echo $_GET['game_id']; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">文件临时路径: </label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class="text-danger">暂无上传</span></p>
                    <input type="hidden" name="file_path" class="file_upload_1">
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">上传:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="file" id="file_upload_1"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-1 control-label"></label>
                <div class="col-sm-11">
                    <p class="form-control-static" id="file_upload_queue_1"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">游戏版本<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="text" name="version"  class="form-control"  required value="" ></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件类型<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <select class="form-control" name="type" id="attachment_type">
                            <option value="SourcePackage">母程序包</option>
                            <option value="keystore">keystore证书</option>
                        </select>
                    </p>
                </div>
            </div>

            <div class="form-group" style="display:none" id="keystore_alias">
                <label for="sl_must_known" class="col-sm-2 control-label">alias:<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="text" name="keystore_alias"  class="form-control"></p>
                </div>
            </div>
            <div class="form-group" style="display:none" id="keystore_pwd">
                <label for="sl_must_known" class="col-sm-2 control-label">密码:<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="text" name="keystore_pwd"  class="form-control"></p>
                </div>
            </div>

            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件名称<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="text" name="name"  class="form-control"  required></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件备注<span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><textarea  class="form-control" name="remark" required></textarea></p>
                </div>
            </div>
            <div class="form-group ">
			    <label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
						 <p class="form-control-static">
                            <button class="btn btn-primary">提交</button>
 						</p>
						</div>
			</div>

                
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
        $("#attachment_type").bind("change",function(){
            var a_type = $(this).val();
            if(a_type == 'keystore'){
                $("#keystore_alias").show();
                $("#keystore_pwd").show();
            }else{
                $("#keystore_alias").hide();
                $("#keystore_pwd").hide();            
            }
        })
    })
</script>
<?php $this->display('footer.tpl'); ?>
