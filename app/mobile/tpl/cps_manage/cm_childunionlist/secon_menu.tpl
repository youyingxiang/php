<div class=" DTTT btn-group">
<H4 ><font color=gray>
		<ul class="list-inline">  
			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_childunionlist&a=batchCreatePackage&parent_id=<?php echo $_GET['parent_id']; ?>" > 
						<span >批量生成渠道包</span>
					 </a>
				</div>
			</li> 

			<li>
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_childunionlist&a=batchPushCDN&parent_id=<?php echo $_GET['parent_id']; ?>"> 
						<!-- <i class="ace-icon fa fa-spinner fa-spin black" hide></i> -->
						<!-- fa-refresh -->
						<span >批量推送CDN</span>
					 </a>
				</div>
			</li> 

			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_childunionlist&a=batchRefreshCDN&parent_id=<?php echo $_GET['parent_id']; ?>"> 
						<span >批量刷新CDN缓存</span>
					 </a>
				</div>
			</li> 

			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_childunionlist&a=batchWarmCDN&parent_id=<?php echo $_GET['parent_id']; ?>"> 
						<span >批量CDN预热</span>
					 </a>
				</div>
			</li> 

		</ul>
</font></H4>       
</div>
