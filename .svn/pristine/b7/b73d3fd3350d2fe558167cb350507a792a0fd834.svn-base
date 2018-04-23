create_new_url=		"?m=material&c=media&a=add&media_type=video";
datalist_ajax_url=	"?m=material&c=media&a=video_ajax";

cur_cite_module=false;//引用 如：hero
cur_cite_id=false;// 如 heroid
cur_catalog=false;
root_catalog=false;
media_type="img";
isgroup=0;
		
window.onload=function(){
	//初始化参数
	cur_catalog=js_para['cur_catalog'];
	root_catalog=js_para['root_catalog'];
	if(js_para['cite_module'] && js_para['cite_id']!==undefined){
		cur_cite_module=js_para['cite_module'] ;
		cur_cite_id=js_para['cite_id'];
	}
	media_type=js_para['media_type'];
	
	isgroup=js_para['isgroup'];


	var data_list_sel = "#data_list";
	$("<tr>"
	+"<th> <span class='LAN_Name'>名称</span></th>"
	+"<th width='10%'> <span class='LAN_Cover'>封面</span></th>"
	// +"<th width='10%' > <span class='LAN_OutLink'>外链</span></th>"
	// +"<th width='10%' > <span class='LAN_MoblieLink'>手机格式</span></th>"
	+"<th width='10%'> <span class='LAN_Type'>类型</span></th>"
	+"<th width='10%'> <span class='LAN_Length'>长度</span></th>"
	+"<th width='8%'> <span class='LAN_Top'>置顶</span></th>"
	+"<th width='8%'> <span class='LAN_PlayCount'>播放次数</span></th>"
	+"<th style='10%'> <span class='LAN_CreateTime'>创建时间</span></th>"
	+"<th style='10%'> <span class='LAN_Operation'>操作</span></th>"
	+"</tr>").appendTo('#data_list thead');

	var editor = new $.fn.dataTable.Editor( {
		ajax: getNewListAjaxUrl() ,
		table: "#data_list",
		"fields": [
			{"label": "ID"		,"name": "m.id",type:'hidden'},
			{"label": _lan_trans(".LAN_Name"		,"名称")		,"name": "m.name"},
			{"label": _lan_trans(".LAN_Picture"	,"图片")		,"name": "m.img",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"thumb")		,"name": "m.thumb",type:'hidden'},
			{"label": _lan_trans(".LAN_OutLink"	,"外链")			,"name": "m.media_path"},
			{"label": _lan_trans(".LAN_MoblieLink"	,"mp4外链")	,"name": "m.mobile_video"},
			{"label": _lan_trans(".LAN_Picture"	,"module")		,"name": "m.module",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"cite_id")		,"name": "m.cite_id",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"catalog_id")		,"name": "m.catalog_id",type:'hidden'},
			{"label": _lan_trans(".LAN_Type"	,"类型")		,"name": "m.type"},
			{"label": _lan_trans(".LAN_Length"	,"长度")		,"name": "m.length"},
			{"label": _lan_trans(".LAN_Size"	,"大小")		,"name": "m.size"},
			{"label": _lan_trans(".LAN_Top", "置顶")			,"name": "m.is_hot",
				"type": "select",
				"ipOpts": [
					{ "label": "Y", "value": "1"},
					{ "label": "N", "value": "0"} 
				]
			},
			{"label": _lan_trans(".LAN_PlayCount","播放次数")	,"name": "m.play_count"},
			{"label": _lan_trans(".LAN_Source","来源")			,"name": "m.source"},
			
			dtEditorDatetimeField(_lan_trans(".LAN_PlayCount","创建时间"),"m.create_time"),
			dtEditorDatetimeField(_lan_trans(".LAN_UpdateTime","更新时间"),"m.update_time")
		],
	} );

    $('#data_list').on( 'click', '  tbody td:nth-child(1),\
    								tbody td:nth-child(3),\
    								tbody td:nth-child(4),\
    								tbody td:nth-child(5),\
    								tbody td:nth-child(6)', function (e) {
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
			{"mData": "m.name"}, 
			{"mData": "m.thumb","mRender":dtRender_video(js_para["public_site"],"m")},  
			// {"mData": "m.media_path","mRender":dtRender_cutStr(20)}, 
			// {"mData": "m.mobile_video","mRender":dtRender_cutStr(20)}, 
			{"mData": "m.type"},
			{"mData": "m.length"},
			{"mData": "m.is_hot","mRender":function(val,type,row){
				if(val==1){
					return 'Y';
				}else{
					return 'N';
				}
			}},
			{"mData": "m.play_count"},
			{"mData": "m.create_time"},
			{"mData": "cm_article.id","mRender":function(val,type,row)
				{
					var option="";
            		option+= '<a href="'+row.opt_links.edit+'" ><span class="LAN_Edit">修改</span></a>&nbsp;&nbsp;'; 
					option+= '<a href="'+row.opt_links.edit_group+'&editgroup=1"><span class="LAN_EditGroup">编辑本组</span></a>&nbsp;&nbsp;'; 
            
					return option;
				} 
				
			}
		],
		"oTableTools": {
			"aButtons": []
		},
        // "fnInitComplete": function( settings, json ) {
//           //editor.field('lmb_privilege[].id').update( json.lmb_privilege );
//         },
        "fnDrawCallback": function( oSettings ) {  reloadLanguage(); },//重新翻译语言
		"oLanguage": {	"sUrl": _getDataTablesLanguageUrl()} //本地化文件位置，函数位于 js/lingua/lan.lingua.js
		
	} );


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
			$("#create-new-article").attr("onclick",'createNewMedia("'+cur_catalog+'")');
			
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
	+'<th><input type="text" class="form-control" id="filter_header_name" placeholder=""></th>'	
	+'<th ></th>'
	+'<th><input type="text" class="form-control" id="filter_header_type" placeholder=""></th>'
	//+'<th width="20px"  colspan="1"><input type="text" name="search_user" placeholder="用户ID或用户名" value="" class="search_init"></th>'
	+'<th colspan="5"></th>'
	+"</tr>").prependTo(data_list_sel+' thead');

	$("#filter_header_name").keyup(function(){//名称
		oTable.fnFilter( this.value,0 );
	})
	$("#filter_header_type").keyup( function () {//类型
        oTable.fnFilter( this.value, 4 );
    } );
	
}

//不使用传进来的参数，动态获取（cas_menu有bug，只能实时获取）
function createNewMedia(cur_catalog){

	if(!  createNewMedia_checkCasmenuLeafNode("#catalog_filter",cur_catalog) ){
		alert(_lan_trans(".LAN_PleaseSelectCatalog","请选择分类")+'!');return;
	}
	var url=create_new_url+"&cur_catalog="+cur_catalog;
	if(cur_cite_module && cur_cite_id!==false){
	// 	if(!createNewMedia_checkCasmenuLeafNode("#cite_filter",cur_cite_id)){
// 			alert("请选择英雄");return;
// 		}else{
			url+="&cite_module="+cur_cite_module;
			url+="&cite_id="+cur_cite_id;//!!! 0表所有，-1表示全局
		//}
	}
	jump(url);
	
}

function createNewMedia_checkCasmenuLeafNode(sel_str,cur_catalog){
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
	var more_para="";
	
	if(cur_cite_module && cur_cite_id!==false ){
		more_para="&cite_module="+cur_cite_module +"&cite_id="+cur_cite_id ;
	}
	if(!cur_catalog || cur_catalog<=0)cur_catalog=root_catalog;
	var newUrl=datalist_ajax_url+"&cur_catalog="+ cur_catalog +more_para;
	
	return newUrl;
}



