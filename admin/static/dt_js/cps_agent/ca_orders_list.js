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
	current_status = 0
	current_stat_data = false;//缓存下统计数据
	
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
					"label": "用户名",
					"name": "user_name",
					"search":search ? true:false
					
				},
				{
					"label": "充值渠道",
					"name": "channel",
					"in_table" : false
				} ,
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
				},
				{
					"label": "订单状态",
					"name": "payState",
					"search":search ? true:false,
					"render":function ( val, type, row ) { 
						if(agent_view){
							if(val == 1){  
								 return '下单';
							 }else if(val = 2){ 
								return "支付"
							 }else if(val = 3){ 
								return "完成"
							 }
							 
							 return '其它';
						}else{
							if(val == 1){   
								return '下单'
							 }else if(val = 2){ 
								return "支付"
							 }else if(val = 3){ 
								return "完成"
							 }
							 return val;
						}
						 
					}
				},
 
		
		],
		{
			"privilege":js_privilege,
			"allow_print":true,
			"serverSide":true,
			"tableOnly":true,
			"columnDefs":[{orderable:false, targets:[0,1,2,3,4,5,6]  }],
			"disable_keyup_search":true,
			"row_select":"none",
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);//end genEditorTable
	
	
	oTable = table_editors[0];


	//==========时间	
	var picker_from = $("#datetimepicker1").val(time_from_string)
		.datetimepicker({
			language: 'ch',//显示中文
			format: 'yyyy-mm-dd',//显示格式
			minView: "month",//设置只显示到月份
			initialDate: new Date(),//初始化当前日期
			autoclose: true,//选中自动关闭
			endDate:time_from_string,
			todayBtn: true,//显示今日按钮
  		})
  		.on('changeDate', function(ev){ 
        	timeConditionChanged(picker_from.val(), picker_to.val() )
        	
		});
  		
	var picker_to = $("#datetimepicker2").val(time_to_string)
		.datetimepicker({
			language: 'cn',//显示中文
			format: 'yyyy-mm-dd',//显示格式
			minView: "month",//设置只显示到月份
			initialDate: new Date(),//初始化当前日期
			autoclose: true,//选中自动关闭
			todayBtn: true	, //显示今日按钮
			endDate:time_to_string,
			hourStep: 1,
			minuteStep: 15,  
			secondStep: 30,  
			inputMask: true
  		}) .on('click', function(ev){
        	picker_to.datetimepicker("setStartDate", picker_from.val() )
		})
  		.on('changeDate', function(ev){ 
 			//alert(new Date(picker_from.val()).valueOf()/ 1000 ) //多8小时 
			//alert(ev.date.valueOf() / 1000 );
        	timeConditionChanged(picker_from.val(), picker_to.val() )
        	
		});
		
	
	$("#datetimepicker1").next(".fa-calendar").on("click",function(e){ picker_from.datetimepicker("show") });
	$("#datetimepicker2").next(".fa-calendar").on("click",function(e){ picker_to.datetimepicker("show") });
	
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
	//===========结算状态
	var filter_status  = $("#filter-status");
	filter_status.change(function(){
		current_status = this.value
		refreshDatas()
	});


	caculate();	
	
	
	
}

//========执行单条 
function doOption(action, id){
 
	var url =  controller_url + "&a="+action+"&agent_id="+agent_id + "&id=" +  id;
 
	$.ajax({async: true, type : "get",url:url, data:{}, 
		dataType : 'json',  
		success : function(result) {
			if(result.code==0){  
				// 更新余额
				$("#id-mycoins").text("￥"+result.data.user_coins);
				refreshDatas();
				alert("成功")
			}else{
				alert("错误："+result.msg);
			}
		
			return;
		} 
	});//END ajax
}

 
//========计算结果+++++++++++++++++
function caculate(){
	if(!controller_url){
		alert("controller_url 地址错误");
		return;
	}
	var rebate_container = $("#rebate-stat") ;
	rebate_container.html("");
	var url = getNewListAjaxUrl( controller_url + "&a=orders_calc" );
	//刷新计算结果
	$.ajax({async: true, type : "get",url:url, data:{}, 
		dataType : 'json',  
		success : function(result) { 

			if(result.code==0){  
				current_stat_data = result.data;//
				
				$("#id-ordernum").text(result.data.count);
				$("#id-amount").text(result.data.amount);
				$("#id-oids").text(result.data.oids);
				$("#id-mycoins").text(result.data.user_coins);
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

// 重新生成 URL
function getNewListAjaxUrl(base_url){
	var tmp_para="";
	if(!!time_from_string && !!time_to_string ){
		tmp_para="&time_from="+time_from_string + "&time_to="+time_to_string;
	}
	if(!!agent_id){
		tmp_para += "&agent_id="+agent_id
	}
	
	if( current_union_id != 0 ){
		tmp_para += "&union_id="+current_union_id
	}
	
	if( current_status != '' ){
		tmp_para += "&settle_status="+current_status
	}
	if(!!base_url)
		return base_url+tmp_para;

	var newUrl=datalist_ajax_url+tmp_para;

	return newUrl;
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


