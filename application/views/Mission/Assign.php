<?php $this->load->view("header"); ?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin: 1% 9% 0% 3% ;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">
        <div class="container mx-auto">
            <!--Date And Time-->
            <?php $this->load->view("Admin/DateTimeDiv"); ?>
            <!--Date And Time-->
        </div>

                <div class="m-portlet__body  m-portlet__body--no-padding">

                    <div class="row m-row--no-padding m-row--col-separator-sm ">

                        <div class="col-md-12 col-lg-6 col-xl-3 pb-4 bg-white" style="
    margin-left: 27px;
    margin-right: 27px;
    height: 175px;
">
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
                                    <?php
                                    $AllClients = isset($AllData)?$AllData:0;
                                        if ($AllClients > 0){
                                            $progresse =($AllClients/$AllClients)*100;
                                        }else{
                                            $progresse = 0;
                                        }
                                    ?>

                                    <span class="m-widget24__stats m--font-sccess" data-start="0" data-end="51" data-postfix="" data-duration="1500" data-delay="600">
													 <?= isset($AllData)?$AllData:0 ?>
                                </span>
                                    <div class="m--space-10"></div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-success" role="progressbar" style="width: <?= $progresse?>%;" aria-valuenow="50" aria-valuemin="51" aria-valuemax="100"></div>
                                    </div>


                                </div>
                            </div>

                            <!--end::Total Profit-->
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-3 pb-4 bg-white">
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
                                    <?php
                                    $clientCount = isset($clients)?count($clients):0;
                                    if ($AllClients > 0){
                                        $progresse =($clientCount/$AllClients)*100;
                                    }else{
                                        $progresse = 0;
                                    }
                                    ?>
                                    <span class="m-widget24__stats m--font-barnd" data-start="0" data-end="<?= $clientCount ?>" data-postfix="" data-duration="1500" data-delay="600">
                                          <?= $clientCount ?>
												</span>
                                    <div class="m--space-10">

                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-barnd" role="progressbar"
                                             style="width: <?=$progresse?>%;" aria-valuenow="50" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>


                                </div>
                            </div>

                            <!--end::New Feedbacks-->
                        </div>

                    </div>
                    <div class="m-portlet mb-3 " id="parent-div">
                    </div>
                </div>

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <!-- BEGIN: Aside Menu -->
            <!-- END: Aside Menu -->
            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                        <!--begin::Item-->
                        <div class="m-accordion__item">
                            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head"
                                 data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="true">
                                <span class="m-accordion__item-icon"><i class="fa fa-filter"></i></span>
                                <span class="m-accordion__item-title">Filter</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body"
                                 role="tabpanel" aria-labelledby="m_accordion_1_item_1_head"
                                 data-parent="#m_accordion_1" style="">
                                <div class="m-accordion__item-content">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group m-form__group row">

                                                            <div class="col-lg-12">
                                                                <select id="sel2" name="empName"
                                                                        class="form-control select2-static">
                                                                    <option value="" selected disabled>المستخدمين
                                                                    </option>
                                                                    <?php if(isset($employee)){ for($i=0;$i<count($employee);$i++){?>
                                                                        <option
                                                                                value="<?php echo $employee[$i]->ID ?> ">
                                                                            <?php
                                                                            if ($employee[$i]->Type ==2){
                                                                                echo $employee[$i]->Name." (مشرف) ";
                                                                            }else if ($employee[$i]->Type == 3){
                                                                                echo $employee[$i]->Name." (موظف) ";
                                                                            }else if ($employee[$i]->Type == 4){
                                                                                echo $employee[$i]->Name." (إدارى) ";
                                                                            }
                                                                            ?>
                                                                        </option>
                                                                    <?php } }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 space">
                                                        <button type="button" class="btn btn-success btn-block"
                                                                id="button11">تعيين <i
                                                                    class="flaticon flaticon-file-2"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group m-form__group row">

                                                            <div class="col-12">
                                                                <input type="number" min="1" max="<?php echo count($clients)?>"
                                                                       placeholder="عدد العملاء" value="
                                                                            10" class="form-control" id="Data-Length">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button"
                                                                class="btn btn-primary btn-block page-size">
                                                            عرض <i
                                                                    class=" flaticon flaticon-web ml-2"></i></button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-danger btn-block"
                                                                id="deleteData">حذف
                                                            <i class="flaticon flaticon-delete ml-2"></i></button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                </div>

                <div class="col-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        تعيين مهام
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-portlet__body-progress">Loading</div>
                            <!--begin: Datatable -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($clients)?>">
                                        <table class="table m-table" id="example" width="100%">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 10px;background: none"
                                                    aria-label=": activate to sort column ascending"><input
                                                            type="checkbox" value="" id="flowcheckall" class="chk">
                                                </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 150px;"
                                                    aria-label="الاسم: activate to sort column descending"
                                                    aria-sort="ascending">الاسم<i
                                                            class="flaticon-user ml-2"></i></th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 90px;"
                                                    aria-label="التليفون: activate to sort column ascending">
                                                    التليفون<i class="flaticon-support ml-2"></i></th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 90px;"
                                                    aria-label="الشركة: activate to sort column ascending">
                                                    الشركة<i class="la la-building-o"></i>
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 120px;"
                                                    aria-label="الوظيفة: activate to sort column ascending">
                                                    الوظيفة<i class="flaticon-network"></i>
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 93px;"
                                                    aria-label="المحافظة: activate to sort column ascending">
                                                    المحافظة<i class="flaticon flaticon-buildings"></i></th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 60px;"
                                                    aria-label="النشاط: activate to sort column ascending">
                                                    النشاط<i class="flaticon flaticon-presentation-1"></i>
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 180px;"
                                                    aria-label="تم الإضافة بواسطة: activate to sort column ascending">
                                                    تم الإضافة بواسطة <i class="flaticon flaticon-user"></i></th>
                                                <th class="sorting" tabindex="0" aria-controls="example"
                                                    rowspan="1" colspan="1" style="width: 170px;"
                                                    aria-label=" تاريخ رفع البيانات : activate to sort column ascending">
                                                    تاريخ رفع البيانات <i class="flaticon flaticon-clock-2"> </i></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php for ($i=0; $i < count($clients); $i++) {
                                                ?>
                                                <tr>
                                                    <td><input type="checkbox"
                                                               class="checkboxMy  <?php echo 'chk elem'.$i?>">
                                                        <input type="hidden" class="dataID <?php echo 'custid'.$i?>"
                                                               value="<?php echo $clients[$i]->customerCrmId?>">
                                                    </td>
                                                    <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmName?>">
                                                        <?php echo $clients[$i]->customerCrmName?>
                                                    </td>
                                                    <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmPhone?>">
                                                        <?php echo $clients[$i]->customerCrmPhone?>
                                                    </td>

                                                    <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmCompany?>">
                                                        <?php echo $clients[$i]->customerCrmCompany?>
                                                    </td>
                                                    <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmJob?>">
                                                        <?php echo $clients[$i]->customerCrmJob?></td>
                                                    <td <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmGov?>">

                                                        <?php echo $clients[$i]->customerCrmGov?></td>
                                                    <td>

                                                        <?php echo $clients[$i]->customerCrmActivity?></td>

                                                    <td>

                                                        <?php echo get_Emp_name($clients[$i]->addedby)?>
                                                    </td>
                                                    <td>

                                                        <?php echo date("Y-m-d",strtotime($clients[$i]->customerCrmCreateDate))?>
                                                    </td>

                                                </tr>

                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end: Datatable -->
                            <!--end: Datatable -->
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable({
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
            'columnDefs': [{
                orderable: false,
                targets: [0]
            }],
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
    });


    $("#selectall").change(function () {
        if (this.checked) {
            var selectAll = $(".checkboxMy").toArray();
            for (var x = 0; x < selectAll.length; x++) {
                $(selectAll[x]).attr("checked", "checked");
            }
        } else {
            var selectAll = $(".checkboxMy").toArray();
            for (var x = 0; x < selectAll.length; x++) {
                $(selectAll[x]).removeAttr("checked", "checked");
            }
        }
    })


    $(".page-size").click(function () {
        var size = document.getElementById('Data-Length').value;
        if (size <= 0) {
            alert("تاكد من الرقم الذى ادخلته")
        } else {
            $('#example').DataTable().page.len(size).draw();
        }
    });


    $("#remove_All").click(function(){
        var smsids=[];
        var count = 0;
        var selectAll = $(".checkboxMy").toArray();
        for (var x=0; x < selectAll.length; x++){
            if(selectAll[x].checked){
                smsids[count] = $(selectAll[x]).attr("smsID");
                count++;
            }
        }
        var result = 0;
        for(var i=0;i<smsids.length;i++){
            // alert(smsids[i]);
            $.ajax({
                type: "POST",
                url: base + "SMS/deleteSMS",
                data: ({
                    id: smsids[i]
                }),
                success: function (data) {
                    var result = $.parseJSON(data);
                    if (result.error == 0) {
                        result = 0;
                        //alert(result.message);
                        //window.location.reload();
                    } else {
                        result = 1;
                        breack;
                        //alert(result.message);
                    }
                }
            });
        }
        if(result == 0){
            alert("تم المسح عدد"+" "+ count +" "+ "بنجاح " );
            window.location.reload();
        }else{
            alert("حدث مشكلة اثناء عملية المسح");
        }
    })


    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>Mission/Assign/" + DateRange;
    });
</script>

<script type="text/javascript">
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
</script>
<script>
    $("#button11").click(function () {
        var base = $("#base").val();
        // $(".showLoading").show();
        var resetcount = $("#resestcount").val();
        var emp;
        emp = $("#sel2").val();
        var count = 0;
        var customerid = '';
        var i;
        for (i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                count++;
                customerid += $('.custid' + i).val() + ',';
            }
        }

        if (emp <=0) {
            alert("برجاء إختيار إسم المستخدم");
        }else{
            if (count > 0){
                var msg = "هل انت متاكد من تحويل عدد ";
                msg += $.trim(count);
                msg += " من المهام للمستخدم ";
                var empname = $("#sel2 option:selected").text().replace('N/A, ', '');
                msg += $.trim(empname);
                var assignConfirm = confirm(msg);
                if (assignConfirm) {
                    $.ajax({
                        type: "POST",
                        url: base + "Mission/asgin_user",
                        data: ({
                            customerid: customerid,
                            emp: emp,
                            status: 1
                        }),
                        success: function (data) {
                            if (data == 0) {
                                $(".showLoading").hide();
                                alert("تم تعين المهام بنجاح");
                                window.location.reload();
                            }
                        }
                    });
                }
            } else{
                alert("برجاء إختيار العملاء أولا");
            }
        }



    });

    $("#deleteData").click(function () {
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf){
        var base = $("#base").val();
        var resetcount = $("#resestcount").val();

        var customerid ='';
        var count = 0;
        for (var i = 0; i < resetcount; i++) {
            if ($('.elem' + i).is(":checked")) {
                customerid += $('.custid' + i).val() + ',';
                count++;
            }
        }
        if (count > 0) {
            var deleteConfirm = confirm("هل انت متاكد من عملية الحذف");
            if (deleteConfirm) {
                $.ajax({
                    type: "POST",
                    url: base + "Mission/Delete_Client",
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
            }

        } else {
            alert("يجب اختيار العملاء المراد حذفهم اولاً");
        }
        }

    });
</script>

</body>

</html>