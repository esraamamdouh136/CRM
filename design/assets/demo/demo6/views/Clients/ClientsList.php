<?php $this->load->view("header");?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:2%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    
        <div class="m-content">
<div class="container ml-sm-5">
            <!--Date And Time-->
            <?php $this->load->view("Admin/DateTimeDiv"); ?>
            <!--Date And Time-->
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
                                                                    <input type="number" min="1" max="4"
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
                                            <table class="table m-table" id="example"
                                                   width="100%">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 10px;background: none"
                                                        aria-label=": activate to sort column ascending"><input
                                                                type="checkbox" value="" id="" class="chk">
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 70px;"
                                                        aria-label="الاسم: activate to sort column descending"
                                                        aria-sort="ascending">الاسم<i
                                                                class="flaticon-user ml-2"></i></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 90px;"
                                                        aria-label="التليفون: activate to sort column ascending">
                                                        التليفون<i class="flaticon-support ml-2"></i></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 60px;"
                                                        aria-label="الايميل: activate to sort column ascending">
                                                        الايميل<i class="flaticon-email"></i>
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 120px;"
                                                        aria-label="الشركه: activate to sort column ascending">
                                                        الشركه<i class="la la-building-o"></i>
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 93px;"
                                                        aria-label="الوظيفه: activate to sort column ascending">
                                                        الوظيفه<i class="flaticon flaticon-network"></i></th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 160px;"
                                                        aria-label="حاله المكالمات: activate to sort column ascending">
                                                        حاله المكالمه<i class="flaticon flaticon-support"></i>
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example"
                                                        rowspan="1" colspan="1" style="width: 150px;"
                                                        aria-label="مده اخر مكالمه  : activate to sort column ascending">
                                                        مده اخر مكالمه   <i class="flaticon flaticon-support"></i></th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(isset($empClients)){ for($i=0;$i< count($empClients);$i++){
                                                    $statusname = get_row('call_status',array('id'=>$empClients[$i]->Status),null)->title;

                                                    ?>
                                                    <tr class="clickable-row task-list-row"
                                                        style="cursor: pointer;" data-href= <?=$empClients[$i]->customerCrmId?>>

                                                        <td class="TD">
                                                            <input type="checkbox" class="checkboxMy  <?php echo 'chk elem'.$i?>">
                                                            <input type="hidden" class="dataID <?php echo 'custid'.$i?>" value="<?php echo $empClients[$i]->customerCrmId?>">
                                                        </td>
                                                        <td><?php echo $empClients[$i]->customerCrmName?></td>
                                                        <td><?php echo $empClients[$i]->customerCrmPhone?></td>
                                                        <td><?php echo $empClients[$i]->customerCrmEmail?></td>
                                                        <td><?php echo $empClients[$i]->customerCrmCompany?></td>
                                                        <td><?php echo $empClients[$i]->customerCrmJob?></td>
                                                        <td><?php echo $statusname?></td>
                                                        <td><?php echo GetCallDuration($empID,$empClients[$i]->customerCrmId)?></td>
                                                    </tr>
                                                <?php } }?>
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


<script type="text/javascript">
    // Code used to add Todo Tasks
    jQuery(document).ready(function($)
    {

        $("#flowcheckall").click(function () {
            $('.table tbody input[type="checkbox"]').prop('checked', this.checked);

        });
        var $todo_tasks = $("#todo_tasks");

        $todo_tasks.find('input[type="text"]').on('keydown', function(ev)
        {
            if(ev.keyCode == 13)
            {
                ev.preventDefault();

                if($.trim($(this).val()).length)
                {
                    var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
                    $(this).val('');

                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                    $todo_entry.hide().slideDown('fast');
                    replaceCheckboxes();
                }
            }
        });

        $('#myTable').DataTable(
            {
                responsive:true,
                ordering:false,
                "paging": true,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]]
            }
        );
        $(".page-size").click(function () {
            var size = document.getElementById('Data-Length').value;
            $('#myTable').DataTable().page.len(size).draw();


        });
    });



    



    var url=$("#base").val();
    $(document).ready(function($) {
        $(document).on('click','.clickable-row td:not(.TD)', function(){
            var ClientID = $(this).parents('tr').data("href");
            window.location=url+"Client/Details/" +ClientID ;
        });
    });


    $(document).on("click","#searchButton",function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>Client/Clients/<?= $empID?>/"+DateRange;
    });
</script>
</body>

</html>