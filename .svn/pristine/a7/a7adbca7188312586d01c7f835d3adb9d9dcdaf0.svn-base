window.onload=function(){


    genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_club&a=index_ajax",
        [
            {
                "label_editor": "ID:",
                "label": "ID:",
                "name": "id",
                "type":"hidden",
                "editable": false,
                "search": true
            },
            {
                "label": "俱乐部名:",
                "name": "c_name",
                "search": true
            },
            {
                "label": "游戏id:",
                "name": "game_id",
                "search": true
            },
            {
                "label": "创建时间:",
                "name": "create_time",
                "search": true
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









