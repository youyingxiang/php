
var time_from_string = false;
var time_to_string = false;
var datalist_ajax_url = "index.php?m=cps_manage&c=cm_orders&a=index_ajax";

window.onload=function(){  
		
	time_from_string = js_para.time_from;
	time_to_string = js_para.time_to;		
	table_editors = genEditorTable('#data_list' ,getNewListAjaxUrl() , 
		[
				{
					"label": "渠道ID",
					"name": "union_id",
					"search":true
				},
				{
					"label": "游戏ID",
					"name": "productID",
					"search":true
				},
				{
					"label": "服ID",
					"name": "serverID"
				},
				{
					"label": "订单号",
					"name": "order_id",
					"width":"10%",
					"search":true
				},
				{
					"label": "支付单号",
					"width":"10%",
					"name": "extendbox",
					"search":true
				},
				{
					"label": "用户ID",
					"name": "ktuid" ,
					"search":true
				},
				{
					"label": "充值时间",
					"name": "payOrderTime",
					"type": "datetime",
					'format':'YYYY-MM-DD HH:mm:ss'	,
					"def":       function () { return new Date(); },
				},
				{
					"label": "金额",
					"name": "amount"
				},
				{
					"label": "状态",
					"name": "payState",
					"type": "hidden",
					"render":function(val,type,row){
							var ret = (val==3)?  '成功':'未成功('+val+')';
							return ret;
						} 
				},
				{
					"label": "ID",
					"name": "id",
					"type":"hidden",
					"in_table":false
				},
		
		],
		{
			"privilege":js_privilege,
			"allow_print":true,
			"serverSide":true,
			"disable_keyup_search":true,
			"initComplete":  function( settings, json ) {
				 $("#data_list_filter").remove(); 
			}
		}
	);
	
	oTable = table_editors[0]; 
	
	var picker_from = $("#datetimepicker1").val(time_from_string)
		.datetimepicker({
			language: 'ch',//显示中文
			format: 'yyyy-mm-dd hh:ii:ss',//显示格式
			minView: "hour",//设置只显示到月份
			initialDate: new Date(),//初始化当前日期
			autoclose: true,//选中自动关闭
			endDate: time_from_string,
			todayBtn: true,//显示今日按钮
  		})
  		.on('changeDate', function(ev){ 
        	timeConditionChange(picker_from.val(), picker_to.val() )
        	
		});
	var picker_to = $("#datetimepicker2").val(time_to_string)
		.datetimepicker({
			language: 'cn',//显示中文
			format: 'yyyy-mm-dd hh:ii:ss',//显示格式
			minView: "hour",//设置只显示到月份
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
        	timeConditionChange(picker_from.val(), picker_to.val() )
        	
		});
	
  	$("#datetimepicker1").next().on("click",function(e){ picker_from.datetimepicker("show") });
  	$("#datetimepicker2").next().on("click",function(e){ picker_to.datetimepicker("show") });
  	
	//解决默认左右箭头不显示的问题
	$(".icon-arrow-right").addClass("glyphicon-forward");
	$(".icon-arrow-left").addClass("glyphicon-backward");
} 

function timeConditionChange(from,to){
	time_from_string = from;
	time_to_string = to; 
	
	var settings=oTable.fnSettings();
	oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
}
// 重新生成 URL
function getNewListAjaxUrl(){
	var tmp_para="";
	if(!!time_from_string && !!time_to_string ){
		tmp_para="&time_from="+time_from_string + "&time_to="+time_to_string;
	} 
	var newUrl=datalist_ajax_url+tmp_para;
	//alert(newUrl);
	return newUrl;
}

