window.onload=function(){


	genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_attachment&a=index_ajax&id="+js_para.game_id, 
		[
			{
				"label": "附件ID",
				"name": "id",
				"search": true
			},
			{
				"label": "附件名称",
				"name": "name",
				"search": true
			},
			{
				"label": "附件类型",
				"name": "type",
				"search": true,
				"render":function(val,type,row){
					if(val == 'SourcePackage'){
						return '母程序包';
					}else if(val == 'keystore'){
						return 'keystore证书';
					}
				}
			},

			{
				"label": "对应游戏版本",
				"name": "version",
				"search": true
			},
			{
				"label": "附件备注",
				"name": "remark",
				"search": true
			},
			{
				"label": "操作",
				"name": "operation",
				"search": true
			} 
		],
		{
			"privilege":js_privilege,
			//"allow_print":true,
			//"disable_keyup_search":true,
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);
	
}









