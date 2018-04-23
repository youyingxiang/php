
window.onload=function(){

	var defSel	=	js_para['default'];
	$("#the_sels").val(defSel);
	var arrDef=explode(",",defSel);
	
	table_editors = genEditorTable('#data_list' ,"?m=cps_manage&c=cm_agent&a=union_list_ajax", 
		[
			
			{
				"label": "渠道ID:",
				"name": "id",
				"search": true
			},
			{
				"label": "渠道名称",
				"name": "name",
				"search": true
			},
			{
				"label": "游戏ID",
				"name": "product_id",
				"search": true
			},
		],
		{
			"privilege":js_privilege,
			"allow_print":true,
			//"disable_keyup_search":true,
			"tableOnly":true,
			"row_select": "multi",
			"initComplete": function ( settings, json ) {
				var nodes=oTable.fnGetNodes();
				for(var i=0,len=nodes.length;i<len;i++){
					var data = oTable.fnGetData( nodes[i] );
					if(in_array(data.id,arrDef)){
						 $(nodes[i]).addClass("active");
					}
				}
			} 
		}
	);
	
	oTable = table_editors[0];
	
// 	$("<tr>"
// 	+"<th style='text-align:center;' width='15%'>区域 ID</th>"
// 	+"<th style='text-align:center;'>区域名称</th>"
// 	+"<th style='text-align:center'>区域数据库</th>"
// 	+"<th  style='text-align:center'>后台地址</th>"
// 	+"<th  style='text-align:center'>服务器IP</th>"
// 	+"<th  style='text-align:center'>状态</th>"
// 	+"</tr>").appendTo(data_list_sel+' thead');
// 	
// 	var editor = new $.fn.dataTable.Editor( {
// 		"ajaxUrl": datalist_ajax_url,
// 		"domTable": "#data_list",
// 		"fields": [	],
// 		//"i18n":{"sUrl": "js/dataTables.editor.zh_CN.json"}
// 	} );
// 	
// 	//branchButtons = getBranchButtons(js_privilege,editor);
// 	 oTable=$(data_list_sel).dataTable({
// 		"sDom": "Tfrtip",
// 		"pageLength":20,
// 		"sAjaxSource":datalist_ajax_url,
// 		"aoColumns": [
// 			{"mData": "id","sClass": "td_center" },
// 			{"mData": "name","sClass": "td_center" }, //"sClass": "center"  clss名为center
// 			{"mData": "db_name","sClass": "td_center" },
// 			{"mData": "server_ip","sClass": "td_center" },
// 			{"mData": "admin_url","sClass": "td_center" },
// 			{"mData": "status","sClass": "td_center","mRender":function(val,type,row){
// 				if(val==0){return '封闭'}else{return '正常'};
// 			} }
// 		],
// 		"oTableTools": {
// 			"sRowSelect": "multi",
// 			"aButtons":{}
// 		},
// 		"oLanguage": {	"sUrl": "js/dataTables.zh_CN.json"},
// 		"initComplete": function ( settings, json ) {
// 			var nodes=oTable.fnGetNodes();
// 			for(var i=0,len=nodes.length;i<len;i++){
// 				var data = oTable.fnGetData( nodes[i] );
// 				if(in_array(data.id,arrDef)){
// 					 $(nodes[i]).addClass("active");
// 				}
// 			}
// 		} 
// 		
// 	} );


} 


function check_form() {
	var nodes=oTable.$("tr.active");
	var ids=new Array();
	for(var i=0,len=nodes.length;i<len;i++){
		var data = oTable.fnGetData( nodes[i] );
		ids.push(data.id);
	}
	var strIds=implode(",",ids);
	$("#the_sels").val(strIds);
	return true;
}