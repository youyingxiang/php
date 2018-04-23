window.onload=function(){  
	
	genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_rebate&a=index_ajax", 
		[

			{
				"label": "ID:",
				"name": "id",
				"in_table":false,
				"type":"hidden",
			},
			{
				"label": "游戏ID:",
				"name": "appid",
				"type":"hidden",

			},
			{
				"label": "渠道标识:",
				"name": "channel_code",
				"type":"hidden",
			},

			{
				"label": "渠道ID:",
				"name": "channel_id",
				"type":"select",
				"editable":false,
			},
			{
				"label": "返利比例:",
				"name": "channel_discount"


			} ,
			{
				"label": "代理商提成比例:",
				"name": "agent_discount"

			} ,
			{
				//平台标识（1：安卓 2：ios 3：越狱）
				"label": "平台类型:",
				"name": "plattype",
				"type":"select",
				"render":function(val,type,row){
					if(val == '1'){
						return '安卓';
					}else if(val == '2'){
						return 'ios';
					}else if(val == '3'){
						return '越狱';
					}else{
						return val;
					}
				},
				"options": [
					{ "label": _lan_trans(".LAN_Week","安卓"), "value": "1" },
					{ "label": _lan_trans(".LAN_Monthly","ios"), "value": "2"},
					{ "label": _lan_trans(".LAN_Immediate","越狱"), "value": "3"}
				]
			} ,
				{

					"label": "状态:",
					"name": "open_flag",
					"type":"select",
					"render":function(val,type,row){
						if(val == '1'){
							return '开启';
						}else if(val == '2'){
							return '关闭';
						}else if(val == '0'){
							return '删除';
						}else{
							return val;
						}
					},
					"options": [
						{ "label": _lan_trans(".LAN_Week","开启"), "value": "1" },
						{ "label": _lan_trans(".LAN_Monthly","关闭"), "value": "2"},
						{ "label": _lan_trans(".LAN_Immediate","删除"), "value": "0"}
					]
				},
		
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