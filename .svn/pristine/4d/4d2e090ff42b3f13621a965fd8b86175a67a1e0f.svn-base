controller_url = false;
agent_id =false;
agent_view = true;
window.onload=function(){ 
	datalist_ajax_url = js_para.ajax;
	controller_url = 	js_para.controller_url;
	
	time_from_string = js_para.time_from;
	time_to_string = js_para.time_to;
	agent_view = js_para.agent_view;
	current_union_id = 0
	current_stat_data = false;//缓存下统计数据
	rm = js_para.m;
	search =  !!js_para.search;
	mygames = js_para.mygames;
	mygames[0]="所有游戏";
	
	myunions = js_para.myunions;
	myunions[0]="所有渠道";
	agent_id = js_para.agent_id;
	table_editors = genEditorTable('#data_list' , getNewListAjaxUrl() , 
		[ 
				{
					"label": "游戏",
					"name": "productID",
					"search": search ? mygames :false,
					"render":function ( val, type, row ) {
						 if(mygames[val])
							return mygames[val] 
						 return val;
					}
				},
				{
					"label": "渠道ID",
					"name": "union_id",
					"search":  search ? myunions :false ,
					"render":function ( val, type, row ) { 
						 if(myunions[val])
							return myunions[val] 
						 return val;
					}
				},
				{
					"label": "订单号",
					"name": "order_id",
					"search":search ? true:false
				},
				{
					"label": "支付时间",
					"name": "payOrderTime",
					"type": "datetime",
					"width":"15%",
					'format':'YYYY-MM-DD HH:mm:ss'	,
					//"search":true,
					"def":       function () { return new Date(); },
// 					"search":["text",function(oTable,  value, idx){
// 						var r = parseInputTimeString();
//
// 						if(r.status == 0){
// 							oTable.fnFilter(  r.value , idx );
// 						}else{
// 							alert(r.msg);
// 						}
// 					}]
				
				},
				{
					"label": "金额",
					"name": "amount"
				}

 
		
		],
		{
			"privilege":js_privilege,
			"allow_print":true,
			"serverSide":true,
			"tableOnly":true,
			"disable_keyup_search":true,
			"row_select":"none",
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);//end genEditorTable
	
	
	oTable = table_editors[0];

	
	//解决默认左右箭头不显示的问题
	$(".icon-arrow-right").addClass("glyphicon-forward ");
	$(".icon-arrow-left").addClass("glyphicon-backward ");

	//==========渠道 
	var filterch  = $("#filter-channel");
	for( var union_id in myunions ){
		$("<option value='"+union_id+"'>"+myunions[union_id]+"</option>").appendTo( filterch );
	}
	filterch.change(function(){
		current_union_id = this.value
		refreshDatas()
	});
	caculate();

	
}

 
//========计算结果+++++++++++++++++
function caculate(){
	if(!controller_url){
		alert("controller_url 地址错误");
		return;
	}
	var rebate_container = $("#rebate-stat") ;
	rebate_container.html("");
	var url = getNewListAjaxUrl( controller_url + "&a=apporder_calc&rm="+rm );
	//刷新计算结果
	$.ajax({async: true, type : "get",url:url, data:{}, 
		dataType : 'json',  
		success : function(result) {
			if(result.code==0){
				current_stat_data = result.data;//

				$("#id-ordernum").text(result.data.count);
				$("#id-amount").text(result.data.amount);
				$("#id-oids").text(result.data.oids);
				$("#id-status").html(result.data.s_status);
				$("#id-deduct").text(result.data.deduct);
			}else{
				alert("错误："+result.msg);
			}

			return;
		} 
	});//END ajax
}


//===================刷新列表
function refreshDatas(){
	var settings=oTable.fnSettings();
	oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
	caculate()
}

function timeConditionChanged(from,to){
	time_from_string = from;
	time_to_string = to; 
	refreshDatas();
}

//结算
function doOption(action, id){
	cancelBubble();
	var url =  controller_url + "&a="+action + "&settlement_id=" +  id;
	//alert(action);
	if(action == "confirm_settlement"){
		if(!confirm("确定已经给用户结算完成？")){
			return;
		}
	}else if(action == "deny_settlement"){
		var refuse_msg = window.prompt("请输入拒绝原因", "")
		if(!refuse_msg) return;
		url += "&refuse_msg=" + refuse_msg;
	}
	//alert(1);
	$.ajax({async: true, type : "get",url:url, data:{},
		dataType : 'json',
		success : function(result) {
			if(result.code==0){
				// 更新余额
				refreshDatas();
				alert("成功")
			}else{
				alert("错误："+result.msg);
			}
			return;
		}
	});//END ajax
}

// 重新生成 URL
function getNewListAjaxUrl(base_url){
	var tmp_para="";
	if(!!agent_id){
		tmp_para += "&agent_id="+agent_id
	}
	
	if( current_union_id != 0 ){
		tmp_para += "&union_id="+current_union_id
	}

	if(!!base_url)
		return base_url+tmp_para;

	var newUrl=datalist_ajax_url+tmp_para;

	return newUrl;
}


function settle(id){
	var url = "index.php?m=cps_manage&c=cm_settlement&a=confirm_settlement&settlement_id=" +  id;
	//alert(action);
	if(!confirm("确定已经给用户结算完成？")){
		return;
	}
	//alert(1);
	$.ajax({async: true, type : "get",url:url, data:{},
		dataType : 'json',
		success : function(result) {
			if(result.code==0){
				alert("成功")
			}else{
				alert("错误："+result.msg);
			}
			return;
		}
	});//END ajax
}



		




// 
// function parseInputTimeSearchString(value){
// 	var status = 1 , msg="error",type = 1 , year =1970, month =1 , day=1, hour=0, minute=0, second=0;
// 	//TODO: 解决时间问题 
// 	//r = isSearchDate("2017-05-01")			
// 	
// 	var reg_YYYYMM   = /^(\d{1,4})(-|\/)(\d{1,2})\2$/;  //YYYY-MM 
// 	var reg_YYYYMMDD = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;  //YYYY-MM-DD
// 	var reg_YYYYMMDDhh = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;  //YYYY-MM-DD hh:mm:ss
// 	var r = null;
// 	if( r = str.match(reg_YYYYMM) ){
// 		year = int( r[1] );
// 		month = int( r[3] );
// 		type = 1;
//     }else if(r = str.match(reg_YYYYMMDD)){
// 		year = int( r[1] );
// 		month = int( r[3] );
// 		day = int( r[4] );
// 		type = 2;
//     	
//     }else if(r = str.match(reg_YYYYMMDDhh)){
// 		year = int( r[1] );
// 		month = int( r[3] );
// 		day = int( r[4] );
// 		hour = int( r[5] );
// 		type = 3;
//     	
//     }else{ 
//         return {"status":1 ,"msg":'对不起，您输入的日期搜索格式符合规范!'}
//     }
// 	
// 	if(month>12 || month < 1){
//         return {"status":1 ,"msg":'搜索月份 必须在1~12 之间!'}
// 	}else if(day<1 || day>31){
//         return {"status":1 ,"msg":'搜索 天 必须在1~31 之间!'}
// 	}else if(hour<0 || hour>24){
//         return {"status":1 ,"msg":'搜索 小时 必须在0~24 之间!'}
// 	}else{ 
// 		status = 0;
// 		msg="success"; 
// 	}
// 	var commonTime = new Date(Date.UTC(year, month - 1, day, hour, minute, second))
// 	return {"status":status,"msg":msg,"value":commonTime,"data": [year, month , day, hour, minute, second]}
// }


