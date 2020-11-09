<?php $this->load->view("header") ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top:2%; margin-right:10%; margin-left:3%;">

				<div class="m-content">
               
                    	<!--Date And Time-->
				<div class="container">
                <?php $this->load->view("Admin/DateTimeDiv"); ?>
                        </div>
  <!--Date And Time-->


 <!--Chart.js Start-->
 <div class="row mt-5 chart-caption">

<div class="col-lg-6">
    <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text col-lg-12">
                      السن
                    </h3>


                   
                </div>
            </div>
        </div>
        <div class="attend-chart" style="height:330px; cursor:pointer;">
                <div id="Age"></div>
</div>
    </div>
</div>
<div class="col-lg-6">
    <div  class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text col-lg-12">
                        <p id="dataCount"> المحافظه </p>
                    </h3>

                </div>
            </div>
        </div>
        <div class="attend-chart"  style="height:330px; cursor:pointer;">
                <div id="GovernmentGovernment"></div>
            </div>
    </div>
</div>

<div class="col-lg-6 mt-5">
    <div class="m-portlet m-portlet--mobile m-portlet--body-progress">
        <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text col-lg-12">
                            <p id="callsCount">الوظيفه </p>
                        </h3>
                    </div>
                </div>
</div>
                <div class="attend-chart" style="height:330px; cursor:pointer;">
                <div id="JobClass" style="margin-top:40%;"></div>
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

<script>
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


    c3.generate({
        bindto: '#Government',
        data: {
            columns: GovernmentColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#Age',
        data: {
            columns: AgeColumns,
            type : 'pie'
        }
    });

    c3.generate({
        bindto: '#JobClass',
        data: {
            columns: JobColumns,
            type : 'pie'
        }
    });




</script>

<script>
    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/TargetedClients/" + DateRange;
    });
</script>

</body>

</html>