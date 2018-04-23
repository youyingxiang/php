

window.onload=function(){

	
	table_editors = genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_agent&a=index_ajax", 
		[
			{
				"label": "ID",
				"name": "id",
				"in_editor": false //必须是false,不然新建用户会消失（没有角色信息）
			},
			{
				"label": _lan_trans(".LAN_UserName","用户名"),
				"name": "user_name",
				"editable":false,
				"search":true
// 				"search":["text",function(oTable,  value, idx){
// 					 alert(value+"--fn1");
// 					oTable.fnFilter(  value, idx );
// 				}]
			},
			{
				"label": _lan_trans(".LAN_Nickname","昵称"),"name": "nick_name",
				"search":true
//  			"search":["text",function(oTable,  value, idx){
// 					 alert(value+"--fn2"); 
// 					oTable.fnFilter(  value, idx );
// 				}]
			},
			{
				"label":  "身份证" ,
				"name": "id_no",
				"search":true 
			},
			{
				"label":  "代理商级别" ,
				"name": "user_level",
				"type":"select",
			},
			{
				"label": _lan_trans(".LAN_Password","密码"),
				"name": "user_pwd",
				"type":"password",
				"in_table":false
			},
			{
				"label": _lan_trans(".LAN_Mobile","电话号码"),
				"name": "phone",
				"search":true
			},
			{"label": _lan_trans(".LAN_Email","邮箱地址"),"name": "email"},
			{"label": _lan_trans(".LAN_User","用户")+_lan_trans(".LAN_Type","类型"),"name": "user_type","default":"admin",
				"type":"hidden",
				"in_table":false
			
			},	
			{	"label": "平台币",
				"name": "user_coins",
				"default":"0.00",
				"type":"hidden"
			
			},
			{
				"label": _lan_trans(".LAN_Gender","性别"),
				"name": "gender",
				"type": "select",
				"options": [
					{ "label": _lan_trans(".LAN_Woman","女士"), "value": "female" },
					{ "label": _lan_trans(".LAN_Man","男士"), "value": "male"} 
				],
				"in_table":false
			},
			{	
				"label": "Leader",
				"name": "manager.user_name",
				"editor_name": "leader",
				"type":"select",
				"in_table":false
			},				
			{
				"label": _lan_trans(".LAN_Role","角色"),
				"editor_name": "tb_sys_role[].id", 
				"name": "tb_sys_role",
				"render": "[, ].role_name",
				"class":"td_center" ,
				"width":"20%",
				"type": "checkbox"
			},
			{//操作
				"label":"操作",
                "in_editor":false,
                "name": null,  
                "class": "center",
				"width":"20%",
				"render": function ( val, type, row ) {
					var ops=
					   '<a href="javascript:void(0)" onclick="goOption(\'relatedUnion\',\''+row.id+'\')"><span class="LAN_">关联渠道</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goOption(\'orders\',\''+row.id+'\')"><span class="LAN_">订单</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goOption(\'users\',\''+row.id+'\')"><span class="LAN_">用户</span></a> '
					+'/ <a href="javascript:void(0)" onclick="gosettleOption(\'users\',\''+row.id+'\')"><span class="LAN_">结算单</span></a> '  ;
					 
					return  ops;
				}
                
            },//end 操作

		],
		{
			"privilege":js_privilege,
			//"allow_print":true,
			//"disable_keyup_search":true,
			"initComplete":  function( settings, json ) { 				
					$("#data_list_filter").hide(); 
				 	var editors = table_editors[1];

					editors[0].field('tb_sys_role[].id').update( json.tb_sys_role );
					editors[0].field('leader').update( json.userlist);

					editors[1].field('tb_sys_role[].id').update( json.tb_sys_role );
					editors[1].field('leader').update( json.userlist);
			},

			
		}
	); 

}


//user_id 即为代理商id
function goOption(action,agent_id){
	cancelBubble();
	jump("?m=cps_manage&c=cm_agent&a="+action+"&agent_id="+agent_id);
}


//user_id 即为代理商id
function gosettleOption(action,agent_id){
	cancelBubble();
	jump("?m=cps_manage&c=cm_settlement&agent_id="+agent_id);
}

