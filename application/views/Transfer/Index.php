<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:26 PM
 */
$this->load->view("header");
?>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%;margin-left: 2%">
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">

                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a data-toggle="modal" data-target="#AddTransfer" class="btn btn-info m-btn--icon">
                                            <span style="color:white;">
                                                <i class="la la-plus"></i>
                                                <span>طريقة شحن جديدة</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">

                            <!--begin: Datatable -->
                            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table m-table  table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="example_1" role="grid" aria-describedby="m_table_1_info" style="width: 974px;">
                                                <thead>

                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 63.25px;" aria-label="Order ID: activate to sort column ascending">
                                                        طريقه الشحن</th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 65.25px;" aria-label="Country: activate to sort column ascending">
                                                        السعر</th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">
                                                        الوصف </th>

                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">
                                                        عمليات </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php

                                                if(isset($Transfer)){ for($i=0;$i<count($Transfer);$i++){?>
                                                    <tr protype="1" class="unread"  ><!-- new email class: unread -->

                                                        <td class="col-name pname">
                                                            <?php echo $Transfer[$i]->transfer_Name?>
                                                        </td>
                                                        <td class="pprice">
                                                            <?php echo $Transfer[$i]->Price?>
                                                        </td>
                                                        <td class="col-subject pdesc">
                                                            <?php echo $Transfer[$i]->Description?>
                                                        </td>

                                                        <td class="col-subject">
                                                            <a data-toggle="modal" data-target="#EditTransfer" TransferID="<?php echo $Transfer[$i]->transfer_ID?>" class="btn btn-outline-success icon-left EditTransfer">

                                                                تعديل</a>
                                                            <button class="btn btn-outline-danger deleteTransfer" TransferID="<?php echo $Transfer[$i]->transfer_ID?>">
                                                                حذف
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } }?>






                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a data-toggle="modal" data-target="#AddPayment" class="btn btn-info m-btn--icon">
                                            <span style="color:white;">
                                                <i class="la la-plus"></i>
                                                <span>طريقة دفع جديدة</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">

                            <!--begin: Datatable -->
                            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table m-table  table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="example_1" role="grid" aria-describedby="m_table_1_info" style="width: 974px;">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 63.25px;" aria-label="Order ID: activate to sort column ascending">
                                                        طريقه الدفع</th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">
                                                        عمليات </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(isset($PaymentTypes)){ for($i=0;$i<count($PaymentTypes);$i++){?>
                                                    <tr protype="1" class="unread"  ><!-- new email class: unread -->
                                                        <td class="col-name pname">
                                                            <?php echo $PaymentTypes[$i]->Name?>
                                                        </td>
                                                        <td class="col-subject">
                                                            <a data-toggle="modal" data-target="#EditPayment" PaymentID="<?php echo $PaymentTypes[$i]->ID?>" class="btn btn-outline-success EditPayment">

                                                                تعديل</a>
                                                            <button class="btn btn-outline-danger deletePayment" PaymentID="<?php echo $PaymentTypes[$i]->ID?>">
                                                                حذف
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                                </tbody>
                                            </table>

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


<!-- AddTransfer Modal -->
<div class="modal fade" id="AddTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> طرق الشحن : إضافة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'/Transfer/create'); ?>
                <div class="form-row">
                    <label> طريقة الشحن </label>
                    <input type="text" name="transferName" class="form-control" placeholder="طريقة الشحن" required>
                </div>


                <div class="form-row my-3">
                    <label>  تكلفة الشحن </label>
                    <input type="number" class="form-control" min="0" value="0" name="transferPrice"
                           placeholder=" تكلفة الشحن">

                </div>

                <div class="for">
                    <label> الوصف </label>
                    <textarea  name="transferDescription" class="form-control ckeditor" placeholder="الوصف" cols="30" rows="5" ></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info esbutton" value="إضافة">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- AddTransfer Modal -->


<!-- AddPayment Modal -->
<div class="modal fade" id="AddPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> طرق الشحن : إضافة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'Payment/Add'); ?>
                <div class="form-row">
                    <label> طريقة الدفع </label>
                    <input type="text" name="paymentName" class="form-control" placeholder="طريقة الدفع" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info esbutton" value="إضافة">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- AddPayment Modal -->


<!-- EditTransfer Modal -->
<div class="modal fade" id="EditTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">طرق الشحن : تعديل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'/Transfer/updateData'); ?>
                <input type="hidden" name="transID" id="transID" value="0">
                <div class="form-row">
                    <label> طريقة الشحن </label>
                    <input type="text" name="transferName" id="transferName" class="form-control" placeholder="طريقة الشحن" required>
                </div>

                <div class="form-row my-3">
                    <label> تكلفة الشحن </label>
                    <input type="number" class="form-control" min="0" value="0" name="transferPrice" id="transferPrice" placeholder="تكلفة الشحن" >
                </div>
                <div class="form-group">
                    <label class="col-lg-12"> الوصف </label>
                    <div class="col-lg-12">
                    <textarea  name="transferDescription" id="transferDescription" class="form-control ckeditor" placeholder="الوصف"  ></textarea>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info esbutton" value="حفظ">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- EditTransfer Modal -->


<!-- EditPayment Modal -->
<div class="modal fade" id="EditPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> طريق الدفع : تعديل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'Payment/Update'); ?>
                <input type="hidden" name="transID" id="PaymentID" value="0">
                <div class="form-row">
                    <label>طريقة الدفع</label>
                    <input class="form-control" id="paymentName" type="text" name="paymentName" placeholder="طريقة الدفع" required>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info esbutton" value="حفظ">
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!-- EditPayment Modal -->







<script>
    $("document").ready(function(){
        $("table[id^='example']").dataTable({
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
            }
        });
    });
    $(".deleteTransfer").click(function () {
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf){
            var transID = $(this).attr("TransferID");
            var base = $("#base").val();
            $.ajax({
                type: "POST",
                url: base + "Transfer/delete",
                data: ({
                    ID: transID
                }),
                success: function (data) {
                    let result =  $.parseJSON(data);
                    if (result.Error == 0) {
                        alert("تم المسح بنجاح");
                        location.reload();
                    } else {
                        alert(result.message);
                    }

                }
            });
        }


    });
    $(".deletePayment").click(function () {
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf) {
            var PayID = $(this).attr("PaymentID");
            var base = $("#base").val();
            $.ajax({
                type: "POST",
                url: base + "Payment/Delete",
                data: ({
                    ID: PayID
                }),
                success: function (data) {
                    let result =  $.parseJSON(data);
                    if (result.Error == 0) {
                        alert("تم المسح بنجاح");
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                }
            });
        }
    });
    $(".EditTransfer").click(function () {
        var transID = $(this).attr("TransferID");
        // load Data
        $.ajax({
            type: "POST",
            url: base + "Transfer/GetData",
            data: ({
                ID: transID
            }),
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.Error == 0) {
                    $("#transferName").val(result.Transfer['transfer_Name']);
                    $("#transID").val(result.Transfer['transfer_ID']);
                    $("#transferPrice").val(result.Transfer['Price']);
                    $("#transferDescription").val(result.Transfer['Description']);
                } else {
                    alert("حدث خطأ");
                }
            }
        });
        // alert(ID);
    });
    $(".EditPayment").click(function () {
        var PayID = $(this).attr("PaymentID");
        // load Data
        $.ajax({
            type: "POST",
            url: base + "Payment/GetData",
            data: ({
                ID: PayID
            }),
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.Error == 0) {
                    $("#paymentName").val(result.Transfer['Name']);
                    $("#PaymentID").val(result.Transfer['ID']);

                } else {
                    alert("حدث خطأ");
                }
            }
        });
    });
</script>
</body>

</html>