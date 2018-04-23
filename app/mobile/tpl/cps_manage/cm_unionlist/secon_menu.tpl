<div class=" DTTT btn-group">
<H4 ><font color=gray>
		<ul class="list-inline">  
			<li class="">请选择游戏<li/><li>
				  <span id="cite_filter" class="list-inline"/> 
			</li>
            <!--
            <div class="DTTT btn-group"> 
                  <input type="text" id="form-field-name" placeholder="NKBOSS 用户名" > 
            </div>
            <div class="DTTT btn-group">  
                  <input type="password" id="form-field-pass" placeholder="NKBOSS 密码"  >
            </div>
			<li class=""><li/><li>
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-warning LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="javascript:void(0)" onclick="fetchUnionlist()"> 
						<!-- <i class="ace-icon fa fa-spinner fa-spin black" hide></i> -->
						<!-- fa-refresh -->
                        <!--
						<i class="ace-icon fa fa-refresh"  ></i>
						<span >重新拉取渠道列表</span>
					 </a>
				</div>
			</li> 
            -->
		</ul>
</font></H4> 

</div>
<div class=" DTTT btn-group">
</div>

<br />
<div class=" DTTT btn-group">
<H4 ><font color=gray>
		<ul class="list-inline">  
			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist btn-href" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_unionlist&a=batchCreatePackage&product_id=" onclick="return checkGameId(this)"> 
						<span >批量生成渠道包</span>
					 </a>
				</div>
			</li> 

			<li>
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_unionlist&a=batchPushCDN&product_id=" onclick="return checkGameId(this)" > 
						<!-- <i class="ace-icon fa fa-spinner fa-spin black" hide></i> -->
						<!-- fa-refresh -->
						<span >批量推送CDN</span>
					 </a>
				</div>
			</li> 

			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_unionlist&a=batchRefreshCDN&product_id=" onclick="return checkGameId(this)" > 
						<span >批量刷新CDN缓存</span>
					 </a>
				</div>
			</li> 

			<li style="padding-left: 0px">
				<div class="DTTT btn-group"> 
					 <a class="btn  btn-light LAN_FetchUnionlist" id="fetch-unionlist-btn"
						href="/index.php?m=cps_manage&c=cm_unionlist&a=batchWarmCDN&product_id=" onclick="return checkGameId(this)" > 
						<span >批量CDN预热</span>
					 </a>
				</div>
			</li> 

		</ul>
</font></H4> 
</div>


<script>
function checkGameId(obj){
    var select_game_id = $(".cas_menu_select").val();
    if(select_game_id == 0){
        alert("请先选择游戏");
        return false;
    }else{
        var base_href=$(obj).attr("href");
        $(obj).attr("href", base_href+select_game_id);   
        return true;
    }
}


</script>