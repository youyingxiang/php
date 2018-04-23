<?php 
/**
*	后台主菜单配置
*	@乔成磊 20150816
*/

return array( //BEGIN MENU!!!


/*
*	CPS管理
*/
"mmenu_cps_manage"=>[
	"auth"=>["m"=>"cps_manage","type"=>"m"],
	"name"=>"CPS管理",
	"icon"=>'<i class="menu-icon fa fa-eye"></i>',
	"submenu"=>array(

		/*
		*
		*/
			"mmenu_cps_manage_notice"=>[//key是ID
					"auth"=>["c"=>"cm_notice","type"=>"mc"],
					"name"=>"公告管理",
					"submenu"=>array(),
			],

		/*
		*
		*/
			"mmenu_cps_manage_level"=>[//key是ID
					"auth"=>["c"=>"cm_level","type"=>"mc"],
					"name"=>"用户等级管理",
					"submenu"=>array(),
			],

		/*
		*
		*/
			"mmenu_cps_manage_recharge"=>[//key是ID
					"auth"=>["c"=>"cm_recharge","type"=>"mc"],
					"name"=>"充值管理",
					"submenu"=>array(),
			],

		/*
		*
		*/
			"mmenu_cps_manage_club"=>[//key是ID
					"auth"=>["c"=>"cm_club","type"=>"mc"],
					"name"=>"俱乐部管理",
					"submenu"=>array(),
			],
		/*
		* 
		*/
		"mmenu_cps_manage_agent"=>[//key是ID
			"auth"=>["c"=>"cm_agent","type"=>"mc"],
			"name"=>"代理商管理",
			"submenu"=>array(),
		],
		
		/*
		*	CM 游戏管理
		*/
		"mmenu_cps_manage_games"=>[//key是ID
			"auth"=>["c"=>"cm_games","type"=>"mc"],
			"name"=>"游戏管理",
			"submenu"=>array(),
		],

		
		/*
		*	返利配置
		*/
		"mmenu_cps_manage_rebate"=>[//key是ID
			"auth"=>["c"=>"cm_rebate","type"=>"mc"],
			"name"=>"返利配置",
			"submenu"=>array(),
		],
		
		/*
		*	渠道列表
		*/
		"mmenu_cps_manage_unionlist"=>[//key是ID
			"auth"=>["c"=>"cm_unionlist","type"=>"mc"],
			"name"=>"渠道列表",
			"submenu"=>array(),
		],

		/*
		*	提现申请
		*/
//		"mmenu_cps_manage_withdraw"=>[//key是ID
//			"auth"=>["c"=>"cm_withdraw","a"=>"withdraw","type"=>"mc"],
//			"name"=>"代理商提现申请",
//			"submenu"=>array(),
//		],
		/*
		*	CM 结算单列表
		*/
			"mmenu_cps_manage_settlement"=>[//key是ID
					"auth"=>["c"=>"cm_settlement","type"=>"mc"],
					"name"=>"结算管理",
					"submenu"=>array(),
			],
		/*
		*	订单明细查询
		*/
		"mmenu_cps_agent_orders"=>[//key是ID
			"auth"=>["c"=>"cm_orders","type"=>"mc"],
			"name"=>"订单明细查询",
			"submenu"=>array(),
		],

			"mmenu_cps_manage_apply"=>[//key是ID
					"auth"=>["c"=>"cm_apply","type"=>"mc"],
					"name"=>"申请列表",
					"submenu"=>array(),
			],
		
		//操作日志
		"mmenu_cps_oplog"=>[
				"auth"=>["c"=>"cm_actionlog","type"=>"mc"],
				"name"=>"操作日志",
				"submenu"=>array(),
		],
		
	)
	
],//END CPS管理
	
	
	
/*
*	CPS代理
*/
"mmenu_cpsagent"=>[
	"auth"=>["m"=>"cps_agent","type"=>"m"],
	"name"=>"CPS代理商",
	"icon"=>'<i class="menu-icon fa fa-desktop"></i>',
	"submenu"=>array(
	
		/*
		*	CA 我的渠道
		*/
		"mmenu_ca_unions"=>[//key是ID
			"auth"=>["c"=>"ca_unions","type"=>"mc"],
			"name"=>"我的渠道",
			"submenu"=>array(),
		],
		
		/*
		*	CA 我的用户
		*/
		"mmenu_ca_users"=>[//key是ID
			"auth"=>["c"=>"ca_users","type"=>"mc"],
			"name"=>"我的用户",
			"submenu"=>array(),
		],
		
		/*
		*	CA 用户订单
		*/
		"mmenu_ca_orders"=>[//key是ID
			"auth"=>["c"=>"ca_orders","type"=>"mc"],
			"name"=>"用户订单",
			"submenu"=>array(),
		],

		/*	CA 代理商充值
		*/
		"mmenu_ca_recharge"=>[//key是ID
			"auth"=>["c"=>"ca_recharge","type"=>"mc"],
			"name"=>"代理商充值",
			"submenu"=>array(),
		],

		/*
		*	CA 用户结算单
		*/
			"mmenu_ca_settlement"=>[//key是ID
					"auth"=>["c"=>"ca_apply","type"=>"mc"],
					"name"=>"我的结算单",
					"submenu"=>array(),
			],
	)
	
],//END CPS管理
	

/*
*	系统设置
*/
"mmenu_system"=>[
	"auth"=>["m"=>"admin","type"=>"m"],
	"name"=>"系统设置",
	"icon"=>'<i class="menu-icon fa fa-cog"></i>',
	"submenu"=>array(
	
		/*
		*	首页
		*/
		"mmenu_index"=>[//key是ID
			"auth"=>["m"=>"index","type"=>"m"],
			//"icon"=>'<i class="menu-icon fa fa-user"></i>',
			"name"=>"我的",
			"submenu"=>array(
				"mmenu_my_info"=>[
						"auth"=>["c"=>"home","a"=>"modify","type"=>"mca"],
						"name"=>"修改个人信息",
						"submenu"=>array(),
				],
		
				"mmenu_my_pass"=>[
						"auth"=>["c"=>"login","a"=>"change_pass","type"=>"mca"],
						"name"=>"修改密码",
						"submenu"=>array(),
				],
			),
		],

		//操作日志
		"mmenu_oplog"=>[
				"auth"=>["m"=>"admin","c"=>"action_log","type"=>"mc"],
				"name"=>"操作日志",
				"submenu"=>array(),
		],
		
		//系统变量
		"mmenu_sys_vars"=>[
				"auth"=>["m"=>"admin","c"=>"system","type"=>"mc"],
				"name"=>"系统变量",
				"submenu"=>array(),
		],
		
		//后台用户管理
		"mmenu_sysuser_manage"=>[
		
				"auth"=>["m"=>"sysuser","type"=>"m"],
				"name"=>"后台用户管理",
				//"icon"=>'<i class="menu-icon fa fa-user"></i>',
				"submenu"=>array(
					//用户管理
					"mmenu_sysuser_info"=>[
							"auth"=>["c"=>"adminIndex","type"=>"mc"],
							"name"=>"用户管理",
							"submenu"=>array(),
					],
					
					//角色管理
					"mmenu_sysuser_role"=>[
							"auth"=>["c"=>"role","type"=>"mc"],
							"name"=>"角色管理",
							"submenu"=>array(),
					],
					
					//权限管理
					"mmenu_sysuser_privilege"=>[
							"auth"=>["c"=>"privilege","type"=>"mc"],
							"name"=>"权限管理",
							"submenu"=>array(),
					],
				),
		],//END 后台用户管理
		
		
	)
	
],//END 系统设置


	
	
);//END MENU!!!