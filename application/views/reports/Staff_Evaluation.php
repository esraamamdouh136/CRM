<?php $this->load->view("header") ?>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style=" margin-top:3%;margin-right: 9%;margin-left: 3%;"">

<!-- BEGIN: Subheader -->

<!-- END: Subheader -->

<div class="m-content">
    <div class="m-portlet">
        <div class="m-portlet__head" id="print_none">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        تقييم أداء الموظفين
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
<!--                                                        <button-->
<!--                                                         class="btn btn-info"  id="printButton" onclick="window.print()"><span>طباعة</span>-->
<!---->
<!--                                                        </button>-->





                    </li>
                </ul>
            </div>
        </div>

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
                                <!--DatebakerInput-->
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
                                <input type="text" class="form-control m-input DatebakerInput" value="<?= $date2 ?>" id="ToDate1">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="flaticon-calendar glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-6">
                            <button class="btn btn-info mt-3 btn-block" id="searchButton1">بحث</button>
                        </div>
                        <div class="col-lg-6">
                            <button
                                    class="btn btn-info btn-block mt-3"  id="printButton" onclick="PrintElem('#Emp1')"><span>طباعة</span>

                            </button>
                        </div>
                    </div>


                    <div class="More_charts" id="Emp1" style="display:none;">
                        <div class="col-lg-12">
                            <table
                                    class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline my-5" id="TABLE">
                                <tbody>
                                <tr i>
                                    <td id="EmpName"><b><i class="flaticon-user"></i> اسم الموظف : </b><span id="Emp1ID">  </span></td>
                                    <td id="EmpNumber"><b><i class="flaticon-support"></i> اجمالى عدد المكالمات : </b><span id="Emp1TotalCalls"> </span></td>



                                </tr>
                                <tr id="tableTR1">
                                    <td id="EmpNewCall"><b> <i class="flaticon-support"></i> عدد المكالمات الجديده : </b><span id="Emp1TotalNewCalls"> </span></td>
                                    <td id="EmpEndCall"><b><i class="flaticon-support"></i> عدد المكالمات المنتهيه : </b><span id="Emp1EndCalls">  </span></td>
                                </tr>
                                <tr class="TRCLass">
                                    <td>نسبة المبيعات المتوقعه </td>
                                    <td><input type="number" id="targetamount1" value="0" min="0"></td>
                                </tr>
                                <tr class="TRCLass">
                                    <td><button id="calculat1" empvalue="">حساب النسبة المستهدفة</button></td>
                                    <td><label id="target1">0%</label></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5" >


                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                تم الرد<label id="AnswerCallsCount1"></label>
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
                                        </li>
                                    </ul>
                                </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="AnswerCalls1"></div>
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text col-lg-12">
                                                    لم يتم الرد<label id="NoAnswerCallsCount1"></label>

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
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                        <div class="chartDiv" id="NoAnswerCalls1"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-5">
                                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text col-lg-12">
                                                    ارقام خطا<label id="WrongCallsCount1"></label>

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
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                        <div class="chartDiv" id="WrongCalls1"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 mt-5">
                                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text col-lg-12">
                                                    قيد الحجز<label id="ReservationCallsCount1"></label>

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
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                        <div class="chartDiv" id="ReservationCalls1"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text col-lg-12">
                                                    تم التعاقد<label id="contractCallsCount1"></label>

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
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                        <div class="chartDiv" id="contractCalls1"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-5">
                                <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-caption">
                                            <div class="m-portlet__head-title">
                                                <h3 class="m-portlet__head-text col-lg-12">
                                                    الغاء التعاقد<label id="DecontractCallsCount1"></label>

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
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                        <div class="chartDiv" id="DecontractCalls1"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        </div>
                </div>
                <!--الموظف الثانى -->
                <div class="col-lg-6 p-5 border">
                    <h3  class="text-center mb-5">(الموظف الثانى) </h3>
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
                                <input type="text" class="form-control m-input DatebakerInput" value="<?= $date1 ?>"  id="FromDate2">
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

                        <div class="col-lg-6">
                            <button class="btn btn-info mt-3 btn-block" id="searchButton2">بحث</button>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-info mt-3 btn-block" id="PrintSection" onclick="PrintElem2('#Emp2')"">طباعة</button>
                        </div>
                    </div>


                    <div class="More_charts" id="Emp2" style="display:none;">
                        <div class="col-lg-12">
                            <table
                                    class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline my-5"  >
                                <tbody>
                                <tr>
                                    <td id="EmpName2"><b><i class="flaticon-user"></i> اسم الموظف : </b><span id="Emp2ID"> </span></td>
                                    <td id="EmpNumber2"><b><i class="flaticon-support"></i> اجمالى عدد المكالمات : </b><span id="Emp2TotalCalls"> </span></td>



                                </tr>
                                <tr>
                                    <td id="EmpNewCall2"><b><i class="flaticon-support"></i> عدد المكالمات الجديده : </b><span id="Emp2TotalNewCalls"> </span></td>
                                    <td id="EmpEndCall2"><b><i class="flaticon-support"></i> عدد المكالمات المنتهيه : </b><span id="Emp2EndCalls">  </span></td>
                                </tr>
                                <tr class="TRCLass">
                                    <td>نسبة المبيعات المتوقعه </td>
                                    <td><input type="number" id="targetamount2" value="0" min="0"></td>
                                </tr>
                                <tr class="TRCLass">
                                    <td><button id="calculat2" empvalue="">حساب النسبة المستهدفة</button></td>
                                    <td><label id="target2">0%</label></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5" >


                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                تم الرد<label id="AnswerCallsCount2"></label>
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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="AnswerCalls2"></div>
                                </div>
                            </div>
                            </div>

                        <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                لم يتم الرد<label id="NoAnswerCallsCount2"></label>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="NoAnswerCalls2"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                ارقام خطا<label id="WrongCallsCount2"></label>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="WrongCalls2"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                قيد الحجز<label id="ReservationCallsCount2"></label>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="ReservationCalls2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                تم التعاقد<label id="contractCallsCount2"></label>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="contractCalls2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-5">
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- content-print border pb-5">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                الغاء التعاقد<label id="DecontractCallsCount2"></label>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="attend-chart attend-chart"  style="height: 300px;cursor:pointer;">
                                    <div class="chartDiv" id="DecontractCalls2"></div>
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

                $("#AnswerCallsCount1").text(' ( '+result.AnswerCallsCount+' )');
                $("#NoAnswerCallsCount1").text(' ( '+result.NoAnswerCallsCount+' )');
                $("#WrongCallsCount1").text(' ( '+result.WrongCallsCount+' )');
                $("#ReservationCallsCount1").text(' ( '+result.ReservationCallsCount+' )');
                $("#contractCallsCount1").text(' ( '+result.contractCallsCount+' )');
                $("#DecontractCallsCount1").text(' ( '+result.DecontractCallsCount+' )');
                $("#calculat1").attr("empvalue",result.totalAmount);
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



                chartGeneral('pie', 'AnswerCalls1',AnswerCallsColumns);
                chartGeneral('pie', 'NoAnswerCalls1',NoAnswerCallsColumns);
                chartGeneral('pie', 'WrongCalls1',WrongCallsColumns);
                chartGeneral('pie', 'ReservationCalls1',ReservationCallsColumns);
                chartGeneral('pie', 'contractCalls1',contractCallsColumns);
                chartGeneral('pie', 'DecontractCalls1',DecontractCallsColumns);


            }
        });
    });
    $(document).on("click", "#searchButton2", function () {

        var DateRange = $("#FromDate2").val() + "@" + $("#ToDate2").val();
        var employee = document.getElementById("UserID2").options[document.getElementById("UserID2").selectedIndex].value;

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
                $("#AnswerCallsCount2").text(' ( '+result.AnswerCallsCount+' )');
                $("#NoAnswerCallsCount2").text(' ( '+result.NoAnswerCallsCount+' )');
                $("#WrongCallsCount2").text(' ( '+result.WrongCallsCount+' )');
                $("#ReservationCallsCount2").text(' ( '+result.ReservationCallsCount+' )');
                $("#contractCallsCount2").text(' ( '+result.contractCallsCount+' )');
                $("#DecontractCallsCount2").text(' ( '+result.DecontractCallsCount+' )');
                $("#calculat2").attr("empvalue",result.totalAmount);
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

                chartGeneral('pie', 'AnswerCalls2',AnswerCallsColumns);
                chartGeneral('pie', 'NoAnswerCalls2',NoAnswerCallsColumns);
                chartGeneral('pie', 'WrongCalls2',WrongCallsColumns);
                chartGeneral('pie', 'ReservationCalls2',ReservationCallsColumns);
                chartGeneral('pie', 'contractCalls2',contractCallsColumns);
                chartGeneral('pie', 'DecontractCalls2',DecontractCallsColumns);

            }
        });

        //alert(employee);
    });


    $("#calculat1").click(function () {
        var amount = $("#targetamount1").val();
        var EmpAmount = $(this).attr("empvalue");

        if (amount > 0){
            var target = (EmpAmount/amount)*100;
            $("#target1").text(target+'%'+'  من  '+ EmpAmount);
            // alert(EmpAmount/amount);
        }

    });
    $("#calculat2").click(function () {
        var amount = $("#targetamount2").val();
        var EmpAmount = $(this).attr("empvalue");

        if (amount > 0){
            var target = (EmpAmount/amount)*100;
            $("#target2").text(target+'%'+'  من  '+ EmpAmount);
            // alert(EmpAmount/amount);
        }

    });











</script>



</body>

</html>
