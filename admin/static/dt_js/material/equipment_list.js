create_new_url="?m=material&c=equipment&a=add";
datalist_ajax_url="?m=material&c=equipment&a=index_ajax";
cur_cite_module=false;//引用 如：hero
cur_cite_id=false;// 如 heroid

cur_bigclass=false;// 如 equipment,talent, honnor

window.onload=function(){
	var data_list_sel = "#data_list";
	$("<tr>"
	+"<th  width=8%> ID</th>"
	+"<th width=15%><span class='LAN_Name'>名称</span></th>"
	+"<th width=10%><span class='LAN_Type'>类型</span></th>"
	+"<th width=10%><span class='LAN_Type'>类型</span>2</th>"
	+"<th width=10%><span class='LAN_Keyword'>关键字</span></th>"
	+"<th width=8%><span class='LAN_Order'>排序</span></th>"
	+"<th width=10%><span class='LAN_MoneyType'>货币</span></th>"
	+"<th width=8%><span class='LAN_Price'>价格</span></th>"
	+"<th width=10%><span class='LAN_Operation'>操作</span></th>"
	+"</tr>").appendTo('#data_list thead');
	
	if(js_para['cite_module'] && js_para['cite_id']!==undefined){
		cur_cite_module=js_para['cite_module'] ;
		cur_cite_id=js_para['cite_id'];
	}
	cur_bigclass=js_para['bigclass'];

	//alert(getNewListAjaxUrl());
	var editor = new $.fn.dataTable.Editor( {
		ajax: getNewListAjaxUrl() ,
		table: "#data_list",
		"fields": [
			{"label": "id","name": "e.id",'type':'hidden'},
			{"label": _lan_trans(".LAN_Name","名称") ,"name": "e.name"},
			{"label": _lan_trans(".LAN_Type","类型"),"name": "e.type",
				"type": "select","ipOpts":equipment_types.dtEditorOps("type",cur_bigclass)
			},
			{"label": _lan_trans(".LAN_Type","类型")+"2","name": "e.type2",
				"type": "select","ipOpts":equipment_types.dtEditorOps("type2",cur_bigclass)
			},
			{"label": _lan_trans(".LAN_Keyword","关键字"),"name": "e.keyword"},
			{"label": "bigclass","name": "e.bigclass"},
			{"label": _lan_trans(".LAN_MoneyType","货币"),"name": "e.money_type",
				"type": "select","ipOpts":equipment_types.dtEditorOps("common","money_type")},
			{"label": _lan_trans(".LAN_Price","价格"),"name": "e.price"},
			{"label": _lan_trans(".LAN_Order","排序"),"name": "e.ord"},
			{"label":  _lan_trans(".LAN_Intro","简介")	,"name": "e.intro","sClass1":"center",type:"ckeditor"},
			{"label":  _lan_trans(".LAN_Content","内容")	,"name": "e.content","sClass1":"center",type:"ckeditor"},
			{"label":  _lan_trans(".LAN_Extend","扩展")	,"name": "e.json_form",type:"textarea"},
			//{"label": "备注","name": "remark",'type':'textarea'}
			
		],
	} );

    $('#data_list').on( 'click', '  tbody td:nth-child(2),\
    								tbody td:nth-child(3),\
    								tbody td:nth-child(4),\
    								tbody td:nth-child(5),\
    								tbody td:nth-child(6),\
    								tbody td:nth-child(7),\
    								tbody td:nth-child(8)',function (e) {
        editor.inline( this, {
            buttons: { label: '&radic;', fn: function () { this.submit(); } }
        } );
    } );

	branchButtons = getBranchButtons(js_privilege,editor);
	
	
	var oTable = $('#data_list').dataTable({
        "dom": "Tfrtip",
		"pageLength":20,
        "ajax": {
            url: getNewListAjaxUrl(),//datalist_ajax_url,
            type: "POST"
        },
	//	"sAjaxSource":datalist_ajax_url,
		"serverSide": true,
		"aoColumns": [
			{"mData": "e.id","sClass":"td_center"}, 
			{"mData": "e.name"},
			{"mData": "e.type",'mRender':equipment_types.dtRender("type",cur_bigclass)},
			{"mData": "e.type2",	'mRender':equipment_types.dtRender("type2",cur_bigclass)},
			{"mData": "e.keyword"},
			{"mData": "e.ord"},
			{"mData": "e.money_type",	'mRender':equipment_types.dtRender("common","money_type")},
			{"mData": "e.price"},
			{"mData": "option"}
		],
		"oTableTools": {
			"aButtons":[]
		},
        "fnInitComplete": function( settings, json ) {
          //editor.field('lmb_privilege[].id').update( json.lmb_privilege );
        },
        "fnDrawCallback": function( oSettings ) {  if(oSettings.iDraw==2)reloadLanguage(); },//重新翻译语言
		"oLanguage": {	"sUrl": _getDataTablesLanguageUrl()} //本地化文件位置，函数位于 js/lingua/lan.lingua.js
		
	} );


// 按引用过虑================
if(cur_cite_module!==false && cur_cite_id!==false){
	applyCiteCasMenu("#cite_filter","?m=material&a="+cur_cite_module+"CasMenu",cur_cite_id );
}

function applyCiteCasMenu(selctorStr,source,defaultId){
	catalog_filter=$(selctorStr).cas_menu({ 
		source			:	source,  
		rootId			:   0,//
		defaultId		:  defaultId,//
		inputCtlName	:	'cite_ids[]',
		selectAllOption	:	{label: _lan_trans(".LAN_PleaseSelect","请选择"),value:0},
		fnUserOnchange:function(curSel){
			if(!curSel)	curSel=0;
			//更新引用
			cur_cite_id=curSel;
			
			//TODO: 更新TABLE
			var settings=oTable.fnSettings();
			oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
		},
	});
}


//底部搜索
	$("<tr>"
	+'<th><input type="text" class="form-control" id="searchId" placeholder="ID"></th>'
	+'<th><input type="text" class="form-control" id="selectName" placeholder="Title"></th>'
	+'<th><select id="selectType"><option value="" class="LAN_All">全部</option>'+equipment_types.selectOptions("type",cur_bigclass)+'</select></th>'
	+'<th><select id="selectType2"><option value="">全部</option>'+equipment_types.selectOptions("type2",cur_bigclass)+'</select></th>'
	+'<th><input type="text" class="form-control" id="searchKeyword" placeholder="Keyword"></th>'
	//+'<th width="20px"  colspan="1"><input type="text" name="search_user" placeholder="用户ID或用户名" value="" class="search_init"></th>'
	+'<th colspan="4"></th>'
	+"</tr>").prependTo(data_list_sel+' thead');

	$("#selectName").keyup( function () {
        oTable.fnFilter( this.value, 1 );
    } );
	$("#searchId").keyup(function(){
		oTable.fnFilter( this.value,0 );
	})
	$("#selectTitle").keyup(function(){
		oTable.fnFilter( this.value,4);
	})
	$("#selectTime").keyup(function(){
		oTable.fnFilter( this.value,5);
	})
	$("#selectType2").change(function(){
		oTable.fnFilter( this.value,3);
	})
	$("#selectType").change(function(){
		oTable.fnFilter( this.value,2 );
	})
	$("#searchKeyword").change(function(){
		oTable.fnFilter( this.value,4 );
	})
	
}

function createNewArticle(){

	var url=create_new_url;
	if(cur_cite_module && cur_cite_id!==false){
			url+="&cite_module="+cur_cite_module;
			url+="&cite_id="+cur_cite_id;//!!! 0表所有，-1表示全局
	}
	url+="&bigclass="+cur_bigclass;
	jump(url);
	
}


function getNewListAjaxUrl(){
	var cite_para="";
	if(cur_cite_module && cur_cite_id!==false){
		cite_para="&cite_module="+cur_cite_module +"&cite_id="+cur_cite_id ;
	}
	if(cur_bigclass){
		cite_para+="&bigclass="+cur_bigclass;
	}
	var newUrl=datalist_ajax_url+cite_para;
	return newUrl;
}






