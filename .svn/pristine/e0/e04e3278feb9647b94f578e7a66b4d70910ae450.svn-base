create_new_url="?m=article&c=article&a=addArticle";
datalist_ajax_url="index.php?m=article&c=article&a=index_ajax";
cur_cite_module=false;//引用 如：hero
cur_cite_id=false;// 如 heroid
cur_catalog=false;

window.onload=function(){
	var data_list_sel = "#data_list";
	$("<tr>"
	+"<th style='text-align:center' width=8%> ID</th>"
	+"<th>Title</th>"
	+"<th width=10%>平台</th>"
	+"<th width=8%>是否精选</th>"
	+"<th width=8%>是否热点</th>"
	+"<th width=8%>排序</th>"
	+"<th width=15%>发表时间</th>"
	+"<th width=10%>操作</th>"
	+"</tr>").appendTo('#data_list thead');
	
	//初始化参数
	cur_catalog=js_para['cur_catalog'];
	if(js_para['cite_module'] && js_para['cite_id']!==undefined){
		cur_cite_module=js_para['cite_module'] ;
		cur_cite_id=js_para['cite_id'];
	}
	
	//alert(getNewListAjaxUrl());
	var editor = new $.fn.dataTable.Editor( {
		ajax: getNewListAjaxUrl() ,
		table: "#data_list",
		"fields": [
			{"label": "id","name": "cm_article.id",'type':'hidden'},
			{"label": "title","name": "cm_article.title"},
			{"label": "是否精选","name": "cm_article.is_choiceness",
				"type": "select",
				"ipOpts": [
					{ "label": "Y", "value": "1" },
					{ "label": "N", "value": "0"} 
				]
			},
			{"label": "是否热点","name": "cm_article.is_hot",
				"type": "select",
				"ipOpts": [
					{ "label": "Y", "value": "1" },
					{ "label": "N", "value": "0"} 
				]
			},
			{"label": "plat","name": "cm_article.plat",
				"type": "select",
				"ipOpts": [
					{ "label": "全部", "value": "all" },
					{ "label": "Web", "value": "web" },
					{ "label": "android", "value": "android" },
					{ "label": "ios", "value": "ios"}, 
					{ "label": "other", "value": "other"} 
				]
			},
			{"label": "排序","name": "cm_article.ord"},
			
			dtEditorDatetimeField(_lan_trans(".LAN_PublishTime","发表时间"),"cm_article.create_time"),
			//{"label": "备注","name": "remark",'type':'textarea'}
			
		],
	} );

    $('#data_list').on( 'click', '  tbody td:nth-child(2),\
    								tbody td:nth-child(3),\
    								tbody td:nth-child(4),\
    								tbody td:nth-child(5),\
    								tbody td:nth-child(6),\
    								tbody td:nth-child(7)', function (e) {
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
			{"mData": "cm_article.id","sClass":"td_center"}, 
			{"mData": "cm_article.title"}, 
			{"mData": "cm_article.plat",'mRender':function(val,type,row){
				switch(val){
					case 'web':
					case 'ios':
					case 'android':
					case 'other':
						return val;
						break;
					default:
						return '全部';
				}
			}}, 
			{"mData": "cm_article.is_choiceness",'mRender':function(val,type,row){
				if(val==1){
					return 'Y';
				}else{
					return 'N';
				}
			}},
			{"mData": "cm_article.is_hot",'mRender':function(val,type,row){
				if(val==1){
					return 'Y';
				}else{
					return 'N';
				}
			}},
			/*
			{"mData": "cm_article.content","mRender":function(val,type,row){
				var content = toPlainText(val);
				if(content.length<39){
					return content;
				}else{
					return content.substring(0,39)+'...';
				}
			}}, 
			*/
			{"mData": "cm_article.ord","sClass":"ord"},
			{"mData": "cm_article.create_time"},
			{"mData": "cm_article.id","mRender":function(val,type,row){
				return row.option;
			}},

		],
		"oTableTools": {
			"aButtons": []
		},
        "fnInitComplete": function( settings, json ) {
          //editor.field('lmb_privilege[].id').update( json.lmb_privilege );
        },
        "fnDrawCallback": function( oSettings ) {  if(oSettings.iDraw==2)reloadLanguage(); },//重新翻译语言
		"oLanguage": {	"sUrl": _getDataTablesLanguageUrl()} //本地化文件位置，函数位于 js/lingua/lan.lingua.js
		
	} );

// alert(js_para['cur_catalog']);
// alert(js_para['root_catalog']);



//cas_menu================
//按类别过滤

var catalog_filter=false;
//applyCasMenu("#catalog_filter",false);
applyCasMenu("#catalog_filter",cur_catalog);

function applyCasMenu(selctorStr,defaultId){
	catalog_filter=$(selctorStr).cas_menu({ 
		source			:	"?m=article&c=casmenu",  
		rootId			:   js_para['root_catalog'],//'1000000000000000000',
		defaultId		:   defaultId,
		inputCtlName	:	'catalogs[]',
		selectAllOption	:	{label: _lan_trans(".LAN_PleaseSelectCatalog","请选择分类"),value:js_para['root_catalog']},
		fnUserOnchange:function(curSel){
			if(curSel)	cur_catalog=curSel;
			else		cur_catalog=0;
			
			
			//更新新建菜单
			$("#create-new-article").attr("onclick",'createNewArticle("'+cur_catalog+'")');
			
			//更新TABLE
			var settings=oTable.fnSettings();
			oTable.DataTable().ajax.url( getNewListAjaxUrl() ).load();
		},
	});
}

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
	+'<th><select id="selectPlat"><option value="" class="LAN_All">全部</option><option value="web">web</option><option value="android">android</option><option value="ios">ios</option><option value="other">other</option></select></th>'
	+'<th><select id="selectRe"><option value="">全部</option><option value="1">Y</option><option value="0">N</option></select></th>'
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
	$("#selectRe").change(function(){
		oTable.fnFilter( this.value,3);
	})
	$("#selectPlat").change(function(){
		oTable.fnFilter( this.value,2 );
	})
	
}

function createNewArticle(cur_catalog){
	if(!  createNewArticle_checkCasmenuLeafNode("#catalog_filter",cur_catalog) ){
		if(cur_cite_module!='hero_strategy'){
			alert(_lan_trans(".LAN_PleaseSelectCatalog","请选择分类")+'!');return;
		}
	}
	var url=create_new_url+"&cur_catalog="+cur_catalog;
	if(cur_cite_module && cur_cite_id!==false){
	// 	if(!createNewArticle_checkCasmenuLeafNode("#cite_filter",cur_cite_id)){
// 			alert("请选择英雄");return;
// 		}else{
			url+="&cite_module="+cur_cite_module;
			url+="&cite_id="+cur_cite_id;//!!! 0表所有，-1表示全局
		//}
	}
	jump(url);
	
}

function createNewArticle_checkCasmenuLeafNode(sel_str,cur_catalog){
	if(!cur_catalog ){
		return false;
	}
	var catSel=$(sel_str+" input.cursel").val();
	var onlyOneCatalog=$(sel_str+" select").length<=0;
	var lastSelected=GPID_getLevel($(sel_str+" .cas_menu_select:last option:last").val()) == GPID_getLevel(catSel);
	//只有叶子节点被选中 或 当前只传进来一个
	if(catSel && catSel>0 && lastSelected || onlyOneCatalog  ){
		return true;
	}
	return false;
}

function getNewListAjaxUrl(){
	var cite_para="";
	if(cur_cite_module && cur_cite_id!==false){
		cite_para="&cite_module="+cur_cite_module +"&cite_id="+cur_cite_id ;
	}
	var newUrl=datalist_ajax_url+"&cur_catalog="+cur_catalog+cite_para;
	return newUrl;
}












