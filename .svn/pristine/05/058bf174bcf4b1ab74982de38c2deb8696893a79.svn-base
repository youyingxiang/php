window.onload=function(){


    genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_apply&a=index_ajax",
        [
            {
                "label_editor": "ID:",
                "label": "ID:",
                "name": "id",
                "type":"hidden",
                "editable": false,
            },
            {
                "label": "代理商昵称:",
                "name": "name",
            },
            {
                "label": "已购金额:",
                "name": "amount",
            },
            {
                "label": "申请时间:",
                "name": "apptime",
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









