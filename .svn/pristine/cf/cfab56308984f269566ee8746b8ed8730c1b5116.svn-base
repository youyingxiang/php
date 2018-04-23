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
        <form role="form" id="linemeta_line" class="form-horizontal text-left" method="post" action="index.php?m=cps_manage&c=cm_childunionlist&a=pushCdn&id=<?php echo $_GET['id']; ?>">            
            <input type="hidden" name="push_cdn" value="1">
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
                <label for="sl_must_known" class="col-sm-2 control-label"><b>父渠道:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $parent_union_info['name']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>渠道包版本:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><?php echo $union_info['tmp_package_version']; ?></span></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label"><b>下载地址:</b></label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><span class=""><a href="<?php echo $union_info['package_url']; ?>" target="_blank"><?php echo $union_info['package_url']; ?></a></span></p>
                </div>
            </div>

            <div class="form-group ">
			    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                     <p class="form-control-static">
                        <button class="btn btn-primary" type="button" id="push_cdn_btn">推送到CDN</button>
                    </p>
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
    $("#push_cdn_btn").bind("click",function(){
        if(confirm("推送至CDN服务器吗?")){
            $("#linemeta_line").submit();
        }  
    })

})
   
</script>
<?php $this->display('footer.tpl'); ?>
