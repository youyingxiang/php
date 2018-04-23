window.onload=function(){


    genEditorTable('#data_list' ,"index.php?m=cps_manage&c=cm_recharge&a=index_ajax",
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
                "label": "充值金额:",
                "name": "amount",
                "search": true
            },
            {
                "label": "所得房卡:",
                "name": "room_cards",
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









