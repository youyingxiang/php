<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
	<title>摸摸游戏小伙伴登录</title>
	<link href="/static/mobile/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/static/mobile/assets/css/jquery.mmenu.css" rel="stylesheet">
	<link href="/static/mobile/assets/css/font-awesome.min.css" rel="stylesheet">
	<link href="/static/mobile/assets/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
	<link href="/static/mobile/assets/css/style.min.css" rel="stylesheet">
	<link href="/static/mobile/assets/css/add-ons.min.css" rel="stylesheet">
</head>
<body class="body_bj1">


<div  class="col-lg-12">

	<div class="login-box" style="width:100%;">

		<div class="header">摸摸游戏小伙伴登录</div>


		<form role="form" class="form-horizontal" action="?m=index&c=login" method="post">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input name="name" id="username"  type="text" class="form-control" placeholder="输入帐号"/>
				</div>
			</div>
			<div class="form-group">
				<div class="controls">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<input  name="secret" id="password" type="password" class="form-control" placeholder="输入密码"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="controls">
					<div class="input-group">
						<span class="input-group-addon"><?php echo $_SESSION['ycode'];?></span>
						<input name="ycode" type="text" class="form-control" id="yzm1" placeholder="输入验证码"/>
						<input name="yzm2" type="text" class="form-control" id="yzm2" value="3771" style="display:none"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<input name="agreement" id="agreement" type="checkbox" value="1">
				<label for="agreement">我已阅读并同意</label>
				<label for="agreement"><a href="?m=index&c=index&a=agreement">《摸摸游戏代理协议》</a></label>
			</div>
			<div class="form-group">
				<input name="agree" id="agree" type="checkbox" value="1">
				<label for="agree">记住帐号</label>
			</div>
			<div class="form-group"><button type="submit" id="button_sub" name="submit" class="btn btn-lg btn-default col-xs-12">登录</button></div>
		</form>
		<div class="clearfix"></div>

	</div>


</div>
<!-- start: JavaScript-->
<!--[if !IE]>-->

<script src="/static/mobile/assets/js/jquery-2.1.1.min.js"></script>

<!--<![endif]-->

<!--[if IE]>

<script src="/static/mobile/assets/js/jquery-1.11.1.min.js"></script>

<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
	window.jQuery || document.write("<script src='/static/mobile/assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>

<!--<![endif]-->

<!--[if IE]>

<script type="text/javascript">
	window.jQuery || document.write("<script src='/static/mobile/assets/js/jquery-1.11.1.min.js'>"+"<"+"/script>");
</script>

<![endif]-->
<script src="/static/mobile/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/static/mobile/assets/js/bootstrap.min.js"></script>


<!-- page scripts -->

<!-- theme scripts -->
<script src="/static/mobile/assets/js/SmoothScroll.js"></script>
<script src="/static/mobile/assets/js/jquery.mmenu.min.js"></script>
<script src="/static/mobile/assets/js/core.min.js"></script>

<!-- inline scripts related to this page -->
<script src="/static/mobile/assets/js/pages/login.js"></script>

<!-- end: JavaScript-->
<script type="text/javascript">
	var storage = window.localStorage;
	//用户协议
	if("yes" == storage["isagreement"]){
		$("#agreement").attr("checked", true);
		button_disabled_true();
	}else{
		$("#agreement").attr("checked", false);
		button_disabled();
	}
	$('#agreement').on('click', function(){
		if($("#agreement").is(':checked')){
			//存储到loaclStage
			button_disabled_true();
			storage["isagreement"] =  "yes";
		}else{
			button_disabled();
			storage["isagreement"] =  "no";
		}
	});

	//记住用户
	if("yes" == storage["agree"]){
		$("#agree").attr("checked", true);
		$("#user").val(storage["loginname"]);
	}else{
		$("#agree").attr("checked", false);
	}
	$("#user").blur(function(){
		if($('#agree').attr('checked')){
			storage["loginname"] = $("#user").val();
		}
	});
	$('#agree').on('click', function(){
		if($("#agree").is(':checked')){
			//存储到loaclStage
			storage["agree"] =  "yes";
			storage["loginname"] = $("#user").val();
		}else{
			storage["agree"] =  "no";
			storage["loginname"] = "";
		}
	});

	//提价按钮不可选
	function button_disabled(){
		$("#button_sub").attr('disabled',true);
		$("#button_sub").removeClass("btn-primary");
		$("#button_sub").addClass("btn-default");
	}
	//提价按钮可选
	function button_disabled_true(){
		$("#button_sub").attr('disabled',false);
		$("#button_sub").removeClass("btn-default");
		$("#button_sub").addClass("btn-primary");
	}
</script>

</body>
</html>
