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
        <form role="form" id="linemeta_line" class="form-horizontal text-left" method="post" action="index.php?m=cps_manage&c=cm_childunionlist&a=createPackage&id=<?php echo $_GET['id']; ?>">            
            
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>渠道名:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $union_info['name']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>渠道ID:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $union_info['id']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>渠道标识:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $union_info['code']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>父渠道:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $parent_union_info['name']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>当前版本:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $union_info['tmp_package_version']; ?></span></p>
                </div>
            </div>
            
          
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>选择母程序包:</b><span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <select name="package_id" class="form-control" id="package_id">
                            <?php foreach($soucePackageList as $v){ ?>
                            <option value="<?php echo $v['id']; ?>" is_android="<?php echo $v['is_android']; ?>"><?php echo $v['name']; ?>&nbsp;—&nbsp;游戏版本:<?php echo $v['version']; ?> </option>
                            <?php } ?>
                        </select>
                    </p>
                </div>
            </div>
            <div class="form-group android_package" <?php if(!$soucePackageList[0]['is_android']){echo 'style="display:none"';} ?> >
                <label for="sl_must_known" class="col-sm-2 control-label"><b>选择证书</b><span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <select class="form-control" name="keystore_id" id="keystore_id" >
                            <?php foreach($keystoreList as $v){ ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?>&nbsp;—&nbsp;游戏版本:<?php echo $v['version']; ?> </option>
                            <?php } ?>
                        </select>
                    </p>
                </div>
            </div>

            <div class="form-group android_package"  id="package_name" <?php if(!$soucePackageList[0]['is_android']){echo 'style="display:none"';} ?>>
                <label for="sl_must_known" class="col-sm-2 control-label"><b>包名：</b><span style="color:red">*</span></label>
                <div class="col-sm-10">
                    <p class="form-control-static"><input type="text" name="package_name"  class="form-control"></p>
                </div>
            </div>
          
            <div class="form-group ">
			    <label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
						 <p class="form-control-static">
                            <button class="btn btn-primary">自动生成</button>
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
    $("#package_id").bind("change",function(){
        var is_android = $("#package_id ").find("option:selected").attr("is_android");
        if(is_android == 1){
            $(".android_package").show();
        }else{
            $(".android_package").hide();
        }

    })
})

</script>
<?php $this->display('footer.tpl'); ?>
