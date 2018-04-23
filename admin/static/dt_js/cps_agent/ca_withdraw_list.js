window.onload=function(){ 
	controller_url = js_para.controller_url
	datalist_ajax_url = controller_url + "&a=withdraw_ajax"
	
	
	mygames = js_para.games;
	mygames['_EMPTY_STRING_']="所有";
	
	myunions = js_para.unions;
	myunions['_EMPTY_STRING_']="所有";
	table_editors = genEditorTable('#data_list' ,datalist_ajax_url, 
		[
				{
					"label": "游戏:",
					"name": "game_id", 
					"type":"select",
					"width":"10%",
					"search":  mygames , 
					"render":  mygames , 
				},
				{
					"label": "渠道:",
					"name": "union_id", 
					"width":"10%",
					"type":"select",
					"search": myunions, 
					"render":  myunions , 
				},
				{
					"label": "代理商ID:",
					"name": "agent_id", 
					"type":"hidden",
					"in_table":false,
					"search": true, 
					"def":js_para.agent_id
				},
				{
					"label": "请求时间:",
					"name": "request_time", 
					"type": "datetime",
					"width":"20%",	
					"search": true,
					"type":"hidden",
					'format':'YYYY-MM-DD HH:mm:ss'	,
					"def":       function () { return new Date(); }
				},
				{
					"label": "处理时间:",
					"name": "deal_time", 
					"type": "datetime",
					"width":"20%",
					"search": true,
					"type":"hidden",
					'format':'YYYY-MM-DD HH:mm:ss'	,
					"def":       function () { return new Date(); }
				} ,
				{
					"label": "金额:",
					"name": "amount"
					
				} ,
				{
					"label": "状态",
					"name": "status",
					"type":"hidden",
					"def":  "1",
					"search":{"_EMPTY_STRING_":"所有","1":"已申请","2":"已取消申请","3":"已拒绝","4":"已完成提现"},
					//"render": {"_EMPTY_STRING_":"所有","1":"已申请","2":"已取消申请","3":"已拒绝","4":"已完成提现"},
					"render":function ( val, type, row ) {
						var ops = ""; 
						switch(	val*1 ){
						case 1: ops= '已申请';  break;
						case 2: ops= '已取消申请';  break; 
						case 3: ops= '已拒绝 原因：' + row.reason;  break; 
						case 4: ops= '已完成提现';  break; 
						}
						
						return  ops;
					}
					
				} ,
				{
					"label":"操作",
					"type":"hidden",
					"name":"id", 
					"render":function ( val, type, row ) {
						var ops = ""; 
						switch(row.status*1){
						case 1:
							ops= '<a href="javascript:void(0)" onclick="doOption(\'cancel_withdraw\',\''+row.id+'\')">取消提现</a> '; 
							break; 
						}
						 
						return  ops;
					}
				}
		
		],
		{
			"privilege":js_privilege,
			"disable_keyup_search":true,
			"columnDefs":[{orderable:false, targets:[0,1,2,3,4,5,6 ]  }],
			"order":[[ 2, 'desc' ]],
			"serverSide":true,
		}
	);
	
	oTable = table_editors[0];
}

//========执行单条 
function doOption(action, id){
 	
	var url =  controller_url + "&a="+action + "&id=" +  id;
 	//alert(url);
	$.ajax({async: true, type : "get",url:url, data:{}, 
		dataType : 'json',  
		success : function(result) {
			if(result.code==0){  
				// 更新余额 
				refreshDatas()
				alert("成功")
			}else{
				alert("错误："+result.msg);
			}
		
			return;
		} 
	});//END ajax
}

//===================刷新列表
function refreshDatas(){
	var settings=oTable.fnSettings();
	oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
	 
}

// 重新生成 URL
function getNewListAjaxUrl(){
	var tmp_para=""; 
	var newUrl= datalist_ajax_url + tmp_para ;
	return newUrl;
}

