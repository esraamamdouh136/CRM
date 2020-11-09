<?php $this->load->view("header") ?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:10%; margin-left:3%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">

        <!--Date And Time-->
        <div class="container">

            <?php $this->load->view("Admin/DateTimeDiv"); ?>

        </div>
        <!--Date And Time-->

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                            <tbody>
                            <tr>
                                <td><b> اسم الموظف : </b><span><?= get_Emp_name(isset($UserID)?$UserID:0)?></span></td>
                                <td><b> اجمالى عدد المكالمات  : </b><span><?= isset($TotalCalls)?$TotalCalls:0 ?></span></td>
                                <td><b>  عدد المكالمات الجديده : </b><span><?= isset($TotalNewCalls)?$TotalNewCalls:0?></span></td>
                                <td><b>  عدد المكالمات المنتهيه :  </b><span><?= ($TotalCalls -$TotalNewCalls) ?></span></td>


                            </tr>
                            <tr>
                                <td>نسبة المبيعات المتوقعه </td>
                                <td><input type="number" id="targetamount" value="0" min="0"></td>
                                <td><button id="calculat">حساب النسبة المستهدفة</button></td>
                                <td><label id="target">0%</label></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="m-portlet__body">


            <!--Chart.js Start-->
            <div class="row my-5">

                <div class="col-lg-6 ">
                    <div class=" chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        تم الرد(<?= isset($AnswerCallsCount)?$AnswerCallsCount:0 ?>)
                                    </h3>


                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="btn-group dropDown">
                                            <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#AnswerCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="attend-chart"  style="height:auto;cursor:pointer;" id="AnswerCallsPrint">
                            <div class="chartDiv" id="AnswerCalls"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        لم يتم الرد(<?= isset($NoAnswerCallsCount)?$NoAnswerCallsCount:0 ?>)
                                    </h3>

                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="btn-group dropDown">
                                            <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#NoAnswerCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="attend-chart"  style="height:auto;cursor:pointer;" id="NoAnswerCallsPrint">
                            <div class="chartDiv" id="NoAnswerCalls"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-5">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">


                        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text col-lg-12">
                                            إرقام خطأ(<?= isset($WrongCallsCount)?$WrongCallsCount:0 ?>)

                                        </h3>

                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <div class="btn-group dropDown">
                                                <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    تغير الرسم البيانى
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                    <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                                </div>
                                            </div>
                                            <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#WrongCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="attend-chart"  style="height:auto;cursor:pointer;" id="WrongCallsPrint">
                                <div id="WrongCalls" class="chartDiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        قيد الحجز(<?= isset($ReservationCallsCount)?$ReservationCallsCount:0 ?>)

                                    </h3>

                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="btn-group dropDown">
                                            <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#ReservationCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="attend-chart"  style="height:auto;cursor:pointer;" id="ReservationCallsPrint">
                            <div class="chartDiv" id="ReservationCalls"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 mt-5">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        تم التعاقد(<?= isset($contractCallsCount)?$contractCallsCount:0 ?>)

                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="btn-group dropDown">
                                            <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#contractCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="attend-chart"  style="height:auto;cursor:pointer;" id="contractCallsPrint">
                            <div class="chartDiv" id="contractCalls"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 mt-5">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 id="callsCount" class="m-portlet__head-text">
                                        إلغاء التعاقد(<?= isset($DecontractCallsCount)?$DecontractCallsCount:0 ?>)
                                    </h3>

                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="btn-group dropDown">
                                            <button type="button" class="btn btn-info dropdown-toggle ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#DecontractCallsPrint').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="attend-chart"  style="height:auto;cursor:pointer;" id="DecontractCallsPrint">
                            <div class="chartDiv" id="DecontractCalls"></div>
                        </div>
                    </div>
                </div>



            </div>
            <!--Chart.js End-->








        </div>

    </div>








</div>











<script src="assets/js/d3.min.js"></script>
<script src="assets/js/c3.js"></script>
<script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>




<script>
    var AnswerCallsColumns =[];
    var NoAnswerCallsColumns =[];
    var ReservationCallsColumns =[];
    var WrongCallsColumns =[];
    var contractCallsColumns =[];
    var DecontractCallsColumns =[];
    <?php if (isset($AnswerCalls)){
    for ($i=0;$i<count($AnswerCalls);$i++){?>
    AnswerCallsColumns[<?php echo $i ?>] = ["<?php echo $AnswerCalls[$i]->title ?>",<?php echo $AnswerCalls[$i]->count ?>];
    <?php }} ?>

    <?php if (isset($NoAnswerCalls)){
    for ($i=0;$i<count($NoAnswerCalls);$i++){?>
    NoAnswerCallsColumns[<?php echo $i ?>] = ["<?php echo $NoAnswerCalls[$i]->title ?>",<?php echo $NoAnswerCalls[$i]->count ?>];
    <?php }} ?>
    <?php if (isset($ReservationCalls)){
    for ($i=0;$i<count($ReservationCalls);$i++){?>
    ReservationCallsColumns[<?php echo $i ?>] = ["<?php echo $ReservationCalls[$i]->title ?>",<?php echo $ReservationCalls[$i]->count ?>];
    <?php }} ?>
    <?php if (isset($WrongCalls)){
    for ($i=0;$i<count($WrongCalls);$i++){?>
    WrongCallsColumns[<?php echo $i ?>] = ["<?php echo $WrongCalls[$i]->title ?>",<?php echo $WrongCalls[$i]->count ?>];
    <?php }} ?>
    <?php if (isset($contractCalls)){
    for ($i=0;$i<count($contractCalls);$i++){?>
    contractCallsColumns[<?php echo $i ?>] = ["<?php echo $contractCalls[$i]->title ?>",<?php echo $contractCalls[$i]->count ?>];
    <?php }} ?>
    <?php if (isset($DecontractCalls)){
    for ($i=0;$i<count($DecontractCalls);$i++){?>
    DecontractCallsColumns[<?php echo $i ?>] = ["<?php echo $DecontractCalls[$i]->title ?>",<?php echo $DecontractCalls[$i]->count ?>];
    <?php }} ?>




    chartGeneral('pie', 'AnswerCalls',AnswerCallsColumns);
    chartGeneral('pie', 'NoAnswerCalls',NoAnswerCallsColumns);
    chartGeneral('pie', 'WrongCalls',WrongCallsColumns);
    chartGeneral('pie', 'ReservationCalls',ReservationCallsColumns);
    chartGeneral('pie', 'contractCalls',contractCallsColumns);
    chartGeneral('pie', 'DecontractCalls',DecontractCallsColumns);



    // c3.generate({
    //     bindto: '#AnswerCalls',
    //     data: {
    //         columns: AnswerCallsColumns,
    //         type : 'pie'
    //     }
    // });
    //
    // c3.generate({
    //     bindto: '#NoAnswerCalls',
    //     data: {
    //         columns: NoAnswerCallsColumns,
    //         type : 'pie'
    //     }
    // });
    //
    // c3.generate({
    //     bindto: '#ReservationCalls',
    //     data: {
    //         columns: ReservationCallsColumns,
    //         type : 'pie'
    //     }
    // });
    //
    // c3.generate({
    //     bindto: '#WrongCalls',
    //     data: {
    //         columns: WrongCallsColumns,
    //         type : 'pie'
    //     }
    // });
    //
    // c3.generate({
    //     bindto: '#contractCalls',
    //     data: {
    //         columns: contractCallsColumns,
    //         type : 'pie'
    //     }
    // });

    // c3.generate({
    //     bindto: '#DecontractCalls',
    //     data: {
    //         columns: DecontractCallsColumns,
    //         type : 'pie'
    //     }
    // });



    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/employeeDetails/<?=$UserID?>/" + DateRange;
    });
    $("#calculat").click(function () {
        var amount = $("#targetamount").val();
        var EmpAmount = "<?=isset($totalAmount)?$totalAmount:0?>";

        if (amount > 0){
            var target = (EmpAmount/amount)*100;
            $("#target").text((Math.round(target * 100) / 100) +'%'+'  من  '+ EmpAmount);
            // alert(EmpAmount/amount);
        }

    });



    $.fn.extend({
        print: function() {
            var frameName = 'printIframe';
            var doc = window.frames[frameName];
            if (!doc) {
                $('<iframe>').hide().attr('name', frameName).appendTo(document.body);
                doc = window.frames[frameName];
            }
            doc.document.body.innerHTML = this.html();
            doc.window.print();
            return this;
        }
    });
</script>

</body>

</html>