window.onload=function(){
//(function($){
	var data_list_sel="#data_list ";
	$("<tr>"
	+"<th ><span class='LAN_Parent'>父</span> ID</th>"
	+"<th>ID</th>"
	+"<th width='15%'><span class='LAN_Name'>名称</span></th>"
	+"<th ><span class='LAN_Intro'>简介</span></th>"
	+"<th><span class='LAN_Level'>等级</span></th>"
	+"<th><span class='LAN_Order'>排序</span></th>"
	+"<th  >URL</th>"
	+"<th><span class='LAN_Show'>显示</span></th>"
	+"<th ><span class='LAN_Operation'>操作</span></th>"
	+"</tr>").appendTo('#data_list thead');
	
	//asd

	var catalog_newGPID="?m=article&a=get_new_gpid_ajax";
	var datalist_ajax_url="?m=article&a=index_ajax";
	if(js_para){

		var id=js_para[0];
		datalist_ajax_url+="&pid="+id;
		

		var pid=GPID_getParendGid(id);
		if(pid)datalist_ajax_url+="&ppid="+pid;
	}

	var ppid=GPID_getParendGid();
	var editor = new $.fn.dataTable.Editor( {
		"ajaxUrl": datalist_ajax_url,
		"domTable": data_list_sel,
		"fields": [
			{"label": "父ID","name": "pid"},
			{"label": "ID","name": "gpid","type": "text"},
			{"label": "名称","name": "name","type": "text"},
			{"label": "简介","name": "intro","type": "textarea"},
			{"label": "等级","name": "level","type": "text"},
			{"label": "排序","name": "odr","type": "text"},
			{"label": "URL","name": "url","type": "text"},
			{
				"type": "radio",
				"label": "显示",
				"name": "status",
				"ipOpts": [
					{ "label": "是", "value": 1 },
					{ "label": "否", "value": 0 }
				]
			}
		],
		"i18n":{"sUrl": "js/DataTablesExt/dataTables.editor.zh_CN.json"}
	} );
	editor.disable("pid");
	editor.disable("level");
	editor.disable("gpid");
	
    $(data_list_sel).on( 'click', ' tbody td:nth-child(3),\
    								tbody td:nth-child(4),\
    								tbody td:nth-child(6),\
    								tbody td:nth-child(7),\
    								tbody td:nth-child(8)', function (e) {
        editor.inline( this, {
            buttons: { label: '&radic;', fn: function () { this.submit(); } }
        } );
    } );	

	var oTable=$(data_list_sel).dataTable({
		"sDom": "Tfrtip",
		"sAjaxSource":datalist_ajax_url,
		"aoColumns": [
			{
				"mData": "pid",
				"mRender": function ( val, type, row ) {
					if ( val =='0') {return "无" ;
					}else if(val) return val +'-'+ row.sub.name;
					return "";
				},
				"sDefaultContent": ""
			},
			{"mData": "gpid"},
			{"mData": "name"},
			{"mData": "intro","mRender": dtRender_cutStr(30)},
			{"mData": "level"},
			{"mData": "odr"},
			{"mData": "url"},
			{"mData": "status","mRender":dtRender_yesNo('<span class="LAN_No">否</span>','0','<span class="LAN_Yes">是</span>','1')},
			{
                "mData": null, 
                "sClass": "center",
				"mRender": function ( val, type, row ) {
					var ops=
					'<a href="javascript:void(0)" onclick="gotoSubList(\''+row.gpid+'\')"><span class="LAN_Subnodes">子节点</span></a> '
					+'/ <a href="" class="editor_createsub"><span class="LAN_AddSubnode">添加子节点</span></a> '
					+'/ <a href="" class="editor_edit"><span class="LAN_Edit">编辑</span></a> ';
				//	if(row.gpid!=GPID_getRoot())ops+='/ <a href="" class="editor_remove"><span class="LAN_Delete">删除</span></a>';
					return  ops;
				}
                
            }
		],
		"oTableTools": {
			//"sRowSelect": "single",
			"aButtons": [
				//{ "sExtends": "editor_create", "editor": editor },
				//{ "sExtends": "editor_edit",   "editor": editor },
				//{ "sExtends": "editor_remove", "editor": editor }
			]
		},
		"fnDrawCallback": function( oSettings ) {  if(oSettings.iDraw==2)reloadLanguage(); },//重新翻译语言
		"oLanguage": {	"sUrl": _getDataTablesLanguageUrl()}, //本地化文件位置，函数位于 js/lingua/lan.lingua.js
		"fnInitComplete": function ( settings, json ) {
			//editor.field('pid').update( json.catalog_list );
		} 
		
	} );

//底部搜索
	$("<tr>"
	+'<th width="20px"  colspan="1"><input type="text"  placeholder="" value="" class="search_init"></th>'
	+'<th width="20px"  colspan="1"><input type="text"  placeholder="" value="" class="search_init"></th>'
	+'<th width="20px"  colspan="1"><input type="text"  placeholder="" value="" class="search_init"></th>'
	+"</tr>").prependTo(data_list_sel+' thead');


	$(data_list_sel+' tfoot input').keyup( function () {
        oTable.fnFilter( this.value, $(data_list_sel+" tfoot input").index(this) );
    } );
     
//操作

	// 添加子节点
    $(data_list_sel).on('click', 'a.editor_createsub', function (e) {
        e.preventDefault();
		var pid=$(this).parent().parent().children("td:eq(1)").html();
		var pname=$(this).parent().parent().children("td:eq(2)").html();
		editor.enable("pid");
		editor.enable("level");
		editor.enable("gpid");
		editor.hide("pid");
		editor.hide("level");
		editor.hide("gpid");

        editor.create(
            '为节点:['+pid+'-'+pname+"]添加子节点",
            { "label": "添加", "fn": function () { 
				var url = catalog_newGPID+"&pid="+id;
				var name= editor.get("name");
				var intro = editor.get("intro");
				$.ajax({async: false, type : "get",url:url,	data:{name:name,pid:pid}, 
					dataType : 'json',  
					success : function(data) {//$("#footer").html(data);
						if(data.code=='succ'){
							var tmp_pid=pid;
							var pLevel=GPID_getLevel(tmp_pid);
							editor.set("gpid",data.new_id);
							editor.set("pid",pid);
							editor.set("level",pLevel+1);
							editor.set("name",name);
							editor.set("intro",intro);
							editor.submit();
							gotoSubList(pid);
						}else{
							alert("错误："+data.msg);
						}
						return;
					} 
				});//END ajax
			} }
        );
    } );
 
    // 编辑
    $(data_list_sel).on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
		editor.disable("pid");
		editor.disable("level");
		editor.disable("gpid");
		editor.hide("pid");
		editor.show("level");
		editor.show("gpid");
		
		var parent_text=$(this).parent().parent().children("td:eq(0)").html();
		

        editor.edit(
            $(this).parents('tr')[0],
            '编辑（父节点为：['+parent_text+']）',
            { "label": "更新", "fn": function () { editor.submit() } }
        );
    } );
 
    // 删除
    $(data_list_sel).on('click', 'a.editor_remove', function (e) {
        e.preventDefault();
 
        editor.message( "您确定要删除这一行吗?" );
        editor.remove(
            $(this).parents('tr')[0],
            '删除',
            { "label": "删除", "fn": function () { editor.submit() } }
        );
    } );

};
//}(jQuery));


function gotoSubList(pid){
		var url="?m=article&pid="+pid;
        window.location.href=url;
}
