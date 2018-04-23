window.onload=function(){
	var type_list = js_para.type_list;
	if(type_list.length === 0){
		  type_list = false
	}else{
		  type_list["_EMPTY_STRING_"]="全部";
	}
	table_editor = genEditorTable('#data_list' ,"?m=cps_manage&c=cm_actionlog&a=index_ajax", 
		[
			{
				"label": "ID",
				"name": "id",
				"width":"8%",
				"search":true
			},
			{
				"label": "时间",
				"name": "time",
				"width":"15%",
				"search":true
			},
			{
				"label": "类型",
				"name": "type",
				"search": type_list,
				"width":"15%"
			}, 
			{
				"label": "操作员",
				"name": "user_name",
				"search":true,
				"width":"15%"
			}, 
			{
				"label": "操作概要",
				"name": "title",
				"search":true
			},
			{
				"label": "操作",
				"width":"10%",
				"name":"id",
				"render": function(val,type,row){return '<a href="?m=cps_manage&c=cm_actionlog&a=browseLogDetail&id='+val+'"><span class="LAN_ViewDetails">查看详情</span></a>'},
            }
		],
		{
			"privilege":js_privilege,
			"serverSide":true,
			"tableOnly":true,
			"columnDefs":[{orderable:false, targets:[0,1,2,3,4 ]  }],
			"disable_keyup_search":true,
			"row_select":"none",
			"order":[[ 0, 'desc' ]],
			"initComplete":  function( settings, json ) {
				 	$("#data_list_filter").hide(); 
			}
		}
	);//end genEditorTable
	
	oTable = table_editor[0];

}

function dt_view(id){window.location.href="?m=cps_manage&c=cm_actionlog&a=browseLogDetail&id="+id;}












