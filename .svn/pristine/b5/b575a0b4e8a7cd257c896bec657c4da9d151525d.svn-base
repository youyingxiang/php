
datalist_ajax_url = js_para.ajax;
agent_id = 	js_para.agent_id

window.onload=function(){ 

	table_editor = genEditorTable('#data_list' ,getNewListAjaxUrl( datalist_ajax_url ) , 
		[
			{
				"label": "用户ID",
				"name": "ktuid",
				"width":"20%"
			},
			{
				"label": "用户名",
				"name": "user_name",
				"search":true,
				"width":"20%"
			},
			{
				"label": "用户昵称",
				"name": "nick_name",
				"search":true,
				"width":"20%"
			},
			{
				"label": "手机",
				"name": "userphone",
				"search":true,
			}

		],
		{
			"privilege":js_privilege,
			"serverSide":true,
			"tableOnly":true,
			//"columnDefs":[{orderable:false, targets:[0,1,3,4,5]  }],
			"disable_keyup_search":true,
			"row_select":"none",
			"initComplete":  function( settings, json ) {
				$("#data_list_filter").hide(); 
			}
		}
	);//end genEditorTable
	 
 
}



// 重新生成 URL
function getNewListAjaxUrl(base_url){
	var tmp_para="";
// 	if(!!time_from_string && !!time_to_string ){
// 		tmp_para="&time_from="+time_from_string + "&time_to="+time_to_string;
// 	}
	if(!!agent_id){
		tmp_para += "&agent_id="+agent_id
	}
	 
	  
	return base_url+tmp_para; 
	 
}








