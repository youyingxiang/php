
<?php Doris\DApp::loadClass("FormBS");  ?>
<div class="panel-search" >
    <p >
    <form  role="form "class="form-horizontal"  action="?" method ="post">
        <div class="text-left well" style="padding-top:20px">
            <!-- 第二行 -->
            <div class="form-group  ">
                <div class="col-sm-12">
                    <label class=" text-right">结算单状态：<span id="id-status" class="green"></span>
                    </label>

                    <label class=" text-right">，订单总数：<span id="id-ordernum"></span></label>

                    <label class=" text-right">，充值总金额：<span id="id-amount"></span></label>

                    <label class=" text-right">，可结算金额：<span id="id-settle"></span></label>

                    <label class=" text-right">，结算周期：<span id="id-date"></span></label>
                    <label class=" text-right " id="rebate-stat"></label>


                </div>

            </div>


            <!-- 第三行 -->
            <div class="form-group  ">
                <div class="col-sm-12">
                    <label class=" text-right">所有订单号：</label>
                    <div style='width: 100%;display:block;word-break: break-all;word-wrap: break-word;'
                         class="green" id="id-oids">
                    </div>

                </div>

            </div>

        </div>
    </form>
    </p>
</div>

<h2>用户订单明细：</h2>
