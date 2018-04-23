
function getValByJsonstr(jstr,key){
	jstr=jstr.slice(jstr.indexOf("{")+1);
	jstr=jstr.slice(0,jstr.lastIndexOf("}"));
	ar=jstr.split(",");
	for(i=0;i<ar.length;i++){
		pair=ar[i].split(":");
		k=pair[0];
		if(k.lastIndexOf("\"")>0){
			k=k.slice(k.indexOf("\"")+1);
			k=k.slice(0,k.lastIndexOf("\""));
		}
		if(k==key){
			v=pair[1];
			if(v.lastIndexOf("\"")>0){
				v=v.slice(v.indexOf("\"")+1);
				v=v.slice(0,v.lastIndexOf("\""));
			}
			return v;
		}
	}
	return "";
}

function getUploadifyTemplate(){
	var template='<div id="${fileID}" class="uploadify-queue-item clearfix photoItem">\
				<div class="img"><a target="_blank"><img /></a>\
				</div>\
				<div class="info">\
					  <div class="cancel"> \
						<a href="javascript:$(\'#${instanceID}\').uploadify(\'cancel\', \'${fileID}\');onServerCancel(\'${fileID}\',\'${fileName}\',\'\')">X</a>\
					  </div>\
					  <span class="fileName">${fileName} (${fileSize})</span><span class="data"></span>\
					  <div class="uploadify-progress">\
						<div class="uploadify-progress-bar"></div>\
					  </div>\
				</div>\
				<div style="clear:both;"></div>\
			</div>';
	return  template;
}


function getUploadifyInitTemplate(db_id,fileid,picName,img,thumb){
	var template='<div id="'+fileid+'" class="uploadify-queue-item clearfix photoItem">\
			<div class="img"><a href="'+img+'" target="_blank"><img src="'+thumb+'"/></a>\
	    	</div>\
			<div class="info">\
				  <div class="cancel"> \
				  	<a href="javascript:$(\'#file_upload\').uploadify(\'cancel\', \''+fileid+'\');onServerCancel(\''+fileid+'\',\''+picName+'\',\''+db_id+'\')">X</a>\
				  </div>\
				  <span class="fileName">'+picName+'<span class="data"> - 完成</span></span>\
				  <div class="uploadify-progress">\
					<div class="uploadify-progress-bar" style="width: 100%; "></div>\
				  </div>\
			</div>\
			<div style="clear:both;"></div>\
		</div>';
	return  template;
}


function onServerCancel(fileID,fileName,serverItemID){
	action="?m=upload&c=image&a=delete";
	//if(mode=="edit")action="edit/uploadifydel";
	$.post(action, {id : serverItemID,name : fileName}, function(data) {
		//$("body").append(data+"<hr>");
		if(data.code==true){
			alert("成功:"+data.msg);
		}else{
			alert("出错了:"+data.msg);
		}
	},"json");//
}

var extension = "*.gif;*.jpg;*.jpeg;*.png" ;
var needAlert = false;
var alertMsg = '';
function applyImgUploadify( selectorId,queueId,btnText,session_id,url,extension,needAlert,alertMsg){
	var url = url+"&sessionid="+session_id; 
	var  fnTimestamp=function(){return Math.round(new Date().getTime()/1000);}
	var timestamp=fnTimestamp();
	$('#'+selectorId).uploadify({
		formData     : {
			'timestamp' : timestamp,
			'token'     : hex_md5('unique_salt' + timestamp)
		},
		height: 30,
		width: 150,
		//	fileSizeLimit   : 4096,  
		langFile:'static/js/uploadify/uploadifyLang_cn.js',
		swf      : 'static/js/uploadify/uploadify.swf',
		uploader : url,
		//checkScript :'check-exists',
		fileTypeExts:extension,
		checkExisting:true,
		auto :true,
		multi: false,
		removeCompleted:true,
		queueID  : queueId,
		buttonText:btnText,
		onUploadSuccess : function(file, data, response) {
			//document.write(data);
			//alert(data);
			/*alert("消息", 'id: ' + file.id
		　　+ ' - 索引: ' + file.index
		　　+ ' - 文件名: ' + file.name
		　　+ ' - 文件大小: ' + file.size
		　　+ ' - 类型: ' + file.type
		　　+ ' - 创建日期: ' + file.creationdate
		　　+ ' - 修改日期: ' + file.modificationdate
		　　+ ' - 文件状态: ' + file.filestatus);///*///
			var ret = jQuery.parseJSON(data);
			if(ret.code == 0){ //上传失败
				alert(ret.message);
			}else{
				var imgurl = ret.url;
				$('.'+selectorId).val(ret.url);
				$('.'+selectorId).attr('src',ret.url);
				$('.'+selectorId).parent('a').attr('href',ret.url);
				$('.'+selectorId).attr('href',ret.url);
				if(needAlert){
					alert(alertMsg);
				}
				
			}

		},
		onDestroy : function() {
			alert('上传插件已被销毁');
		},
		onCancel : function(file) {//上传完成后再点取消无效
			alert('文件：' + file.name + ' 已取消。');
		},
		onUploadError : function(file, errorCode, errorMsg, errorString) {
			alert('文件' + file.name + ' 不能上传：' + errorString);
		},
		 onFallback : function() {
			alert('未找到Flash文件');
		},
		onDisable : function() {
			alert('您已经取消上载插件');
		}
		//itemTemplate : getUploadifyTemplate()
	});
}

function FileUploadify(selectorId,queueId,btnText,session_id,url,extension){
	var url = url+"&sessionid="+session_id; 
	var  fnTimestamp=function(){return Math.round(new Date().getTime()/1000);}
	var timestamp=fnTimestamp();
	$('#'+selectorId).uploadify({
		formData     : {
			'timestamp' : timestamp,
			'token'     : hex_md5('unique_salt' + timestamp)
		},
		height: 30,
		width: 150,
		fileSizeLimit   : 524288000,  
		langFile:'static/js/uploadify/uploadifyLang_cn.js',
		swf      : 'static/js/uploadify/uploadify.swf',
		uploader : url,
		//checkScript :'check-exists',
		fileTypeExts:extension,
		checkExisting:true,
		auto :true,
		multi: false,
		removeCompleted:true,
		queueID  : queueId,
		buttonText:btnText,
		onUploadSuccess : function(file, data, response) {
			//document.write(data);
			/*alert("消息", 'id: ' + file.id
		　　+ ' - 索引: ' + file.index
		　　+ ' - 文件名: ' + file.name
		　　+ ' - 文件大小: ' + file.size
		　　+ ' - 类型: ' + file.type
		　　+ ' - 创建日期: ' + file.creationdate
		　　+ ' - 修改日期: ' + file.modificationdate
		　　+ ' - 文件状态: ' + file.filestatus);///*///
			var ret = jQuery.parseJSON(data);
			if(ret.code == 0){ //上传失败
				alert(ret.message);
			}else{
				var imgurl = ret.url;
				$('.'+selectorId).val(ret.url);
				$('.'+selectorId).html(ret.url);
				$('.'+selectorId).attr('href',ret.url);
				alert("上传成功");
			}

		},
		onDestroy : function() {
			alert('上传插件已被销毁');
		},
		onCancel : function(file) {//上传完成后再点取消无效
			alert('文件：' + file.name + ' 已取消。');
		},
		onUploadError : function(file, errorCode, errorMsg, errorString) {
			alert('文件' + file.name + ' 不能上传：' + errorString);
		},
		 onFallback : function() {
			alert('未找到Flash文件');
		},
		onDisable : function() {
			alert('您已经取消上载插件');
		}
		//itemTemplate : getUploadifyTemplate()
	});
}


(function($){
	//applyImgUploadify("file_upload",'file_upload_queue',session_id,"solution","test");
}(jQuery));