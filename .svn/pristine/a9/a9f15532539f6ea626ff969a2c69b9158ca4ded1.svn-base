window.onload=function(){
    controller_url = js_para.controller_url
    datalist_ajax_url = controller_url + "&a=apply_ajax";
    settle_time = js_para.settle_time;

    mygames = js_para.games;
    mygames['_EMPTY_STRING_']="所有";

    myunions = js_para.unions;
    myunions['_EMPTY_STRING_']="所有";
    table_editors = genEditorTable('#data_list' ,datalist_ajax_url,
        [
            {
                "label": "结算时间:",
                "name": "start_time",
                "type": "select",
                "width":"20%",
                'format':'YYYY-MM'	,
                "render":settle_time
            },
            {
                "label": "代理商ID:",
                "name": "agent_id",
                "type":"hidden",
                "in_table":false,
                "def":js_para.agent_id
            },
            {
                "label": "请求时间:",
                "name": "application_time",
                "type": "hidden",

            },
            {
                "label": "状态:",
                "name": "s_status",
                "type":"hidden",
                "render":function ( val, type, row ) {
                    var ops = "";
                    switch(	val*1 ){
                        case 1: ops= '已申请';  break;
                        case 2: ops= '已拒绝 原因：'+ row.refuse_msg ;  break;
                        case 3: ops= '已完成结算';  break;
                    }

                    return  ops;
                }
            },
            {
                "label": "金额:",
                "name": "settlement_amount",
                "type": "hidden"
            },
            {//操作
            "label":"操作",
            "in_editor":false,
            "name": null,
            "class": "center",
            "width":"20%",
            "render": function ( val, type, row ) {
                var ops=
                    '<a href="index.php?m=cps_agent&c=ca_apply&a=orders&agent_id='+row.agent_id+'&settlement_id='+row.settlement_id+'"><span class="LAN_">结算单详情</span></a> '
                return  ops;
            }

        },//end 操作

        ],
        {
            "privilege":js_privilege,
            "disable_keyup_search":true,
            "order":[[ 2, 'desc' ]],
            "serverSide":true,
        },
        {
            'submitSuccess':function(a,b,c){
                console.log(a);
                console.log(b);
                console.log(c);
                window.open("/index.php?m=cps_agent&c=ca_apply&a=orders&agent_id=1");
            }
        }
    );

    oTable = table_editors[0];

    $("#datetimepicker1").next(".fa-calendar").on("click",function(e){ picker_from.datetimepicker("show") });
    $("#datetimepicker2").next(".fa-calendar").on("click",function(e){ picker_to.datetimepicker("show") });
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


