window.onload=function(){


    genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_notice&a=index_ajax",
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
                "label": "公告标题:",
                "name": "title",
                "search": true
            },
            {
                "label": "公告详情:",
                "name": "content",
                "search": true
            },
            {
                "label": "关键词:",
                "name": "keyword",
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









