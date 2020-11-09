<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%">
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="container">
        <div class="m-content">

            <!--Date And Time-->
            <?php $this->load->view("Admin/DateTimeDiv"); ?>
            <!--Date And Time-->




            <!--row 1-->
            <div class="mt-4">
                <div class="m-portlet__body  m-portlet__body--no-padding">

                    <?php $userPer = get_premissions($_SESSION['userid'],'05');
                    if ($_SESSION['usertype'] == 2 || $_SESSION['usertype']==1){
                        ?>
                        <div class="row m-row--no-padding m-row--col-separator-sm">

                            <div class="col-md-12 col-lg-6 col-xl-3 hight_card bg-white">
                                <div class="icons icon-4">
                                    <i class="fa fa-chart-bar"></i>
                                </div>
                                <!--begin::Total Profit-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title">
                                            تم استراد عملاء جدد اليوم
                                        </h4><br>
                                        <span class="m-widget24__desc">
													عدد المكالمات
                                                </span>

                                        <span class="m-widget24__stats m--font-sccess" data-start="0" data-end="<?= isset($PotentialCustomers)?$PotentialCustomers:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
													<?= isset($PotentialCustomers)?$PotentialCustomers:0 ?>
												</span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-success" role="progressbar"
                                                 style="width: 78%;" aria-valuenow="50" aria-valuemin="<?= isset($PotentialCustomers)?$PotentialCustomers:0 ?>"
                                                 aria-valuemax="100"></div>
                                        </div>


                                    </div>
                                </div>

                                <!--end::Total Profit-->
                            </div>
                            <div class="col-md-12 col-lg-6 col-xl-3 hight_card bg-white">
                                <div class="icons icon-2">
                                    <i class="fa fa-chart-pie"></i>
                                </div>
                                <!--begin::New Feedbacks-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title">
                                            عملاء غير موزعين
                                        </h4><br>
                                        <span class="m-widget24__desc">
													يرجى تعينهم
												</span>
                                        <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= isset($NonDistributors)?$NonDistributors:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
                                            <?= isset($NonDistributors)?$NonDistributors:0 ?>
												</span>
                                        <div class="m--space-10">

                                        </div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-barnd" role="progressbar"
                                                 style="width: 84%;" aria-valuenow="50" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>


                                    </div>
                                </div>

                                <!--end::New Feedbacks-->
                            </div>
                            <div class="col-md-12 col-lg-6 col-xl-3 hight_card bg-white">
                                <div class="icons icon-1">
                                    <i class="fa fa-chart-area"></i>
                                </div>
                                <!--begin::New Orders-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title">
                                            عملاء تم توزيعها
                                        </h4><br>
                                        <span class="m-widget24__desc">
													عدد المكالمات
												</span>
                                        <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= isset($Distributors)?$Distributors:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
                                            <?= isset($Distributors)?$Distributors:0 ?>
												</span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-info" role="progressbar"
                                                 style="width: 69%;" aria-valuenow="50" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>


                                    </div>
                                </div>

                                <!--end::New Orders-->
                            </div>
                            <div class="col-md-12 col-lg-6 col-xl-3 hight_card bg-white">
                                <div class="icons icon-3">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <!--begin::New Users-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title">
                                            عملاء متراكمة غير موزعين
                                        </h4><br>
                                        <span class="m-widget24__desc">
													يرجى تعينهم
												</span>
                                        <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= isset($delayedData)?$delayedData:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
                                            <?= isset($delayedData)?$delayedData:0 ?>
												</span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-danger" role="progressbar"
                                                 style="width: 90%;" aria-valuenow="50" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>


                                    </div>
                                </div>

                                <!--end::New Users-->
                            </div>

                        </div>
                    <?php }

                    else if ($_SESSION['usertype']==3){?>

                    <div class="row m-row--no-padding m-row--col-separator-sm">

                        <div class="col-md-12 col-lg-6 col-xl-4 hight_card bg-white">
                            <div class="icons icon-4">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <!--begin::Total Profit-->
                            <div class="m-widget24">
                                <div class="m-widget24__item">
                                    <h4 class="m-widget24__title">
                                        عملائى
                                    </h4><br>
                                    <span class="m-widget24__desc">
													عدد المكالمات
                                                </span>

                                    <span class="m-widget24__stats m--font-sccess" data-start="0" data-end="<?= isset($missionsCount)?$missionsCount:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
													<?= isset($missionsCount)?$missionsCount:0 ?>
												</span>
                                    <div class="m--space-10"></div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-success" role="progressbar"
                                             style="width: 78%;" aria-valuenow="50" aria-valuemin="<?= isset($missionsCount)?$missionsCount:0 ?>"
                                             aria-valuemax="100"></div>
                                    </div>


                                </div>
                            </div>

                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-4 hight_card bg-white">
                            <div class="icons icon-2">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <!--begin::New Feedbacks-->
                            <div class="m-widget24">
                                <div class="m-widget24__item">
                                    <h4 class="m-widget24__title">
                                        المهام التى تمت
                                    </h4><br>
                                    <span class="m-widget24__desc">
													يرجى تعينهم
												</span>
                                    <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= isset($missionsDone)?$missionsDone:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
                                         <?= isset($missionsDone)?$missionsDone:0 ?>
												</span>
                                    <div class="m--space-10">

                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-barnd" role="progressbar"
                                             style="width: 84%;" aria-valuenow="50" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>


                                </div>
                            </div>

                            <!--end::New Feedbacks-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-4 hight_card bg-white">
                            <div class="icons icon-1">
                                <i class="fa fa-chart-area"></i>
                            </div>
                            <!--begin::New Orders-->
                            <div class="m-widget24">
                                <div class="m-widget24__item">
                                    <h4 class="m-widget24__title">
                                        المهام التى لم تتم
                                    </h4><br>
                                    <span class="m-widget24__desc">
													عدد المكالمات
												</span>
                                    <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= isset($missions)?$missions:0 ?>" data-postfix="" data-duration="1500" data-delay="600">
                                          <?= isset($missions)?$missions:0 ?>
												</span>
                                    <div class="m--space-10"></div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-info" role="progressbar"
                                             style="width: 69%;" aria-valuenow="50" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>


                                </div>
                            </div>

                            <!--end::New Orders-->
                        </div>


                    </div>

                </div>
            </div>
            <!--row 4-->
        <?php } ?>
            <div class="mb-3 " id="parent-div">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-sm hight_card2">
                        <?php
                        if (isset($status) && count($status) > 0){
                            $count = 0;
                            foreach($status as $value){
                                $count++;
                                ?>
                                <div class="col-md-12 col-lg-6 col-xl-3 hight_card2 bg-white">
                                    <div class="m-widget24">
                                        <div class="m-widget24__item">
                                            <h4 class="m-widget24__title">
                                                <?php echo $value['Status_Name']; ?>
                                            </h4><br>
                                            <span class="m-widget24__desc">
													عدد المكالمات
												</span>
                                            <span class="m-widget24__stats m--font-barnd">
													 <?php echo $value['counter']; ?>
												</span>
                                            <div class="m-widget14__chart" style="height:120px;">
                                                <div class="chartjs-size-monitor"
                                                     style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                                    <div class="chartjs-size-monitor-expand"
                                                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                        <div
                                                                style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                        </div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink"
                                                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                        <div
                                                                style="position:absolute;width:200%;height:200%;left:0; top:0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <canvas  width="286" height="120" id="ch<?php echo $count; ?>"
                                                         class="chartjs-render-monitor m_chart_daily"
                                                         style="display: block; width: 286px; height: 120px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php  }
                        } ?>

                    </div>
                </div>
            </div>


















        </div>



        <!--Chart.js Start-->
        <div class="m-portlet">
        <div class="row mt-5 chart-caption">

            <div class="col-lg-6">
                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- border">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 id="callsCount" class="m-portlet__head-text col-lg-12">
                                    حالات المكالمات إجمالى
                                </h3>


                                <div class="btn-group dropDown">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        تغير الرسم البيانى
                                    </button>
                                    <div class="dropdown-menu">
                                        <button class="dropdown-item Change_Chart1 bg"><i class='flaticon-pie-chart'></i> رسم بيانى (1) </button>
                                        <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chartDiv" id="myChart1" width="200" height="150"></div>
                </div>
            </div>


            <?php if ($_SESSION["usertype"]!=3){?>
                <div class="col-lg-6">
                    <div  class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- border">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        <p id="dataCount">حالات غير موزعه</p>
                                    </h3>

                                    <div class="btn-group dropDown">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            تغير الرسم البيانى
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item Change_Chart1 bg"><i class='flaticon-pie-chart'></i> رسم بيانى (1) </button>
                                            <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chartDiv" id="myPieChart" width="200" height="150"></div>
                    </div>
                </div>
            <?php }
            if($_SESSION["usertype"]!=3){?>
                <div class="col-lg-6 mt-5">
                  


                        <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- border ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text col-lg-12">
                                            <p >حاله الموظفين</p>
                                        </h3>

                                        <div class="btn-group dropDown ml-5">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                تغير الرسم البيانى
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item Change_Chart1 bg"><i class='flaticon-pie-chart'></i> رسم بيانى (1) </button>
                                                <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chartDiv" id="myPieChart3" width="200" height="150"></div>
                        </div>
                  
                </div>
            <?php }
            if ($_SESSION["usertype"]==1){?>
                <div class="col-lg-6 mt-5">
                    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- border">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        حالة المشرفين
                                    </h3>

                                    <div class="btn-group dropDown ml-5">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            تغير الرسم البيانى
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item Change_Chart1 bg"><i class='flaticon-pie-chart'></i> رسم بيانى (1) </button>
                                            <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chartDiv" id="myPieChart4" width="200" height="150"></div>
                    </div>
                </div>
            <?php }?>


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

<script>
    $(document).on("click","#searchButton",function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>CRM_Users/index/"+DateRange;
    });



    var Callscolumns =[];
    var Callscolumns2 =[];
    var sum = 0;
    var Calllabels = [];
    <?php
    if (isset($ChartData)){
    for ($i=0;$i<count($ChartData);$i++){
    ?>
    Callscolumns[<?php echo $i ?>] = ["<?php echo $ChartData[$i]->CallStatus ?>",<?php echo $ChartData[$i]->count ?>];
    Callscolumns2[<?php echo $i ?>] = [<?php echo $ChartData[$i]->count ?>];
    Calllabels[<?php echo $i ?>] = ["<?php echo $ChartData[$i]->CallStatus ?>"];
    sum += parseInt("<?php echo $ChartData[$i]->count?>");
    <?php }
    }
    ?>




    var Datacolumns =[];
    var DataCount = 0;
    <?php
    if (isset($DataChart) && count($DataChart) >0){?>

    Datacolumns[0] = ["المتركمة",<?php echo $DataChart[0]->oldDataCount ?>];
    Datacolumns[1] = ["الجديدة",<?php echo $DataChart[0]->newDataCount ?>];
    DataCount = parseInt("<?php echo ($DataChart[0]->newDataCount + $DataChart[0]->oldDataCount) ?>");
    <?php }
    ?>

    $("#dataCount").text("حالات غير موزعه إجمالى (" + DataCount +" )");
    $("#callsCount").text("حالات المكالمات إجمالى (" + sum +" )");






    var status =$.parseJSON('<?= $stat ?>');
    var arr=status.split(",");
    var emp=[] ;
    var superVisor = [];
    superVisor[0]=['فعال', arr[0]];
    superVisor[1]=['غير فعال', arr[1]];
    superVisor[2]=['في مكالمة', arr[2]];
    emp[0] =  ['فعال', arr[3]];
    emp[1] =  ['غير فعال', arr[4]];
    emp[2] =  ['في مكالمة', arr[5]];
    chartGeneral('pie', 'myPieChart',Datacolumns);
    chartGeneral('pie', 'myChart1',Callscolumns);
    chartGeneral('pie', 'myPieChart3',emp);
    chartGeneral('pie', 'myPieChart4',superVisor);

    // chartGeneral('pie', 'myPieChart3',Callscolumns);
    //



    //------------------------------------------------------------------

    var charts = $( ".m_chart_daily" ).toArray();
    // alert( $(charts[0]).attr('id') );
    for (var i=0;i < charts.length;i++){
        chartCard($(charts[i]).attr('id'));

    }







</script>













