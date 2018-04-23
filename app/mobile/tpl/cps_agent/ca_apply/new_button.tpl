<a href="#" id="id-btn-dialog2" class="btn btn-info btn-sm" xmlns="http://www.w3.org/1999/html">申请结算</a>
<div id="dialog-message" class="hide">

</div><!-- #dialog-message -->

<div id="dialog-confirm" class="hide">
    <div class="alert alert-info bigger-110">
        请选择结算时间
    </div>

    <div class="space-6"></div>
    <p class="bigger-110 bolder center grey" style="width: auto">
        <form action="" method="post"/>
    <input type="hidden" name="agent_id" id="agent_id" value="<?php echo $agent_id;?>"/>
        <select name="start_time" id="start_time">
            <?php foreach($settle_time as $row){ ?>
                <option value="<?php echo $row;?>"><?php echo $row;?></option>
            <?php } ?>
        </select>
        </form>
    </p>
</div><!-- #dialog-confirm -->
<!-- ace styles -->
<link rel="stylesheet" href="/static/assets/css/ace.min.css" />
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="/static/assets/css/bootstrap.min.css" />
<script src="/static/assets/js/ace-v1.3/jquery.min.js"></script>

<script type="text/javascript">
        $( "#id-btn-dialog2" ).on('click', function(e) {
            e.preventDefault();

            $("#dialog-confirm").removeClass('hide').dialog({
                resizable: false,
                modal: true,
                title: "",
                title_html: true,
                buttons: [
                    {
                        html: "&nbsp;取消&nbsp; ",
                        "class": "btn btn-danger btn-xs",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                    ,
                    {
                        html: "&nbsp;确定&nbsp; ",
                        "class": "btn btn-xs",
                        click: function () {
                            var start_time = $('#start_time').val();
                            if(start_time != null){
                                var agent_id = $('#agent_id').val();
                                window.location.href="index.php?m=cps_agent&c=ca_apply&a=apply_show&start_time="+start_time+"&agent_id="+agent_id;
                            }else{
                                alert('您没有订单可以结算');
                            }
                        }
                    }
                ]
            });
        });
</script>
<script src="/static/assets/js/ace-v1.3/ace-elements.min.js"></script>
<script src="/static/assets/js/ace-v1.3/ace-extra.min.js"></script>
<script src="/static/assets/js/ace-v1.3/jquery.ui.touch-punch.min.js"></script>
<script src="/static/assets/js/ace-v1.3/jquery-ui.min.js"></script>