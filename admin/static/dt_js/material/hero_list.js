

window.onload=function(){

	var datalist_ajax_url="?m=material&a=index_ajax";
	var data_list_sel='#data_list ';
	
	$("<tr>"
	+"<th style='text-align:center;' width='6%'><span>ID</span></th>"
	+"<th style='text-align:center;' width='12%'><span class='LAN_Name'>名称</span></th>"
	+"<th style='text-align:center;' width='12%'><span class='LAN_Type'>类型</span></th>"
	+"<th  style='text-align:center' width='12%'><span class='LAN_Alias'>别名</span></th>"
	+"<th  style='text-align:center' ><span class='LAN_Keyword'>关键字</span></th>"
	+"<th  style='text-align:center' ><span class='LAN_GetType'>获取方式</span></th>"
	+"<th  style='text-align:center' ><span class='LAN_Price'>价格</span></th>"
	+"<th  style='text-align:center' width='8%'><span class='LAN_Free'>限免</span></th>"
	//+"<th style='text-align:center;' ><span class='LAN_Content'>内容</span></th>"
	+"<th style='text-align:center;' width='24%'><span class='LAN_Operation'>操作</span></th>"
	+"</tr>").appendTo(data_list_sel+' thead');
	
	var editor = new $.fn.dataTable.Editor( {
		"ajaxUrl": datalist_ajax_url,
		"domTable": "#data_list",
		"fields": [
			{"label": "ID"	,"name": "id",type:'hidden'},
			{"label":  _lan_trans(".LAN_Name","名称")	,"name": "name","sClass1":"center"},
			{"label":  _lan_trans(".LAN_Type","类型")	,"name": "type","sClass1":"center"},
			{"label":  _lan_trans(".LAN_Alias","别名")	,"name": "alias","sClass1":"center"},
			{"label":  _lan_trans(".LAN_Keyword","关键字")	,"name": "keyword","sClass1":"center"},
			{"label":  _lan_trans(".LAN_GetType","获取方式")	,"name": "money_type"},
			{"label":  _lan_trans(".LAN_Price","价格")	,"name": "price","sClass1":"center"},
			{"label":  _lan_trans(".LAN_Free","限免")	,"name": "is_free","type": "select",
				"ipOpts": [
					{ "label": "N", "value": "0"},
					{ "label": "Y", "value": "1"}
				]},
			{"label":  "攻击值",	"name": "attack","sClass1":"center"},
			{"label":  "攻击速度",	"name": "attack_speed","sClass1":"center"},
			{"label":  "生命值",	"name": "health","sClass1":"center"},
			{"label":  "护甲值",	"name": "armor","sClass1":"center"},
			{"label":  "法术抗性",	"name": "magic_resistance","sClass1":"center"},
			{"label":  "攻击距离",	"name": "range","sClass1":"center"},
			{"label":  _lan_trans(".LAN_Intro","简介")	,"name": "intro","sClass1":"center",type:"ckeditor"},
			{"label":  _lan_trans(".LAN_Content","内容")	,"name": "content","sClass1":"center",type:"ckeditor"},
		],
		//"i18n":{"sUrl": "js/DataTablesExt/dataTables.editor.zh_CN.json"}
	} );
	
	branchButtons = getBranchButtons(js_privilege,editor);
	


    $(data_list_sel).on( 'click', ' tbody td:nth-child(2),\
    								tbody td:nth-child(3),\
    								tbody td:nth-child(4),\
    								tbody td:nth-child(5),\
    								tbody td:nth-child(6),\
    								tbody td:nth-child(7),\
    								tbody td:nth-child(8)', function (e) {
        editor.inline( this, {
            buttons: { label: '&radic;', fn: function () { this.submit(); } }
        } );
    } );	

	var oTable=$(data_list_sel).dataTable({
		"sDom": "Tfrtip",
		"pageLength":20,
		"sAjaxSource":datalist_ajax_url,
		"aoColumns": [
			{"mData": "id"			,"sClass": "td_center" },
			{"mData": "name"			,"sClass": "td_center" },
			{"mData": "type"			,"sClass": "td_center" },
			{"mData": "alias"			,"sClass": "td_center" },
			{"mData": "keyword"			,"sClass": "td_center" },
			{"mData": "money_type"		,"sClass": "td_center" },
			{"mData": "price"			,"sClass": "td_center" },
			{"mData": "is_free"			,"sClass": "td_center", "mRender":function(val,type,row){
				if(val==1){
					return 'Y';
				}else{
					return 'N';
				}
			}},
			//{"mData": "content"			,"sClass": "td_center" },
			{
                "mData": null, 
                "sClass": "center",
				"mRender": function ( val, type, row ) {
					var ops=
					'<a href="javascript:void(0)" onclick="goHeroDetail(\''+row.id+'\')"><span class="LAN_Detail">详情</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroStrategy(\''+row.id+'\')"><span class="LAN_Strategy">攻略</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroVideos(\''+row.id+'\')"><span class="LAN_Video">视频</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroWeapons(\''+row.id+'\')"><span class="LAN_Weapon">武器</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroEquipments(\''+row.id+'\')"><span class="LAN_Equipment">装备</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroSkills(\''+row.id+'\')"><span class="LAN_Skill">技能</span></a> '
					+'/ <a href="javascript:void(0)" onclick="goHeroTalent(\''+row.id+'\')"><span class="LAN_Talent">天赋</span></a> ';
					
					//if(row.gpid!=GPID_getRoot())ops+='/ <a href="" class="editor_remove"><span class="LAN_Delete">删除</span></a>';
					
					return  ops;
				}
                
            }
		],
		"oTableTools": {
			"sRowSelect": "single",
			"aButtons":branchButtons
		},
		"fnDrawCallback": function( oSettings ) {  reloadLanguage(); },//重新翻译语言
		"oLanguage": {	"sUrl": _getDataTablesLanguageUrl()} //本地化文件位置，函数位于 js/lingua/lan.lingua.js
		
	} );

	//字段搜索
	$("<tr>"
	+'<th><input type="text" id="filterId"></th>'
	+'<th><input type="text" id="filterName"></th>'
	+'<th><input type="text" id="filterType"></th>'
	+'<th colspan="6"></th>'
	+"</tr>").prependTo(data_list_sel+' thead');

	$("#filterId").keyup( function () {
        oTable.fnFilter( this.value, 0 );
    } );
	$("#filterName").keyup( function () {
        oTable.fnFilter( this.value, 1 );
    } );
	$("#filterType").keyup( function () {
        oTable.fnFilter( this.value, 2 );
    } );
}

function goHeroDetail(heroid){
	jump("?m=material&c=index&a=heroDetail&id="+heroid);
}

function goHeroStrategy(heroid){
	jump("?m=material&c=article&a=strategy&root_catalog=1005000000000000000&cite_module=hero_strategy&cite_id="+heroid);
}

function goHeroVideos(heroid){
	jump("?m=material&c=media&a=video&root_catalog=1006000000000000000&cite_module=cm_hero&cite_id="+heroid);
}

function goHeroWeapons(heroid){
	jump("?m=material&c=equipment&a=weapon&cite_module=cm_hero&cite_id="+heroid);
}

function goHeroEquipments(heroid){
	jump("?m=material&c=equipment&a=equipment&cite_module=cm_hero&cite_id="+heroid);
}
function goHeroSkills(heroid){
	jump("?m=material&c=equipment&a=skill&cite_module=cm_hero&cite_id="+heroid);
}
function goHeroTalent(heroid){
	jump("?m=material&c=index&a=heroTalent&cite_module=cm_hero&id="+heroid);
}
