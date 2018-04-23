window.onload=function(){  
	
	controller_url = 	js_para.controller_url 
	agent_view = js_para.agent_view; 
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
					"width":"10%",
					"search": true, 
				},
				{
					"label": "请求时间:",
					"name": "request_time", 
					"type": "datetime",
					"width":"20%",	
					"search": true,
					'format':'YYYY-MM-DD HH:mm:ss'	,
					"def":       function () { return new Date(); }
				},
				{
					"label": "处理时间:",
					"name": "deal_time", 
					"type": "datetime",
					"width":"20%",
					"search": true,
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
					"type":"select",
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
						if(agent_view){
							switch(row.status*1){
							case 1:
								ops= '<a href="javascript:void(0)" onclick="doOption(\'cancel_withdraw\',\''+row.id+'\')">取消提现</a> '; 
								break;
							case 2:
								ops= '<a href="javascript:void(0)" onclick="doOption(\'request_withdraw\',\''+row.id+'\')">申请提现</a> '; 
								break; 
							}
						}else{
							switch(row.status*1){
							case 1:
								ops= '<a href="javascript:void(0)" onclick="doOption(\'deny_withdraw\',\''+row.id+'\')">拒绝</a> '
								+ ' / <a href="javascript:void(0)" onclick="doOption(\'confirm_withdraw\',\''+row.id+'\')">设置为已提现</a> '; 
								break; 
							case 2: 
								break; 
							}
						}
						return  ops;
					}
				}
		
		],
		{
			"privilege":js_privilege,
			"disable_keyup_search":true,
			"columnDefs":[{orderable:false, targets:[0,1,2,3,4,5 ]  }],
			"order":[[ 1, 'desc' ]],
			"serverSide":true,
			//"tableOnly":true,
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);
	
	oTable = table_editors[0];
}

//========执行单条 
function doOption(action, id){
	cancelBubble();
	var url =  controller_url + "&a="+action + "&id=" +  id;
	
 	if(action == "confirm_withdraw"){
 		if(!confirm("确定已经给用户提现完成？")){
 			return;
 		}
 	}else if(action == "deny_withdraw"){
 		var deny_reason = window.prompt("请输入拒绝原因", "")
 		if(!deny_reason) return;
		url += "&reason=" + deny_reason;
 	}
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

