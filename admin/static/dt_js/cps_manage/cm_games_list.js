window.onload=function(){


	genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_games&a=index_ajax", 
		[
			{
				"label_editor": "游戏ID(<font color=red>详询技术</font>):",
				"label": "游戏ID:",
				"name": "game_id",
				"editable": false,
				"search": true
			},
			{
				"label": "游戏名称:",
				"name": "game_name",
				"search": true
			},
			{
				"label": "游戏域名:",
				"name": "game_domain",
				"search": true
			},
			{
				"label": "操作:",
				"name": "game_operation",
				"in_editor":false,
				//"search": true
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









