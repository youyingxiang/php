<?php $this->display('header.tpl'); ?>
<?php $this->display($menu);  ?>
<div class="panel panel-default">
        <?php
            if(isset($navs_tpl)){
                $this->display($navs_tpl);
            }
        ?>
		<div class="panel-body">	
			<h1><b class="page-title"<?php echo $title ?></b><b><small class="page-subtitle"><?php echo empty($sub_title)?"":$sub_title;?></small></b>
            <a href="<?php echo _WEB_FRONT_URL_.'/'.$attachmentinfo['path']; ?>" class="btn" target="_blank">下载附件</a>
            </h1>
		</div>
        <br />
        <form role="form" id="linemeta_line" class="form-horizontal text-left" method="post" action="index.php?m=game&c=attachment&a=updateAttachment&id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">文件路径: </label>
                <div class="col-sm-10">
                    <p class="form-control-static file_upload_1"><a href="<?php echo _WEB_FRONT_URL_.'/'.$attachmentinfo['path']; ?>"><?php echo $attachmentinfo['path'];?></a></p>
                </div>
            </div>
            <?php if($attachmentinfo['type'] == 'keystore'){ ?>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">alias:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $attachmentinfo['keystore_alias'];?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">密码:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $attachmentinfo['keystore_pwd'];?></p>
                </div>
            </div>
            <?php } ?>

            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件名称:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $attachmentinfo['name'];?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件类型:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php if($attachmentinfo['type'] == 'SourcePackage'){echo '母程序包';}elseif($attachmentinfo['type'] == 'keystore'){echo 'keystore证书';}else{echo '其他';} ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">游戏版本:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $attachmentinfo['version'];?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="sl_must_known" class="col-sm-2 control-label">附件备注:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $attachmentinfo['remark'];?></p>
                </div>
            </div>
            <div class="form-group ">
			    <label class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
						 <p class="form-control-static">
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
<?php $this->display('footer.tpl'); ?>
