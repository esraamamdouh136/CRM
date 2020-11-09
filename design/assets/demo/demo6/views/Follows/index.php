<?php $this->load->view("header");
$margen ='';
if ($_SESSION['usertype'] == 3){
    $margen = 'margin-top: 80px';
}
//margin-top: 80px;
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%;margin-left: 2%">


    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Aside Menu -->
            <!-- END: Aside Menu -->
            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">
                        <!--begin::Item-->
                        <div class="m-accordion__item ">
                            <div class="m-accordion__item-head collapse" role="tab"
                                 id="m_accordion_1_item_1_head" data-toggle="collapse"
                                 href="#m_accordion_1_item_1_body" aria-expanded="false">
                                <span class="m-accordion__item-icon"><i class="fa fa-filter"></i></span>
                                <span class="m-accordion__item-title">Filter</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapse collapsed show" id="m_accordion_1_item_1_body"
                                 role="tabpanel" aria-labelledby="m_accordion_1_item_1_head"
                                 data-parent="#m_accordion_1">
                                <div class="m-accordion__item-content">

                                    <div class="row">


                                        <?php if ($_SESSION['usertype'] < 3){?>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="m-checkbox mt-2">
                                                            <input type="checkbox" id="asNewClient" >كحالة
                                                            جديدة
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group m-form__group row">

                                                            <div class="col-12">
                                                                <select class="form-control select2-static"
                                                                        id="sel2" name="empName">
                                                                    <option value="" selected=""
                                                                            disabled="">
                                                                        المستخدمين</option>
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

                                                    <div class="col-md-3 space mb-2">
                                                        <button type="button" class="btn btn-success btn-block"
                                                                id="Assign">تعيين <i
                                                                    class="flaticon flaticon-file-2"></i></button>
                                                        <?php
                                                        if ($_SESSION["usertype"] == 2){ ?>
                                                            <button type="button" class="btn btn-success btn-block"
                                                                    id="reAssign">تحويل لمهامى <i
                                                                        class="flaticon flaticon-file-2"></i></button>

                                                        <?php }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php      } ?>






                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group m-form__group row">

                                                        <div class="col-12">
                                                            <input type="number" min="1" max="<?= isset($Clients)?count($Clients):0 ?>"
                                                                   placeholder="عدد العملاء" value="
																				10" class="form-control" id="Data-Length">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button"
                                                            class="btn btn-primary btn-block page-size">عرض
                                                        <i class="flaticon flaticon-web ml-2"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

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
                                       <?= $title ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-portlet__body-progress">Loading</div>
                            <!--begin: Datatable -->
                            <div class="table-responsive">
                                <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($Clients)?>">
                                <table class="table m-table" id="example" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1" style="width: 30px;background: none"
                                            aria-sort="ascending" aria-label="

														: activate to sort column descending">
                                            <input type="checkbox" id="selectall" >
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 150px;"
                                            aria-label="الاسم: activate to sort column ascending">الاسم</th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 108px;"
                                            aria-label="الشركة: activate to sort column ascending">الشركة
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 150px;"
                                            aria-label="الوظيفة: activate to sort column ascending">الوظيفة
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 157px;"
                                            aria-label="حالة المكالة: activate to sort column ascending">
                                            حالة
                                            المكالة</th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 118px;"
                                            aria-label="الموظف: activate to sort column ascending">الموظف
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 120px;"
                                            aria-label="المشرف: activate to sort column ascending">المشرف
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 120px;"
                                            aria-label="الوقت: activate to sort column ascending">الوقت
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 120px;"
                                            aria-label="التاريخ: activate to sort column ascending">التاريخ
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                            colspan="1" style="width: 120px;"
                                            aria-label="مكالمة محولة: activate to sort column ascending">مكالمة محولة
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>



                                    <?php if(isset($Clients)){ for($i=0;$i<count($Clients);$i++){
                                        $row =get_row('call_status',['id'=>$Clients[$i]->Status],null)->title;
                                        ?>


                                        <tr class="clickable-row task-list-row odd" style="cursor: pointer;" data-priority ="<?php echo $row ?>" data-href= "<?php echo $Clients[$i]->customerCrmId?>">
                                            <td class="checkable-td">
                                                <input type="checkbox"
                                                       class="checkboxMy  <?php echo 'chk elem'.$i?>" custid="<?php echo $Clients[$i]->customerCrmId?>">
                                                <input type="hidden" class="dataID <?php echo 'custid'.$i?>"
                                                       value="<?php echo $Clients[$i]->customerCrmId?>">
                                            </td>
                                            <td>
                                                <?php echo $Clients[$i]->customerCrmName ?>
                                            </td>

                                            <td>
                                                <?php echo $Clients[$i]->customerCrmCompany?>
                                            </td>
                                            <td>
                                                <?php echo $Clients[$i]->customerCrmJob?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $row?>
                                            </td>
                                            <td>
                                                <?php echo get_Emp_name($Clients[$i]->userID)?>
                                            </td>

                                            <td>
                                                <?php echo get_Super_Name($Clients[$i]->userID)?>

                                            </td>

                                            <td>
                                                <?php echo date('h:i a', strtotime($Clients[$i]->Follow_Time)) ?>
                                            </td>
                                            <td>
                                                <?php echo $Clients[$i]->Follow_Date?>
                                            </td>
                                            <td>
                                                <input type="checkbox" readonly <?=($Clients[$i]->redirect == 1)?'checked':'' ?>  disabled>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    }?>



                                    </tbody>
                                </table>
                            </div>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

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
            'columnDefs': [ { orderable: false, targets: [0] }]
        });
    });


    $("#selectall").change(function () {
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = element.checked;
        });
    });



</SCRIPT>

<script type="text/javascript">
    // Code used to add Todo Tasks

    $(".page-size").click(function () {
        var size = document.getElementById('Data-Length').value;
        $('#example').DataTable().page.len(size).draw();

    });
    var url=$("#base").val();
    $(document).ready(function($) {
        $(".clickable-row td:not(.checkable-td)").click(function() {
            var ClientID = $(this).parents("tr").data("href");
            window.location=url+"Client/Details/" +ClientID ;
        });
    });
    $("#Assign").click(function () {

        debugger;
        var base = $("#base").val();
        var resetcount = $("#resestcount").val();
        var emp;
        var asNewData = 0;
        emp = $("#sel2").val();
        var customerid = '';

        $(':checkbox.checkboxMy').each(function() {
            if ($(this).is(":checked")) {
                customerid += $(this).attr("custid") + ',';
            }

        });
        if ($("#asNewClient").is(":checked")){
            asNewData = 1;
        }else{
            asNewData = 0;
        }
        if (emp == null){
            alert("برجاء إختيار الموظف المراد تحويل المهمام إليه");
        }else {
            if (customerid == ""){
                alert("برجاء إختيار العملاء المراد تحويلهم")
            }else {
                $.ajax({
                    type: "POST",
                    url: base + "Mission/asgin_user",
                    data: ({
                        customerid: customerid,
                        emp: emp,
                        status:asNewData
                    }),
                    success: function (data) {
                        if (data == 0) {
                            alert("تم تعين المهام بنجاح");
                            window.location.reload();
                        }
                    }
                });
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
        if ($("#asNewClient").is(":checked")){
            asNewData = 1;
        }else{
            asNewData = 0;
        }

        $.ajax({
            type: "POST",
            url: base + "Mission/asgin_user",
            data: ({
                customerid: customerid,
                emp: emp,
                status:asNewData
            }),
            success: function (data) {
                if (data == 0) {
                    alert("تم تعين المهام بنجاح");
                    window.location.reload();
                }
            }
        });
    });

</script>

</body>

</html>