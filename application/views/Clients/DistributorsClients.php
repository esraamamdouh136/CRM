<?php $this->load->view("header");?>



<!-- END: Left Aside -->
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:8%">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">
            <!--Date And Time-->
        <div class="container">
            <?php $this->load->view("Admin/DateTimeDiv"); ?>
        </div>
            <!--Date And Time-->
            <div class="my-3" id="parent-div" style="margin-left:3%;
    margin-right:3%;">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-sm hight_card2" style="">
                        <div class="col-md-12 col-lg-6 col-xl-3 hight_card1 bg-white" style="border-bottom: 56px solid #ebedf2 !important; height: 225px;">
                            <div class="icons icon-1">
                                <i class="fa fa-chart-area"></i>
                            </div>
                            <!--begin::Total Profit-->
                            <div class="m-widget24" style="cursor: pointer">
                                <div class="m-widget24__item">
                                    <h4 class="m-widget24__title">
                                        تم استراد عملاء جدد اليوم
                                    </h4><br>
                                    <span class="m-widget24__desc">
                                        عدد المكالمات
                                    </span>

                                    <?php
                                    $callCount = isset($Distributors)?$Distributors:0;
                                    if ($callCount > 0){
                                        $progress = ($callCount/$callCount)*100;
                                    }else{
                                        $progress = 0;
                                    }

                                    ?>
                                    <span class="m-widget24__stats m--font-sccess">
                                        <?= $callCount ?>
                                    </span>

                                    <div class="m--space-10"><?=$progress?>%</div>
                                    <div class="progress m-progress--sm mt-4">
                                        <div class="progress-bar m--bg-info" role="progressbar" style="width: <?=$progress?>%;"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <!--end::Total Profit-->
                        </div>


                        <?php
                        if (isset($status) && count($status) > 0){
                            $count = 0;
                            foreach($status as $value){
                                $count ++ ;
                                ?>
                                <div class="col-md-12 col-lg-6 col-xl-3 hight_card2 bg-white">
                                    <!--begin::Total Profit-->
                                    <div class="m-widget24 Click_filter" style="cursor: pointer">
                                        <div class="m-widget24__item">
                                            <h4 class="m-widget24__title">
                                                <?= $value['Status_Name']?>
                                            </h4><br>
                                            <span class="m-widget24__desc">
                                        عدد المكالمات
                                    </span>
                                            <span class="m-widget24__stats m--font-barnd">
                                        <?= $value['counter']?>
                                    </span>
                                            <div class="m-widget14__chart" style="height:120px;">

                                                <div id="ch<?php echo $count; ?>" width="286" height="120"
                                                     class="chartjs-render-monitor m_chart_daily" callcount="  <?= $value['counter']?>"
                                                     style="display: block; width: 286px; height: 120px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Total Profit-->
                                </div>
                            <?php      }
                        }
                        ?>
                    </div>
                </div>
            </div>


            <!--table Start-->
            <div style="margin-left:3%; margin-right: 2%;">
                <div class="">
                    <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                        <!--begin::Item-->
                        <div class="m-accordion__item">
                            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head"
                                 data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="true">
                                <span class="m-accordion__item-icon"><i class="fa fa-filter"></i></span>
                                <span class="m-accordion__item-title">Filter</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapsed collapse show" id="m_accordion_1_item_1_body"
                                 role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1"
                                 style="">
                                <div class="m-accordion__item-content">

                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="input-group mb-3v mb-3">
                                                <select class="custom-select" id="filter">
                                                    <option selected>الكل</option>
                                                    <?php if (isset($statusCrm)){ for ($i= 0 ;$i < count($statusCrm);$i++){ ?>
                                                        <option value="<?= trim($statusCrm[$i]->title) ?>">
                                                            <?= $statusCrm[$i]->title ?> </option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2 space mb-3">
                                            <a href="<?php echo base_url() ?>Client/create"
                                               class="btn btn-info btn-block"> إضافة عميل<i
                                                        class="flaticon flaticon-users ml-2"></i></a>


                                        </div>
                                    </div>

                                    <?php
                                    if ($_SESSION['usertype'] !=3){?>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label class="m-checkbox mt-2">
                                                            <input type="checkbox" id="asNewClient">كحالة
                                                            جديدة
                                                            <span></span>
                                                        </label>
                                                    </div>



                                                    <div class="col-md-6 mb-3">
                                                        <div class="form-group m-form__group row">

                                                            <div class="col-lg-12">
                                                                <select class="form-control select2-static" id="sel2"
                                                                        name="empName">
                                                                    <option selected>المستخدمين</option>
                                                                    <?php if(isset($employee)){ for($i=0;$i<count($employee);$i++){?>
                                                                        <option value="<?php echo $employee[$i]->ID ?> ">
                                                                            <?php
                                                                            if ($employee[$i]->Type ==2){
                                                                                echo $employee[$i]->Name." (مشرف) ";
                                                                            }else{
                                                                                echo $employee[$i]->Name." (موظف) ";
                                                                            }
                                                                            ?>
                                                                        </option>
                                                                    <?php } }?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <div class="col-md-3 space mb-3">
                                                        <button type="button" class="btn btn-success btn-block"
                                                                id="button11">تعيين <i
                                                                    class="flaticon flaticon-file-2"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group m-form__group row">


                                                            <input type="number" placeholder="عدد العملاء" min="1"
                                                                   max="<?php echo count($Clients)?>" value="10"
                                                                   class="form-control" id="Data-Length">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <button type="button"
                                                                class="btn btn-primary btn-block page-size" id="view">
                                                            عرض <i class="flaticon flaticon-web ml-2"></i></button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-danger btn-block"
                                                                id="deleteData">حذف
                                                            <i class="flaticon flaticon-delete ml-2"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }


                                    ?>



                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                </div>

                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text d-none d-md-block">
                                    حالات العملاء
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6"></div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <button type="button" class="btn btn-success ml-auto btn-block" data-toggle="modal"
                                            data-target="#smsModal" id="opener2">ارسال رساله نصيه<i class="flaticon flaticon-multimedia mx-3"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <button type="button" class="btn btn-info ml-auto btn-block" data-toggle="modal"
                                            data-target="#EmailModal">ارسال  بريد الكترونى<i class="flaticon flaticon-multimedia mx-3"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-portlet__body-progress">Loading</div>
                        <!--begin: Datatable m-table -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($Clients)?>">
                                    <table id="example"
                                           class="table m-table--head-bg-info table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                           style="width:100%" aria-describedby="m_table_1_info" role="grid">
                                        <thead>

                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1"
                                                rowspan="1" colspan="1" style="width: 30px;" aria-sort="ascending"
                                                aria-label=" name=" first" : activate to sort column descending">
                                            <input type="checkbox" id="selectall" class="clncheckAll">
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">الاسم<i
                                                        class="flaticon-user ml-2"></i></th>

                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 108px;"
                                                aria-label="رقم التليفون: activate to sort column ascending">رقم التليفون<i
                                                        class="flaticon flaticon-support ml-2"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 150px;"
                                                aria-label="الوظيفة: activate to sort column ascending">الوظيفة<i
                                                        class="flaticon flaticon-network  ml-2"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 157px;"
                                                aria-label="حالة المكالة: activate to sort column ascending">
                                                حالة
                                                المكالة<i class="flaticon flaticon-support  ml-2"></i></th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" style="width: 118px;"
                                                aria-label="الموظف: activate to sort column ascending">الموظف<i
                                                        class="flaticon flaticon-user  ml-2"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 120px;"
                                                aria-label="المشرف: activate to sort column ascending">المشرف<i
                                                        class="flaticon flaticon-user ml-2">
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 120px;"
                                                aria-label="التاريخ: activate to sort column ascending">التاريخ<i
                                                        class="flaticon flaticon-clock-2  ml-2"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 120px;"
                                                aria-label="التاريخ: activate to sort column ascending">تاريخ المتابعة<i
                                                        class="flaticon flaticon-clock-2  ml-2"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1"
                                                colspan="1" style="width: 120px;"
                                                aria-label="التاريخ: activate to sort column ascending">وقت المتابعة<i
                                                        class="flaticon flaticon-clock-2  ml-2"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(isset($Clients)){ for($i=0;$i<count($Clients);$i++){
                                            $row =get_row('call_status',['id'=>$Clients[$i]->Status],null)->title;
                                            ?>
                                            <tr class="clickable-row task-list-row" style="cursor: pointer;"
                                                data-priority="<?php echo $row ?>"
                                                data-href="<?php echo $Clients[$i]->customerCrmId?>">
                                                <td class="checkable-td">
                                                    <input  castID ="<?= $Clients[$i]->customerCrmId ?>" type="checkbox" class="checkboxMy  <?php echo 'chk elem'.$i?>">
                                                    <input type="hidden" class="dataID
                            <?php echo 'custid'.$i?>" value="<?php echo $Clients[$i]->customerCrmId?>">
                                                </td>
                                                <td data-toggle="tooltip" data-placement="top" title="<?php echo $Clients[$i]->customerCrmName ?>">
                                                    <?php echo $Clients[$i]->customerCrmName ?>
                                                </td>

                                                <td data-toggle="tooltip" data-placement="top" title="<?php echo $Clients[$i]->customerCrmPhone?>">
                                                    <?php echo $Clients[$i]->customerCrmPhone?>
                                                </td>
                                                <td data-toggle="tooltip" data-placement="top" title=" <?php echo $Clients[$i]->customerCrmJob?>">
                                                    <?php echo $Clients[$i]->customerCrmJob?>
                                                </td>
                                                <td data-toggle="tooltip" data-placement="top" title=" <?php echo $Clients[$i]->customerCrmJob?>">
                                                    <?php
                                                    echo $row?>
                                                </td>
                                                <td>
                                                    <?php echo get_Emp_name($Clients[$i]->userID)?>
                                                </td>

                                                <td>
                                                    <?php echo get_Emp_name($Clients[$i]->supervisor_ID)?>

                                                </td>
                                                <td>
                                                    <?php echo $Clients[$i]->Date?>

                                                </td>
                                                <td>

                                                    <?php echo (isset($Clients[$i]->Follow_Date) && !is_null($Clients[$i]->Follow_Date))?$Clients[$i]->Follow_Date:""?>

                                                </td>
                                                <td>
                                                    <?php echo (isset($Clients[$i]->Follow_Date) && !is_null($Clients[$i]->Follow_Date))?$Clients[$i]->Follow_Time:""?>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        }?>


                                        </tbody>

                                    </table>



                                </div>
                            </div>
                        </div>


                        <!--end: Datatable -->
                    </div>
                </div>


            </div>
            <!--table End-->
        </div>

</div>




<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ارسال رساله نصية </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group m-form__group row">
                    <label for="example-time-input" class="col-lg-12 col-form-label"> نص الرساله </label>
                    <div class="col-lg-12">
                        <textarea cols="60" rows="5" id="smsContent"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="sendSMS" class="btn btn-info"> ارسال </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EmailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ارسال بريد إلكترونى </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url().'CRM_Mails/sendbulkMailWithAttachForClients'?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="MailListInputs" hidden class="row parentAppend p-2"></div>
                    <div class="form-group m-form__group row">
                        <label for="example-time-input" class="col-lg-12 col-form-label"> عنوان الرسالة </label>
                        <div class="col-lg-12">
                            <input class="form-control m-input" type="text" value="" name="title">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-time-input" class="col-lg-12 col-form-label "> نص الرساله </label>
                        <div class="col-lg-12">
                            <textarea class="ckeditor" name="Mailcontent" cols="60" rows="5" id="mailBody"></textarea>
                        </div>
                    </div>
                    <div class="mt-2">
                        إرفاق الملف : <input type="file" id="file[]" accept="application/pdf,image/*" name="file[]" multiple>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit"  class="btn btn-info"> ارسال </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                </div>
            </form>

        </div>
    </div>
</div>



<script src="assets/js/d3.min.js"></script>
<script src="assets/js/c3.js"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>
<script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>


<script type="text/javascript">
    let clientData;
    $(document).ready(function () {
        clientData = $('#example').DataTable({
            "language": {
                "sProcessing": "جارٍ التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sSearch": "ابحث:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            columnDefs: [ {
                orderable: false,
                targets:   0
            } ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    if (column.index() == 4) {
                        var select = $("#filter")
                            .on('change', function () {
                                var val;
                                if (this.selectedIndex == 0) {
                                    val = '';
                                } else {
                                    val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                }
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
                    }


                });
            },
        });
        $('.sorting_asc').removeClass('sorting_asc');
    });

    //check box -- select All //
    // $("#selectall").on( "click", function(e) {
    //     if ($(this).is( ":checked" )) {
    //         DT1.rows(  ).select();
    //     } else {
    //         DT1.rows(  ).deselect();
    //     }
    // });
    $("#selectall").change(function () {
        var element = this;
        let MailList = $("#MailListInputs");
        $(MailList).empty();
        $(':checkbox.checkboxMy').each(function() {
            this.checked = element.checked;
            if (element.checked){
                $(MailList).append("<input type='hidden' name='mailAddress[]' value='"+$(this).attr("castID")+"' >");
            }

        });
    });

    $(".checkboxMy").change(function () {

        let MailList = $("#MailListInputs");
        $(MailList).empty();
        $(':checkbox.checkboxMy').each(function() {
            if (this.checked){
                $(MailList).append("<input type='hidden' name='mailAddress[]' value='"+$(this).attr("castID")+"' >");
            }

        });
    });



    $(".page-size").click(function () {
        var size = document.getElementById('Data-Length').value;
        if (size <= 0) {
            alert("تاكد من الرقم الذى ادخلته")
        } else {
            $('#example').DataTable().page.len(size).draw();
        }
    });
    $(".m-widget24").click(function () {
        let status = $(this).find(".m-widget24__title").text();
        if ($.trim(status) == 'تم استراد عملاء جدد اليوم'){
            status = '';
            $("#filter").val('الكل');
        }else{
            $("#filter").val($.trim(status));
        }

        if (clientData != null){
            clientData
                .column(4)
                .search( $.trim(status) )

                .draw();
        }
        <!-- 800 time-->
        $("html, body").animate({ scrollTop: $(document).height() }, 800);
    });


</script>








<script type="text/javascript">
    var charts = $(".m_chart_daily").toArray();
    // alert( $(charts[0]).attr('id') );
    let sum = <?= $Distributors ?>;

    for (var i = 0; i < charts.length; i++) {
        var count = $(charts[i]).attr('callcount');
        chartCard($(charts[i]).attr('id'),((count/sum)*100));

    }
    // Code used to add Todo Tasks
    jQuery(document).ready(function ($) {
        $("#flowcheckall").click(function () {
            $('.table tbody input[type="checkbox"]').prop('checked', this.checked);

        });
        var $todo_tasks = $("#todo_tasks");
        $todo_tasks.find('input[type="text"]').on('keydown', function (ev) {
            if (ev.keyCode == 13) {
                ev.preventDefault();
                if ($.trim($(this).val()).length) {
                    var $todo_entry = $(
                        '<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>' +
                        $(this).val() + '</label></div></li>');
                    $(this).val('');

                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                    $todo_entry.hide().slideDown('fast');
                    replaceCheckboxes();
                }
            }
        });


    });
    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>Client/Distributors/" + DateRange;

    });
    var url = $("#base").val();
    $(document).ready(function ($) {
        $(document).on("click", ".clickable-row td:not(.checkable-td)", function () {
            var ClientID = $(this).parents("tr").data("href");
            window.location = url + "Client/Details/" + ClientID;
        });
    });
    $("#button11").click(function () {
        var base = $("#base").val();
        var resetcount = $("#resestcount").val();
        var asNewData = 0;
        var emp;
        emp = $("#sel2").val();
        var customerid = '';
        var count = 0;
        for (var i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                customerid += $('.custid' + i).val() + ',';
                count++;
            }
        }

        if ($("#asNewClient").is(":checked")) {
            asNewData = 1;
        } else {
            asNewData = 0;
        }

        var msg = "هل انت متاكد من تحويل عدد ";
        msg += $.trim(count);
        msg += " من المهام للمستخدم ";
        var empname = $("#sel2 option:selected").text().replace('N/A, ', '');
        msg += $.trim(empname);
        if (asNewData == 1) {
            msg += " كحالات جديدة ";
        }
        var assignConfirm = confirm(msg);
        if (assignConfirm) {
            $.ajax({
                type: "POST",
                url: base + "Mission/asgin_user",
                data: ({
                    customerid: customerid,
                    emp: emp,
                    status: asNewData
                }),
                success: function (data) {
                    if (data == 0) {
                        alert("تم تعين المهام بنجاح");
                        window.location.reload();
                    }
                }
            });
        }



    });
    $("#deleteData").click(function () {
        var base = $("#base").val();
        var resetcount = $("#resestcount").val();

        var customerid = '';
        var count = 0;
        for (var i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                customerid += $('.custid' + i).val() + ',';
                count++;
            }
        }
        //alert(customerid);
        var msg = "هل انت متاكد من حذف عدد ";
        msg += count;
        msg += " ؟ ";
        var deleteconfirm = confirm(msg);
        if (deleteconfirm) {
            if (count > 0) {
                $.ajax({
                    type: "POST",
                    url: base + "Mission/DeleteDistributorClient",
                    data: ({
                        customerid: customerid
                    }),
                    success: function (data) {
                        if (data > 0) {
                            alert("تم حذف البيانات بنجاح");
                            window.location.reload();
                        } else {
                            alert("حدث خطأ اثناء حذف البيانات");
                        }
                    }
                });
            } else {
                alert("يجب اختيار العملاء المراد حذفهم اولاً");
            }
        }
    });
    $("#reAssign").click(function () {

        var base = $("#base").val();
        var resetcount = $("#resestcount").val();
        var emp = "<?php echo $_SESSION["userid"] ?>";
        var asNewData = 0;

        var customerid = '';
        for (var i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                customerid += $('.custid' + i).val() + ',';
            }
        }

        if ($("#asNewClient").is(":checked")) {
            asNewData = 1;
        } else {
            asNewData = 0;
        }

        $.ajax({
            type: "POST",
            url: base + "Mission/asgin_user",
            data: ({
                customerid: customerid,
                emp: emp,
                status: asNewData
            }),
            success: function (data) {
                if (data == 0) {
                    alert("تم تعين المهام بنجاح");
                    window.location.reload();
                }
            }
        });
    });
    $("#sendSMS").click(function () {
        var base = $("#base").val();
        var resetcount = $("#resestcount").val();
        var msg = $("#smsContent").val();
        var customerid = '';
        for (var i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                customerid += $('.custid' + i).val() + ',';
            }
        }
        // alert(customerid);
        if (customerid == '') {
            alert("برجاء إختيار العملاء أولاً")
        } else {
            $.ajax({
                type: "POST",
                url: base + "Client/SendBulkSMS",
                data: ({
                    customerid: customerid,
                    message: msg
                }),
                success: function (data) {
                    var result = jQuery.parseJSON(data);
                    if (result.errorCode == 0) {
                        alert("تم إرسال الرسائل بنجاح");
                        document.location.reload();
                    } else
                        alert(result.message);
                }
            });
        }
    });
    $("#sendMail").click(function () {
        // alert("asdas");

        var nums = $("#resestcount").val();
        var base = $("#base").val();
        var clientid;
        var customerid = '';
        var subject = $("#mailTitle").val();
        var content = $("#mailBody").val();
        var Check = true;

        if (subject != "" && content != "") {
            for (var i = 0; i < nums; i++) {
                if ($('.elem' + i).is(":checked")) {
                    customerid += $('.custid' + i).val() + ',';
                }
            }
            $.ajax({
                type: "POST",
                url: base + "CRM_Mails/sendBuckMail",
                data: ({
                    to: customerid,
                    subject: subject,
                    content: content
                }),
                success: function (data) {
                    //alert(data);
                    if (data == '1') {
                        alert("تم  ارسال الايميال بنجاح");
                        location.reload();
                    } else if (data == '0') {
                        alert("لم يتم  ارسال الايميال ");
                    } else if (data == '2') {
                        alert("برجاء التاكد من إعدادات البريد الإلكترونى");
                    }
                }
            });

        } else {
            alert("لا يمكن ان يكون العنوان فارغ او المحتوي");

        }

    });


</script>



</body>

</html>