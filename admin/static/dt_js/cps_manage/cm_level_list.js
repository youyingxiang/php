window.onload=function(){


    genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_level&a=index_ajax",
        [
            {
                "label_editor": "ID:",
                "label": "ID:",
                "name": "id",
                "editable": false,
                "type":"hidden",
                "search": true
            },
            // {
            //     "label": "返利类型:",
            //     "name": "type",
            //     "type": "select",
            //     "render":function(val,type,row){
            //         if(val == '1'){
            //             return '返卡类型';
            //         }else if(val == '2'){
            //             return '返利类型';
            //         }
            //     },
                
            //     "options": [
            //         { "label": "返卡类型", "value": "1" },
            //         { "label": "返利类型", "value": "2"},
            //     ]
            // },
            {
                "label": "等级名称:",
                "name": "name",
                "search": true
            },
            {
                "label": "用户返利:",
                "name": "user_rebate",
                "search": true,
            },
            {
                "label": "等级描述:",
                "name": "desc",
                "search": true,
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









