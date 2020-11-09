<?php $this->load->view("header") ?>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style=" margin-top:3%; margin-right:5%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="container">
        <div class="m-content">
            <div class="m-portlet">
                <div class="m-portlet__body tabs_border">
                    <div class="row">
                        <!--الموظف الاول -->
                        <div class="col-lg-6 p-5 border">
                            <h3 class="text-center mb-5">(الموظف الاول) </h3>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1">الموظف</label>
                                <div class="col-lg-10 ml-2">
                                    <select class="form-control select2-static" id="UserID1">
                                        <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                                            <option value="<?php echo $users[$i]->ID?>">
                                                <?php echo $users[$i]->Name?>
                                            </option>
                                        <?php } }?>

                                    </select>
                                </div>
                            </div>




                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1 col-sm-12">
                                    من</label>
                                <div class="col-lg-11 col-md-12 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input DatebakerInput" value="<?= $date1 ?>" id="FromDate1">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="flaticon-calendar glyphicon-th"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form_group row">
                                <label class="col-form-label col-lg-1 col-sm-12">
                                    الى</label>
                                <div class="col-lg-11 col-md-12 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input DatebakerInput" value="<?= $date2 ?>" type="date" id="ToDate1">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="flaticon-calendar glyphicon-th"></i>
                                    </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-row">
                                <label class="col-lg-1"></label>
                                <div class="col-lg-11">
                                    <button class="btn btn-info mt-3 btn-block" id="searchButton1">بحث</button>
                                </div>
                            </div>


                            <div class="More_charts" id="Emp1" style="display:none;">
                                <div class="col-lg-12">
                                    <table
                                            class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline my-5" >
                                        <tbody>
                                        <tr>
                                            <td><b><i class="flaticon-user"></i> اسم الموظف : </b><span id="Emp1ID">  </span></td>
                                            <td><b><i class="flaticon-support"></i> اجمالى عدد المكالمات : </b><span id="Emp1TotalCalls"> </span></td>



                                        </tr>
                                        <tr>
                                            <td><b> <i class="flaticon-support"></i> عدد المكالمات الجديده : </b><span id="Emp1TotalNewCalls"> </span></td>
                                            <td><b><i class="flaticon-support"></i> عدد المكالمات المنتهيه : </b><span id="Emp1EndCalls">  </span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">


                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        تم الرد
                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height:300px;cursor:pointer;">
                                            <div id="AnswerCalls1"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border  pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        لم يتم الرد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="NoAnswerCalls1"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        ارقام خطا

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="WrongCalls1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        قيد الحجز

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="ReservationCalls1"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        تم التعاقد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="contractCalls1"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        إلغاء التعاقد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="DecontractCalls1"></div>
                                        </div>
                                    </div>
                                </div>






                            </div>
                        </div>
                        <!--الموظف الثانى -->
                        <div class="col-lg-6 p-5 border">
                            <h3 class="text-center mb-5">(الموظف الثانى) </h3>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1">الموظف</label>
                                <div class="col-lg-10 ml-2">
                                    <select class="form-control select2-static" id="UserID2">
                                        <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                                            <option value="<?php echo $users[$i]->ID?>">
                                                <?php echo $users[$i]->Name?>
                                            </option>
                                        <?php } }?>
                                    </select>
                                </div>
                            </div>




                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1 col-sm-12">
                                    من</label>
                                <div class="col-lg-11 col-md-12 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input DatebakerInput" value="<?= $date1 ?>" type="date" id="FromDate2">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="flaticon-calendar glyphicon-th"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form_group row">
                                <label class="col-form-label col-lg-1 col-sm-12">
                                    الى</label>
                                <div class="col-lg-11 col-md-12 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input DatebakerInput" value="<?= $date2 ?>" type="date" id="ToDate2">
                                        <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="flaticon-calendar glyphicon-th"></i>
                                    </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-row">
                                <label class="col-lg-1"></label>
                                <div class="col-lg-11">
                                    <button class="btn btn-info mt-3 btn-block" id="searchButton2">بحث</button>
                                </div>
                            </div>


                            <div class="More_charts" id="Emp2" style="display:none;">
                                <div class="col-lg-12">
                                    <table
                                            class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline my-5"  >
                                        <tbody>
                                        <tr>
                                            <td><b><i class="flaticon-user"></i> اسم الموظف : </b><span id="Emp2ID"> </span></td>
                                            <td><b><i class="flaticon-support"></i> اجمالى عدد المكالمات : </b><span id="Emp2TotalCalls"> </span></td>



                                        </tr>
                                        <tr>
                                            <td><b><i class="flaticon-support"></i> عدد المكالمات الجديده : </b><span id="Emp2TotalNewCalls"> </span></td>
                                            <td><b><i class="flaticon-support"></i> عدد المكالمات المنتهيه : </b><span id="Emp2EndCalls">  </span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">


                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        تم الرد
                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="AnswerCalls2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        لم يتم الرد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="NoAnswerCalls2"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        ارقام خطا

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="WrongCalls2"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        قيد الحجز

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="ReservationCalls2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        تم التعاقد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="contractCalls2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- border pb-5">

                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                                    <h3 class="m-portlet__head-text col-lg-12">
                                                        الغاء التعاقد

                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="attend-chart"  style="height: 300px;cursor:pointer;">
                                            <div id="DecontractCalls2"></div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>





        </div>

    </div>
</div>

</div>






































<script src="assets/js/d3.min.js"></script>
<script src="assets/js/c3.js"></script>
<script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>

<script>
    $(document).on("click", "#searchButton1", function () {
        var DateRange = $("#FromDate1").val() + "@" + $("#ToDate1").val();
        var employee = document.getElementById("UserID1").options[document.getElementById(
            "UserID1").selectedIndex].value;
        var AnswerCallsColumns =[];
        var NoAnswerCallsColumns =[];
        var ReservationCallsColumns =[];
        var WrongCallsColumns =[];
        var contractCallsColumns =[];
        var DecontractCallsColumns =[];
        var i=0;
        $.ajax({
            type: "POST",
            url: base+"reports/GetStaffData",
            data: ({
                Date:DateRange,
                empID:employee
            }),
            success: function(data) {
                var result = $.parseJSON(data);
                $("#Emp1").show();
                $("#Emp1ID").text(result.EmpName);
                $("#Emp1TotalCalls").text(result.TotalCalls);
                $("#Emp1TotalNewCalls").text(result.TotalNewCalls);
                var EndCalls = parseInt(result.TotalCalls) - parseInt(result.TotalNewCalls);
                $("#Emp1EndCalls").text(EndCalls);

                result.AnswerCalls.forEach(function (e) {
                    AnswerCallsColumns[i]=[e.title,e.count];
                    i++;
                });

                i=0;
                result.NoAnswerCalls.forEach(function (e) {
                    NoAnswerCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.ReservationCalls.forEach(function (e) {
                    ReservationCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.WrongCalls.forEach(function (e) {
                    WrongCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.contractCalls.forEach(function (e) {
                    contractCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.DecontractCalls.forEach(function (e) {
                    DecontractCallsColumns[i]=[e.title,e.count];
                    i++;
                });

                c3.generate({
                    bindto: '#AnswerCalls1',
                    data: {
                        columns: AnswerCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#NoAnswerCalls1',
                    data: {
                        columns: NoAnswerCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#ReservationCalls1',
                    data: {
                        columns: ReservationCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#WrongCalls1',
                    data: {
                        columns: WrongCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#contractCalls1',
                    data: {
                        columns: contractCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#DecontractCalls1',
                    data: {
                        columns: DecontractCallsColumns,
                        type : 'pie'
                    }
                });



                // alert(result.AnswerCalls[0].title);



            }
        });
    });
    $(document).on("click", "#searchButton2", function () {
        var DateRange = $("#FromDate2").val() + "@" + $("#ToDate2").val();
        var employee = document.getElementById("UserID2").options[document.getElementById(
            "UserID2").selectedIndex].value;

        var AnswerCallsColumns =[];
        var NoAnswerCallsColumns =[];
        var ReservationCallsColumns =[];
        var WrongCallsColumns =[];
        var contractCallsColumns =[];
        var DecontractCallsColumns =[];
        var i=0;
        $.ajax({
            type: "POST",
            url: base+"reports/GetStaffData",
            data: ({
                Date:DateRange,
                empID:employee
            }),
            success: function(data) {

                var result = $.parseJSON(data);
                $("#Emp2").show();
                $("#Emp2ID").text(result.EmpName);
                $("#Emp2TotalCalls").text(result.TotalCalls);
                $("#Emp2TotalNewCalls").text(result.TotalNewCalls);
                var EndCalls = parseInt(result.TotalCalls) - parseInt(result.TotalNewCalls);
                $("#Emp2EndCalls").text(EndCalls);

                result.AnswerCalls.forEach(function (e) {
                    AnswerCallsColumns[i]=[e.title,e.count];
                    i++;
                });

                i=0;
                result.NoAnswerCalls.forEach(function (e) {
                    NoAnswerCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.ReservationCalls.forEach(function (e) {
                    ReservationCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.WrongCalls.forEach(function (e) {
                    WrongCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.contractCalls.forEach(function (e) {
                    contractCallsColumns[i]=[e.title,e.count];
                    i++;
                });
                i=0;
                result.DecontractCalls.forEach(function (e) {
                    DecontractCallsColumns[i]=[e.title,e.count];
                    i++;
                });

                c3.generate({
                    bindto: '#AnswerCalls2',
                    data: {
                        columns: AnswerCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#NoAnswerCalls2',
                    data: {
                        columns: NoAnswerCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#ReservationCalls2',
                    data: {
                        columns: ReservationCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#WrongCalls2',
                    data: {
                        columns: WrongCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#contractCalls2',
                    data: {
                        columns: contractCallsColumns,
                        type : 'pie'
                    }
                });

                c3.generate({
                    bindto: '#DecontractCalls2',
                    data: {
                        columns: DecontractCallsColumns,
                        type : 'pie'
                    }
                });
            }
        });

        //alert(employee);
    });
</script>
</body>

</html>
