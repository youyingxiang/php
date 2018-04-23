cur_game_id=false; 
parent_id = js_para.parent_id;
datalist_ajax_url="index.php?m=cps_manage&c=cm_childunionlist&a=index_ajax&parent_id="+parent_id;
data_list_sel='#data_list ';

window.onload=function(){
	
	table_editors = genEditorTable(data_list_sel ,datalist_ajax_url, 
		[
			{
				"width":"8%",
				"label": "id",
				"name": "id",
				"search": true,
				"type":"hidden",
				//"in_editor": false,
			},
			{
				"width":"10%",
				"label": "渠道名",
				"name": "name",
				//"in_table":false,
				"search": true
			},
            {
                "width":"8%",
                "label": "渠道标识",
                "name": "code",
				"editable" : false,

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
				"name": "package_url",
				"in_editor":false,
			},
			{
				"width":"13%",
				"label": "CDN地址",
				"name": "cdn_url",
				"in_editor":false,

			},
			{
				"width":"13%",
				"label": "渠道包状态",
				"name": "state_note",
				"in_editor":false,
				//"search": true
			},
			{
				"width":"10%",
				"label": "打包任务状态",
				"name": "package_state_note",
				"in_editor":false,
				//"search": true
			},
			{
				"width":"15%",
				"label": "操作",
				"name": "operation",
				"in_editor":false,
				//"search": true
			}
		
// 			,{
// 				"label": "渠道字典ID:",
// 				"name": "config_id"
// 			}
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
}





