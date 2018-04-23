window.onload=function(){

    controller_url = 	js_para.controller_url
    agent_view = js_para.agent_view;
    datalist_ajax_url = controller_url + "&a=settlement_ajax"



    mygames = js_para.games;
    mygames['_EMPTY_STRING_']="所有";

    myunions = js_para.unions;
    myunions['_EMPTY_STRING_']="所有";

    table_editors = genEditorTable('#data_list' ,datalist_ajax_url,
        [
            {
                "label": "代理商ID:",
                "name": "agent_id",
                "width":"10%",
                "search": true,
            },
            {
                "label": "请求时间:",
                "name": "application_time",
                "type": "datetime",
                "width":"20%",
                "search": true,
                'format':'YYYY-MM-DD HH:mm:ss'	,
                "def":       function () { return new Date(); },
            },
            {
                "label": "处理时间:",
                "name": "processing_time",
                "type": "datetime",
                "width":"20%",
                "search": true,
                'format':'YYYY-MM-DD HH:mm:ss'	,
                "def":       function () { return new Date(); }
            } ,
            {
                "label": "金额:",
                "name": "settlement_amount"
            } ,
            {
                "label": "状态",
                "name": "s_status",
                "type":"select",
                "search":{"_EMPTY_STRING_":"所有","1":"已申请","2":"已拒绝","3":"已结算"},
                "render":function ( val, type, row ) {
                    var ops = "";
                    switch(	val*1 ){
                        case 1: ops= '已申请';  break;
                        case 2: ops= '已拒绝 原因：'+row.refuse_msg; break;
                        case 3: ops= '已结算';  break;
                    }

                    return  ops;
                }
            } ,
            {
                "label":"操作",
                "type":"hidden",
                "name":"settlement_id",
                "render":function ( val, type, row ) {
                    var ops = "";

                    if(agent_view){
                        switch(row.s_status*1){
                            case 1:

                                ops='<a href="index.php?m=cps_agent&c=ca_apply&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> '
                                    +'<a href="javascript:void(0)" onclick="doOption(\'cancel_withdraw\',\''+row.settlement_id+'\')">取消结算</a> ';
                                break;
                            case 2:
                                ops= '<a href="index.php?m=cps_agent&c=ca_apply&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> '
                                    +'<a href="javascript:void(0)" onclick="doOption(\'request_withdraw\',\''+row.settlement_id+'\')">申请结算</a> ';
                                break;
                            case 3:
                                ops= '<a href="index.php?m=cps_manage&c=cm_settlement&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> ';
                                break;
                        }
                    }else{
                        switch(row.s_status*1){
                            case 1:
                                var ops=
                                    '<a href="index.php?m=cps_manage&c=cm_settlement&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> '
                               +' / <a href="javascript:void(0)" onclick="doOption(\'deny_settlement\',\''+row.settlement_id+'\')">拒绝</a> '
                                    + ' / <a href="javascript:void(0)" onclick="doOption(\'confirm_settlement\',\''+row.settlement_id+'\')">结算</a> ';
                                break;
                            case 2:
                                var ops=
                                    '<a href="index.php?m=cps_manage&c=cm_settlement&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> ';
                                break;
                            case 3:
                                ops= '<a href="index.php?m=cps_manage&c=cm_settlement&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> ';
                                break;
                        }
                    }
                    return  ops;
                }
            }

        ],
        {
            "privilege":js_privilege,
            "disable_keyup_search":true,
            "columnDefs":[{orderable:false, targets:[0,1,2,3,4,5 ]  }],
            "order":[[ 1, 'desc' ]],
            "serverSide":true,
            //"tableOnly":true,
            "initComplete":  function( settings, json ) {
                $("#data_list_filter").remove();
            }
        }
    );

    oTable = table_editors[0];
}

//========执行单条
function doOption(action, id){
    cancelBubble();
    var url =  controller_url + "&a="+action + "&settlement_id=" +  id;
    alert(action);
    if(action == "confirm_settlement"){
        if(!confirm("确定已经给用户结算完成？")){
            return;
        }
    }else if(action == "deny_settlement"){
        var refuse_msg = window.prompt("请输入拒绝原因", "")
        if(!refuse_msg) return;
        url += "&refuse_msg=" + refuse_msg;
    }
    $.ajax({async: true, type : "get",url:url, data:{},
        dataType : 'json',
        success : function(result) {
            if(result.code==0){
                // 更新余额
                //refreshDatas();
                alert("成功")
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

}

// 重新生成 URL
function getNewListAjaxUrl(){
    var tmp_para="";

    var newUrl= datalist_ajax_url + tmp_para ;
    return newUrl;
}

