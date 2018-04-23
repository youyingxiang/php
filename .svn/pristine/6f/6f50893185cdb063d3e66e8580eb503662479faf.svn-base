cur_game_id=false; 
datalist_ajax_url="index.php?m=cps_manage&c=cm_unionlist&a=index_ajax";
if(js_para.game_id){
	var default_game_id = js_para.game_id;
}else{
	var default_game_id = 0;
}
default_datalist_ajax_url = datalist_ajax_url+'&game_id='+default_game_id;
data_list_sel='#data_list ';

window.onload=function(){
	
	table_editors = genEditorTable(data_list_sel ,default_datalist_ajax_url, 
		[
			{
				"width":"8%",
				"label": "游戏id:",
				"name": "product_id",
				"type":"select",
				"search": true,
				"editable" : false,
			},
			{
				"width":"10%",
				"label": "渠道ID",
				"name": "id",
				"type":"hidden",
				"search": true,
				"render":function(val,type,row){
					return val+" — "+row.name;
				}
			},
			{
				"width":"8%",
				"label": "渠道名",
				"name": "name",
				"in_table": false,
				//"editable" : false,
                "search": true
			},	
			{
				"width":"8%",
				"label": "渠道标识",
				"name": "code",
				"editable" : false,
                "search": true
			},	
			{
				"width":"8%",
				"label": "状态",
				"name": "open_flag",
				//"in_table":false,
				"search": false,
				"type":"select",
				
				"render":function(val,type,row){
					if(val == '1'){
						return '打开';
					}else if(val == '2'){
						return '关闭';
					}else if(val == '0'){
						return '删除';
					}else{
						return val;
					}
				},
				
				"options": [
					{ "label": "打开", "value": "1" },
					{ "label": "关闭", "value": "2"},
					{ "label": "删除", "value": "0"}
				]
			},
			{
				"width":"8%",
				"label": "平台类型",
				"name": "plattype",
				"type":"select",
				"search": false,
				"render":function(val,type,row){
					if(val == '1'){
						return 'Android';
					}else if(val == '2'){
						return 'iOS';
					}else if(val == '3'){
						return '越狱';
					}else{
						return val;
					}
				},
				"options": [
					{ "label": "Android", "value": "1" },
					{ "label": "iOS", "value": "2"},
					{ "label": "越狱", "value": "3"}
				]
			},
			{
				"width":"13%",
				"label": "渠道包地址",
				"in_editor": false,
				"name": "package_url",
			},
			{
				"width":"13%",
				"label": "CDN地址",
				"in_editor": false,
				"name": "cdn_url",

			},
			{
				"width":"13%",
				"label": "渠道包状态",
				"in_editor": false,
				"name": "state_note",
				//"search": true
			},
			{
				"width":"10%",
				"label": "打包任务状态",
				"in_editor": false,
				"name": "package_state_note",
				//"search": true
			}
// 			,{
// 				"label": "渠道字典ID:",
// 				"name": "config_id"
// 			}
			,{
                "width":"13%",
				"label": "操作:",
				"name": "operation",
				"in_editor":false,
				//"search": true
			}
		],
		{
			"privilege":js_privilege,
			//"allow_print":true,
			//"disable_keyup_search":true,
			"serverSide":true,
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);
	
	oTable = table_editors[0];
	// 按游戏过虑================
	applyCiteCasMenu("#cite_filter","?m=cps_manage&c=cm_games&a=gameOptionsList",default_game_id );
}


function applyCiteCasMenu(selctorStr,source,defaultId){
	catalog_filter=$(selctorStr).cas_menu({ 
		source			:	source,  
		rootId			:   0,//
		defaultId		:  defaultId,//
		inputCtlName	:	'cite_ids[]',
		selectAllOption	:	{label: _lan_trans(".LAN_PleaseSelect","请选择"),value:0},
		fnUserOnchange:function(curSel){
			if(!curSel)	curSel=0;
			//更新引用
			cur_game_id=curSel;
			//alert(cur_game_id); 
			
			var settings=oTable.fnSettings();
			oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
		},
	});
}
// 重新拉取渠道================
function fetchUnionlist( ){
	if(!cur_game_id){
		alert("请选择一个游戏"); 
		return;
	}
	if( $("#fetch-unionlist-btn i").hasClass("fa-spin") ){
		alert("已在加载中，请勿重复点击");
		return;
	}
	var url = "?m=cps_manage&c=cm_unionlist&a=fetchUnionlist&game_id="+cur_game_id;
	url += "&user_name=" + $("#form-field-name").val();
	url += "&user_pass=" + $("#form-field-pass").val();
 	
	//alert(url);
	
	$("#fetch-unionlist-btn i").addClass("fa-spinner fa-spin red");
	$("#fetch-unionlist-btn span").text("加载中……"); 
	//刷新选中游戏下的渠道列表 
	$.ajax({async: true, type : "get",url: url, data:{user_name:$("#form-field-name").val(),user_pass:  $("#form-field-pass").val() }, 
		dataType : 'json',  
		success : function(result) {//$("#footer").html(data);
			$("#fetch-unionlist-btn i").removeClass("fa-spinner fa-spin red");
			$("#fetch-unionlist-btn span").text("重新拉取渠道列表");  
			
			if(result.code==0){
				//alert(result.data.game_id);
				alert("数据拉取完成");
				oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
			}else{
				alert("错误："+result.msg);
			}
			
			return;
		} 
	});//END ajax
}

// 重新生成 URL
function getNewListAjaxUrl(){
	var tmp_para="";
	if(!!cur_game_id  ){
		tmp_para="&game_id="+cur_game_id ;
	} 
	var newUrl=datalist_ajax_url+tmp_para;
	//alert(newUrl);
	return newUrl;
}









