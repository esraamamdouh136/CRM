<?php $this->load->view("header") ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top:2%; margin-right:10%; margin-left:3%;">
    <div class="m-content">
        <!--Date And Time-->
        <div class="container">
            <?php $this->load->view("Admin/DateTimeDiv"); ?>
        </div>

        <div class="row mt-5 chart-caption">
            <div class="col-lg-6">
                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    السن
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
                                    <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#print1').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div  id="print1" class="attend-chart" style="height:330px; cursor:pointer;">
                        <div class="chartDiv" id="Age"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div  class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    المحافظة
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
                                    <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#print2').print();" >
                                    <span>
                                        <span> طباعة</span>
                                    </span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="print2" class="attend-chart"  style="height:330px; cursor:pointer;">
                        <div class="chartDiv" id="GovernmentGovernment"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        الوظيفه
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

                                        <button class="btn btn-info m-btn--icon ml-2"  onclick="$('#print3').print();" >
                                    <span>

                                        <span> طباعة</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id='print3' class="attend-chart" style="height:330px; cursor:pointer;">
                            <div class="chartDiv" id="JobClass" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Chart.js End-->
    </div>
</div>

<script src="assets/js/d3.min.js"></script>
<script src="assets/js/c3.js"></script>
<script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>
<script src="vendors/bootstrap/js/dist/dropdown.js" type="text/javascript"></script>

<script>

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



    var JobColumns =[];
    var AgeColumns =[];
    var GovernmentColumns =[];

    <?php if (isset($Government)){
    for ($i=0;$i<count($Government);$i++){?>
    GovernmentColumns[<?php echo $i ?>] = ["<?php echo $Government[$i]->customerCrmGov ?>",<?php echo $Government[$i]->count ?>];
    <?php }} ?>

    <?php if (isset($Job)){
    for ($i=0;$i<count($Job);$i++){?>
    JobColumns[<?php echo $i ?>] = ["<?php echo $Job[$i]->customerCrmJob ?>",<?php echo $Job[$i]->count ?>];
    <?php }} ?>
    <?php if (isset($Age)){
    ?>

    AgeColumns[0] = ["أقل من 20 سنه",<?php echo $Age[0]->count1 ?>];
    AgeColumns[1] = ["من 20 سنه إلى 25",<?php echo $Age[0]->count2 ?>];
    AgeColumns[2] = ["من 25 سنه إلى 30",<?php echo $Age[0]->count3 ?>];
    AgeColumns[3] = ["من 30 سنه إلى 35",<?php echo $Age[0]->count4 ?>];
    AgeColumns[4] = ["من 35 سنه إلى 40",<?php echo $Age[0]->count5 ?>];
    AgeColumns[5] = ["من 40 سنه إلى 45",<?php echo $Age[0]->count6 ?>];
    AgeColumns[6] = ["من 45 سنه إلى 50",<?php echo $Age[0]->count7 ?>];
    AgeColumns[7] = ["من 50 سنه إلى 55",<?php echo $Age[0]->count8 ?>];
    AgeColumns[8] = ["من 55 سنه إلى 60",<?php echo $Age[0]->count9 ?>];

    <?php } ?>

    chartGeneral('pie', 'Government',GovernmentColumns);
    chartGeneral('pie', 'Age',AgeColumns);
    chartGeneral('pie', 'JobClass',JobColumns);

    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/TargetedClients/" + DateRange;
    });
</script>

</body>

</html>