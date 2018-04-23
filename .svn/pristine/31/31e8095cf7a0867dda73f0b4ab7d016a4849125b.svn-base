<?php  if(isset($public)){ $this->display($public) ;} ?>
<div class="main" style="min-height:800px; overflow:hidden;">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i>商户管理</li>
                <li><i class="fa fa-sitemap"></i><a href="index.php?m=index&c=index&a=myagent">我的代理</a></li>
                <li><i class="fa fa-plus"></i><a href="index.php?m=index&c=index&a=addagent">添加代理</a></li>
            </ol>
        </div>
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><i class="fa fa-sitemap red"></i><span class="break"></span><strong>添加代理</strong></h2>
                    <div class="panel-actions">
                        <div class="form-group pull-right">
                            <a href="javascript:history.back(-1);" class="btn btn-success" style="padding-left:10px; color:#FFF; padding-right:10px;">返回</a>
                        </div>
                    </div>

                </div>

                <form name="form1" id="form1" method="post" action="index.php?m=index&c=index&a=addagent" onsubmit="return pd();">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">新的代理昵称</span>
                                <input type="text" id="name" name="nick_name" class="form-control" onkeyup="check(this.name,this.value)" placeholder="填写新的代理昵称">
                                <span class="input-group-addon" id="txtnick_name">待检测</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">新代理微信号</span>
                                <input type="text" id="wechat" name="wexin" class="form-control" onkeyup="check(this.name,this.value)" placeholder="新的代理微信号">
                                <span class="input-group-addon" id="txtwexin">待检测</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">新代理手机号</span>
                                <input type="text" id="tel" name="phone" class="form-control" onkeyup="check(this.name,this.value)" placeholder="新的手机号码">
                                <span class="input-group-addon" id="txtphone">待检测</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">请填写身份证</span>
                                <input type="text" id="idcard" name="id_no" class="form-control" onkeyup="check(this.name,this.value)" placeholder="15或18位身份证号码，18位结尾的X必须大写">
                                <span class="input-group-addon" id="txtid_no">待检测</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="city_4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">选择所在的省</span>
                                        <select name="province" class="prov form-control" id="province"  onchange="changeSelect(this);">
                                            <option value="000000">-请选择省-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">选择所在的市</span>
                                        <select name="city" class="city form-control" id="city"  onchange="changeSelect(this);">
                                            <option value="000000">-请选择市-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">选择所在的区</span>
                                        <select name="area" class="dist form-control" id="district">
                                            <option value="000000">-请选择区-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">选择服务城市</span>
                                <select name="service_city" class="form-control" id="service_city">
                                    <option value="1">长沙市</option>
                                    <option value="2">岳阳市</option>
                                    <option value="3">常德市</option>
                                    <option value="4">衡阳市</option>
                                    <option value="5">益阳市</option>
                                    <option value="6">娄底市</option>
                                    <option value="7">邵阳市</option>
                                    <option value="8">怀化市</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">填写详细地址</span>
                                <input type="text" id="address" name="address" class="form-control" placeholder="您的详细地址">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> 确认添加</button>
                        <a href="javascript:history.back(-1);" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> 返回</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/static/mobile/area.js"></script>
<script language="javascript">
    /*地区类*/
    function place(AreaCode,Name){
        this.AreaCode=AreaCode;//地区编码
        this.Name=Name;//地名
        /*地区类的PlaceType方法，返回值：String类型，表示地区类别，"p"代表省/直辖市、特别行政区，"c"代表市，"d"代表区/县。*/
        place.prototype.PlaceType=function(){
            var ac=parseInt(this.AreaCode);
            if(ac%100!=0){
                return "d";
            }else if(ac%10000!=0){
                return "c";
            }else{
                return "p";
            }
        }
        /*返回地点所属省编码*/
        place.prototype.ProvinceCode=function(){
            //整除10000得到省级编码（前2位数字）
            var ac=parseInt(this.AreaCode);
            return Math.floor(ac/10000);
        }
        /*返回地点所属市编码*/
        place.prototype.CityCode=function(){
            //整除100得到市级编码（前4位数字）
            var ac=parseInt(this.AreaCode);
            return Math.floor(ac/100);
        }
    }

    var provinces=new Array();//省数组
    var cities=new Array();//市数组
    var districts= new Array();//区数组
    /*initSeletList()这个函数初始化上面这三个数组，还有省下拉列表*/
    function initSeletList(){
        //遍历placesMap这个Json对象,根据key：value对创建place对象，并根据地区类型分类
        for (var key in placesMap){
            var pl=new place(key,placesMap[key]);
            var ty=pl.PlaceType();
            if(ty=="p"){
                provinces.push(pl);
            }
            if(ty=="c"){
                cities.push(pl);
            }
            if(ty=="d"){
                districts.push(pl);
            }
        }
        //初始化省下拉选择列表
        for(var i=0;i<provinces.length;i++){
            var op=document.createElement("option");
            op.text=provinces[i].Name;
            op.value=provinces[i].ProvinceCode();
            document.getElementById("province").appendChild(op);
        }
    }
    /*下拉列表选项改变时执行此函数*/
    function changeSelect(element){

        var id=element.getAttribute("id");
        //alert(id);
        /*省下拉列表改变时更新市下拉列表和区下拉列表*/
        if(id=="province"&&element.value!="000000"){
            document.getElementById("city").options.length=1;//清除市下拉列表旧选项
            var pCode=parseInt(element.value);//获取省下拉列表被选取项的省编码
            //alert(pCode);
            /*根据省编码更新市下拉列表*/
            if(pCode!=0){
                for(var i=0;i<cities.length;i++){
                    if(cities[i].ProvinceCode()==pCode){
                        var op=document.createElement("option");
                        op.text=cities[i].Name;
                        op.value=cities[i].CityCode();
                        document.getElementById("city").appendChild(op);
                    }
                }
            }
            document.getElementById("district").options.length=1;//清除区下拉列表旧选项
            var cCode=parseInt(document.getElementById("city").value);//获取市下拉列表被选中项的市编码
            /*根据市编码更新区下拉列表*/
            if(cCode!=0){
                for(var i=0;i<districts.length;i++){
                    if(districts[i].CityCode()==cCode){
                        var op=document.createElement("option");
                        op.text=districts[i].Name;
                        op.value=districts[i].AreaCode;
                        document.getElementById("district").appendChild(op);
                    }
                }
            }
        }
        /*市下拉列表改变时更新区下拉列表的选项*/
        if(id=="city"&&element.value!="000000"){
            document.getElementById("district").options.length=1;//清除区下拉列表旧选项
            var cCode=parseInt(element.value);//获取市下拉列表被选中项的市编码
            /*根据市编码更新区下拉列表*/
            for(var i=0;i<districts.length;i++){
                if(districts[i].CityCode()==cCode){
                    var op=document.createElement("option");
                    op.text=districts[i].Name;
                    op.value=districts[i].AreaCode;
                    document.getElementById("district").appendChild(op);
                }
            }

        }
    }
    window.onload=function(){
        initSeletList();
    };

    function check(name,value){
        if(value == ''){
            $('#txt'+name).text('待检测');
        }else{
            $.ajax({
                url:"index.php?m=index&c=index&a=checkone&field="+name+"&value="+value,
                type:"get",
                success:function(result){
                    if(result == 0){
                        $('#txt'+name).text('可以使用');
                    }else {
                        $('#txt'+name).text('已被占用');
                    }
                }
            })
        }

    }

    function pd()
    {
        var name = document.form1.name.value;
        var wechat = document.form1.wechat.value;
        var tel = document.form1.tel.value;
        var service_city = document.form1.service_city.value;
        var idcard = document.form1.idcard.value;
        var pdtel=/^1[3|4|5|7|8|9]\d{9}$/;//判断电话
        var pdidcard=/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
        if(name=="")
        {
            alert("昵称不能为空！");
            return false;
        }
        if(wechat=="")
        {
            alert("微信号不能为空！");
            return false;
        }
        if(!pdtel.test(tel))
        {
            alert("请填写正确的手机号码！");
            return false;
        }
        // if(!pdidcard.test(idcard))
        // {
        //     alert("请填写正确的15或18位身份证号码！");
        //     return false;
        // }
        if(service_city=="")
        {
            alert("服务城市不能为空！");
            return false;
        }
    }
</script>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>



<!-- theme scripts -->
<script src="assets/js/SmoothScroll.js"></script>
<script src="assets/js/jquery.mmenu.min.js"></script>
<script src="assets/js/core.min.js"></script>

<!-- inline scripts related to this page -->
<script src="assets/js/pages/ui-elements.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.cityselect.js"></script>
<script type="text/javascript">
    $(function(){
        $("#city_4").citySelect({
            prov: "湖南",
            city: "长沙",
            dist: "天心区",
            nodata: "none"
        });
    });
</script>


</body>
</html>