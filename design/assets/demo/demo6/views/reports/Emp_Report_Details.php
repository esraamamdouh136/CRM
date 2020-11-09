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
                <td><b> اسم الموظف : </b><span><?= get_Emp_name($UserID)?></span></td>
                <td><b> اجمالى عدد المكالمات  : </b><span><?= $TotalCalls?></span></td>
                    <td><b>  عدد المكالمات الجديده : </b><span><?= $TotalNewCalls?></span></td>
                    <td><b>  عدد المكالمات المنتهيه :  </b><span><?= ($TotalCalls -$TotalNewCalls) ?></span></td>

             
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

            <div class="col-lg-6">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text col-lg-12">
                                    تم الرد
                                </h3>
                                
                             
                            </div>
                        </div>
                    </div>
                    <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="AnswerCalls"></div>
</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text col-lg-12">
                                    لم يتم الرد
                                </h3>
                               
                            </div>
                        </div>
                    </div>
                    <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="NoAnswerCalls"></div>
            </div>
                </div>
            </div>

            <div class="col-lg-6 mt-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">


                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text col-lg-12">
                                        إرقام خطأ

                                    </h3>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="WrongCalls"></div>
            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text col-lg-12">
                                    قيد الحجز

                                </h3>
                               
                            </div>
                        </div>
                    </div>
                    <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="ReservationCalls"></div>
            </div>
                </div>
            </div>


            <div class="col-lg-6 mt-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text col-lg-12">
                                    تم التعاقد

                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="contractCalls"></div>
            </div>
                </div>
            </div>


            <div class="col-lg-6 mt-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text col-lg-12">
                                    إلغاء التعاقد
                                </h3>
                              
                            </div>
                        </div>
                    </div>
                    <div class="attend-chart"  style="height:auto;cursor:pointer;">
                <div id="DecontractCalls"></div>
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

    c3.generate({
        bindto: '#AnswerCalls',
        data: {
            columns: AnswerCallsColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#NoAnswerCalls',
        data: {
            columns: NoAnswerCallsColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#ReservationCalls',
        data: {
            columns: ReservationCallsColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#WrongCalls',
        data: {
            columns: WrongCallsColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#contractCalls',
        data: {
            columns: contractCallsColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#DecontractCalls',
        data: {
            columns: DecontractCallsColumns,
            type : 'pie'
        }
    });


</script>

<script>
    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/employeeDetails/<?=$UserID?>/" + DateRange;
    });
</script>

</body>

</html>