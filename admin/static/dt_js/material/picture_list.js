create_new_url=		"?m=material&c=media&a=add&media_type=img";
datalist_ajax_url=	"?m=material&c=media&a=picture_ajax";

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
	+"<th > <span class='LAN_Name'>名称</span></th>"
	+"<th > <span class='LAN_Picture'>图片</span></th>"
	+"<th > <span class='LAN_Type'>类型</span></th>"
	+"<th > <span class='LAN_Size'>大小</span></th>"
	+"<th > <span class='LAN_Width'>宽度</span></th>"
	+"<th > <span class='LAN_Height'>高度</span></th>"
	+"<th > <span class='LAN_Operation'>操作</span></th>"
	+"</tr>").appendTo('#data_list thead');

	var editor = new $.fn.dataTable.Editor( {
		ajax: getNewListAjaxUrl() ,
		table: "#data_list",
		"fields": [
			{"label": "ID"	,"name": "m.id",type:'hidden'},
			{"label": _lan_trans(".LAN_Name"	,"名称")		,"name": "m.name"},
			{"label": _lan_trans(".LAN_Picture"	,"图片")		,"name": "m.img"},
			{"label": _lan_trans(".LAN_Picture"	,"thumb")		,"name": "m.thumb",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"path")		,"name": "m.media_path",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"module")		,"name": "m.module",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"cite_id")		,"name": "m.cite_id",type:'hidden'},
			{"label": _lan_trans(".LAN_Picture"	,"catalog_id")		,"name": "m.catalog_id",type:'hidden'},
			{"label": _lan_trans(".LAN_Type"	,"类型")		,"name": "m.type"},
			{"label": _lan_trans(".LAN_Length"	,"长度")		,"name": "m.length",'type':'hidden'},
			{"label": _lan_trans(".LAN_Size"	,"大小")		,"name": "m.size"},
			{"label": _lan_trans(".LAN_Width"	,"宽度")		,"name": "m.size_x"},
			{"label": _lan_trans(".LAN_Height"	,"高度")		,"name": "m.size_y"},
			{"label": _lan_trans(".LAN_CreateTime","播放次数"),"name": "m.play_count"},
			dtEditorDatetimeField(_lan_trans(".LAN_PlayCount","创建时间"),"m.create_time"),
			dtEditorDatetimeField(_lan_trans(".LAN_UpdateTime","更新时间"),"m.update_time"),
			
			
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
	
	//alert(js_para["public_site"]);
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
			{"mData": "m.img","mRender":dtRender_pic(js_para["public_site"],"m")}, 
			{"mData": "m.type"},
			{"mData": "m.size"},
			{"mData": "m.size_x"},
			{"mData": "m.size_y"},
			{"mData": "cm_article.id","mRender":function(val,type,row)
				{
					var option="";
            		option+= '<a href="'+row.opt_links.edit+'" ><span class="LAN_Edit">修改</span></a>&nbsp;&nbsp;'; 
					option+= '<a href="'+row.opt_links.edit_group+'&editgroup=1"><span class="LAN_EditGroup">编辑本组</span></a>&nbsp;&nbsp;'; 
            
					return option;
				} 
				
			}//操作
			

		],
		"oTableTools": {
			"aButtons": []
		},
     //    "fnInitComplete": function( settings, json ) {
//           //editor.field('lmb_privilege[].id').update( json.lmb_privilege );
//         },
       "fnDrawCallback": function( oSettings ) {  reloadLanguage(); },//重新翻译语言
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
	var catalog_filter=$(selctorStr).cas_menu({ 
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
	var cite_filter=$(selctorStr).cas_menu({ 
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
// 	$("<tr>"
// 	+'<th><input type="text" class="form-control" id="searchId" placeholder="ID"></th>'
// 	+'<th><input type="text" class="form-control" id="selectName" placeholder="Title"></th>'
// 	//+'<th width="20px"  colspan="1"><input type="text" name="search_user" placeholder="用户ID或用户名" value="" class="search_init"></th>'
// 	+'<th colspan="3"></th>'
// 	+"</tr>").prependTo(data_list_sel+' thead');
// 
// 	$("#selectName").keyup( function () {
//         oTable.fnFilter( this.value, 1 );
//     } );
// 	$("#searchId").keyup(function(){
// 		oTable.fnFilter( this.value,0 );
// 	})
// 	$("#selectTitle").keyup(function(){
// 		oTable.fnFilter( this.value,4);
// 	})
// 	$("#selectTime").keyup(function(){
// 		oTable.fnFilter( this.value,5);
// 	})

	
}

//不使用传进来的参数，动态获取（cas_menu有bug，只能实时获取）
function createNewMedia(cur_catalog){

	if(!  createNewMedia_checkCasmenuLeafNode("#catalog_filter",cur_catalog) ){
		alert(_lan_trans(".LAN_PleaseSelectCatalog","请选择分类")+'!');return;
	}
	var url=create_new_url+"&cur_catalog="+cur_catalog;
	if(cur_cite_module && cur_cite_id!==false){

			url+="&cite_module="+cur_cite_module;
			url+="&cite_id="+cur_cite_id;//!!! 0表所有，-1表示全局
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












