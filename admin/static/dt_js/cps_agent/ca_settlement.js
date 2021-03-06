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
    current_status = 1;
    current_stat_data = false;//缓存下统计数据

    myunions = js_para.myunions;
    myunions[0]="所有渠道";
    agent_id = js_para.agent_id;

    search =  !!js_para.search;
    ot_status = js_para.s_status;
    table_editors = genEditorTable('#data_list' , getNewListAjaxUrl() ,
        [
            {
                "label": "结算开始日期",
                "name": "start_time",
                "search":search ? true:false,
            },
            {
                "label": "结算截止日期",
                "name": "end_time",
                "search":search ? true:false,
            },
            {
                "label": "结算单号",
                "name": "settlement_no",
                "search":search ? true:false
            },
            {
                "label": "金额",
                "name": "settlement_amount",
                //"in_table" : false
            } ,
            {
                "label": "处理状态",
                "name": "s_status",
                "search":search ? true:false,
                "render":function ( val, type, row ) {
                    if( val == 0){
                        return '未结算';
                    }else if( val == 1){
                        return "申请中";
                    }else if( val == 2){
                        return "已拒绝";
                    }else if( val == 3){
                        return "已结算";
                    }
                    return '其它';
                }
            },
            {
                "label": "回执详情",
                "name": "refuse_msg",
                "search":search ? true:false,
                //"in_table" : false
            },


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


    //==========时间
    var picker_from = $("#datetimepicker1").val(time_from_string)
        .datetimepicker({
            language: 'ch',//显示中文
            format: 'yyyy-mm',//显示格式
            minView: "month",//设置只显示到月份
            initialDate: new Date(),//初始化当前日期
            autoclose: true,//选中自动关闭
            endDate:time_from_string,
            //todayBtn: true,//显示今日按钮
        })
        .on('changeDate', function(ev){
            timeConditionChanged(picker_from.val(), picker_to.val() )

        });

    var picker_to = $("#datetimepicker2").val(time_to_string)
        .datetimepicker({
            language: 'cn',//显示中文
            format: 'yyyy-mm',//显示格式
            minView: "month",//设置只显示到月份
            initialDate: new Date(),//初始化当前日期
            autoclose: true,//选中自动关闭
            //todayBtn: true	, //显示今日按钮
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

    //==========结算状态
    var filterch  = $("#filter-status");
    for( var i in ot_status ){
        $("<option value='"+i+"'>"+ot_status[i]+"</option>").appendTo( filterch );
    }
    filterch.change(function(){
        current_status = this.value;
        refreshDatas();
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
    var url = getNewListAjaxUrl( controller_url + "&a=settlement_calc" );
    $.ajax({async: true, type : "get",url:url, data:{},
        dataType : 'json',
        success : function(result) {
            if(result.code==0){
                current_stat_data = result.data;
                $("#id-mycoins").text(result.data.user_coins);

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

    if( current_status != 0 ){
        tmp_para += "&s_status="+current_status
    }
    if(!!base_url)
        return base_url+tmp_para;

    var newUrl=datalist_ajax_url+tmp_para;
    return newUrl;
}
