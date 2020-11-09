<?php $this->load->view("header");?>
<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->






<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-left: 3%; margin-right:9%; margin-bottom: 12%; margin-top:2%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                تفاصيل الشراء
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <button class="btn btn-info"  data-toggle="modal" data-target="#exampleModal"> اضافه </button>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">


                    <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo" style="font-size: 16px; margin-bottom:14px;">
                        <div class="m-stack__item m-stack__item--center">
                                                <span class="m-nav__link-text">
                                                    <i class="m-nav__link-icon flaticon-user"></i>
                                                    <b class="mr-2"> اسم العميل
                                                        :</b> <?php echo get_name($orderDetails[0]->Client_ID,2) ?></span>
                        </div>
                        <div class="m-stack__item m-stack__item--center icon_sppourt">

                            <i class=" flaticon-user"></i>
                            <span class="m-nav__link-text"><b class="mr-2"> اسم الموظف :</b>

                                <?php echo get_Emp_name($orderDetails[0]->User_ID) ?>
                                                </span>
                        </div>
                        <div class="m-stack__item m-stack__item--center">
                            <i class="flaticon flaticon-clock-2"></i>
                            <span class="m-nav__link-text"><b class="mr-2"> التاريخ :</b>
                                                        <?php echo date('Y-m-d', strtotime($orderDetails[0]->Date)) ?>
                                                    </span>

                        </div>
                    </div>


                    <table class="table m-table" id="OrderTable">
                        <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width:50px;" aria-label="الاسم: activate to sort column ascending"> الاسم
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width:50px;">
                                سعر الوحده </th>
                            <th style="width:20px;">الكميه </th>
                            <th style="width:30px;">طريقه الشحن </th>
                            <th style="width:30px;">طريقه الدفع</th>
                            <th style="190px">  العمليات </th>
                        </tr>
                        </thead>
                        <input type="hidden" class="cliecount" value="<?= isset($Orders) ? count($Orders) : "0" ?>">
                        <tbody>
                        <?php if(isset($orderDetails)){ for($i=0;$i< count($orderDetails);$i++){

                            ?>
                            <tr class="table-row" >
                                <td>

                                    <?php echo getItemName($orderDetails[$i]->Unit_ID) ?>
                                </td>
                                <td>
                                    <?php echo $orderDetails[$i]->Price ?>
                                </td>
                                <td>
                                    <?php echo $orderDetails[$i]->Quantity ?>
                                </td>
                                <td>
                                    <?php echo getTransferTypeName($orderDetails[$i]->Transfer_ID) ?>
                                </td>

                                <td>
                                    <?php echo getPaymentTypeName($orderDetails[$i]->Payment_ID)  ?>
                                </td>
                                <td>
                                    <button class="btn btn-outline-success"  data-toggle="modal" data-target="#exampleModal2" id="EditOrder" uintID ="<?=$orderDetails[$i]->DetailsID?>"> تعديل </button>
                                    <button class="btn btn-outline-danger deleteOrder" clientID="<?=$orderDetails[$i]->Client_ID?>"  uintID ="<?=$orderDetails[$i]->DetailsID?>" orderID = "<?=$orderDetails[$i]->ID?>" > حذف </button>

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
<!--اضافه-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافه </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="Purchase_Order m-portlet__body w-100"  id="new-order">

                <!--begin::Section-->
                <div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">

                    <!--begin::Item-->
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head show" role="tab"
                             id="m_accordion_2_item_1_head" data-toggle="collapse"
                             href="#m_accordion_2_item_1_body" aria-expanded="true">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-cart"></i></span>
                            <span class="m-accordion__item-title"> الكميه </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body show" id="m_accordion_2_item_1_body"
                             role="tabpanel" aria-labelledby="m_accordion_2_item_1_head"
                             data-parent="#m_accordion_2">
                            <div class="m-accordion__item-content">
                                <div class="row">
                                    <div class="col-lg-12">


                                        <?php
                                        if(isset($Ordersettings) && !is_null($Ordersettings)){
                                            $chiledSettings = null;
                                            foreach ($Ordersettings as $Setting){?>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="m-checkbox col-lg-4"><?php
                                                            if  ($Setting->Pro_Name !='Amount' && $Setting->Pro_Name !='Contracted'){
                                                                echo $Setting->Text;
                                                            }
                                                            ?>
                                                        </label>
                                                        <?php

                                                        if($Setting->Pro_Name == 'Type'){?>
                                                            <div class="col-lg-4 d-flex">
                                                                <?php
                                                                $chiledSettings = GetOrderSettings($Setting->ID);
                                                                $value = 0;
                                                                foreach ($chiledSettings as $chiled){
                                                                    if ($chiled->Pro_Name == 'product'){
                                                                        $value = 1;
                                                                    }else{
                                                                        $value = 2;
                                                                    }

                                                                    ?>

                                                                    <div>
                                                                        <label class="m-checkbox mr-2">
                                                                            <input type="radio" name="type"
                                                                                   value="<?php echo $value ?>"
                                                                                   onclick="Neworderchangetype(<?php echo $value ?>)"><?php echo $chiled->Text ?>
                                                                            <span></span>
                                                                        </label>

                                                                        <span></span>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </div>
                                                            <?php
                                                        }else if ($Setting->Pro_Name =='Products'){?>
                                                            <div class="col-lg-6">
                                                                <select name="product"
                                                                        id="selectServiceandProudct"
                                                                        class="select2 form-control ">
                                                                </select>
                                                            </div>
                                                        <?php }else if ($Setting->Pro_Name =='Quantity'){ ?>
                                                            <div class="col-lg-6">
                                                                <input type="number" min="0" value="0"
                                                                       name="qyt" class="form-control"
                                                                       id="quantity">
                                                            </div>
                                                        <?php }else if ($Setting->Pro_Name =='Transfer'){ ?>
                                                            <div class="col-lg-6 d-flex">
                                                                <select name="truck" id="transferType"
                                                                        class="select2 form-control col-sm-6">
                                                                    <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                                                        <option
                                                                                value="<?php echo $trucks[$i]->transfer_ID?>"
                                                                                cost="<?php echo $trucks[$i]->Price?>">
                                                                            <?php echo $trucks[$i]->transfer_Name?>
                                                                        </option>
                                                                    <?php }  }?>
                                                                </select>
                                                                <input id="truckCost" value="0" type="number"
                                                                       class="form-control col-sm-6">
                                                            </div>
                                                        <?php }else if ($Setting->Pro_Name =='Payment'){ ?>
                                                            <div class="col-lg-6">
                                                                <select name="truck" id="paymentType"
                                                                        class="select2 form-control">
                                                                    <?php  if(isset($PaymentTypes)){ for($i=0;$i<count($PaymentTypes);$i++){?>
                                                                        <option
                                                                                value="<?php echo $PaymentTypes[$i]->ID?>">
                                                                            <?php echo $PaymentTypes[$i]->Name?>
                                                                        </option>
                                                                    <?php }  }?>
                                                                </select>
                                                            </div>
                                                        <?php }else if ($Setting->Pro_Name =='Amount'){?>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                $chiledSettings2 = GetOrderSettings($Setting->ID);
                                                                $value = 0;
                                                                foreach ($chiledSettings2 as $chiled){?>
                                                                    <div>
                                                                        <label>
                                                                            <?php echo $chiled->Text ?>
                                                                        </label>
                                                                        <input type="number" value="0"
                                                                               name="<?php echo $chiled->Pro_Name ?>">
                                                                    </div>
                                                                    <?php
                                                                }?>
                                                                <input type="text" name="date"
                                                                       style="margin-top: 10px"
                                                                       class="form-control datepicker"
                                                                       value="<?php echo date("Y-m-d")?>"
                                                                       id="date22" data-format="yyyy-mm-dd">
                                                                <?php

                                                                ?>


                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <div class="form-row">
                                            <div class="control-label col-lg-4">
                                                <label>الخصم</label>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="number" value="0" id="discount"
                                                       class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <select id="discountType" class="form-control">
                                                    <option value="0">نسبة%</option>
                                                    <option value="1">مبلغ</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <button type="button" class="btn btn-info btn-md w-25 ml-auto mt-4"
                                                    id="AddOrder">إضافة</button>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Item-->
                    <form method="post" action="<?php echo $url."ClientOrders/AddOrderData"?>">
                        <!--begin::Item-->
                        <input type="hidden" value="<?= $Order_ID?>" name="OrderID">
                        <input type="hidden" value="<?= $Client_ID?>" name="Client_ID">
                        <div class="m-accordion__item">
                            <div class="m-accordion__item-head show" role="tab"
                                 id="m_accordion_2_item_2_head" data-toggle="collapse"
                                 href="#m_accordion_2_item_2_body" aria-expanded="false">
                                <span class="m-accordion__item-icon"><i class="flaticon-bag"></i></span>
                                <span class="m-accordion__item-title"> اضافه </span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body show" id="m_accordion_2_item_2_body"
                                 role="tabpanel" aria-labelledby="m_accordion_2_item_2_head"
                                 data-parent="#m_accordion_2">
                                <div class="m-accordion__item-content">
                                    <div class="m-portlet__body">

                                        <!--begin: Datatable -->

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table
                                                            class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline example"
                                                            id="OrderItems" role="grid"
                                                            aria-describedby="m_table_1_info"
                                                            style="width: 974px;">
                                                        <thead>

                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0"
                                                                aria-controls="m_table_1"
                                                                rowspan="1" colspan="1"
                                                                style="width: 63.25px;"
                                                                aria-label="Order ID: activate to sort column ascending">
                                                                الاسم</th>
                                                            <th class="sorting" tabindex="0"
                                                                aria-controls="m_table_1"
                                                                rowspan="1" colspan="1"
                                                                style="width: 65.25px;"
                                                                aria-label="Country: activate to sort column ascending">
                                                                الكميه</th>
                                                            <th class="sorting" tabindex="0"
                                                                aria-controls="m_table_1"
                                                                rowspan="1" colspan="1"
                                                                style="width: 100.25px;"
                                                                aria-label="Ship Address: activate to sort column ascending">
                                                                طريقه الشحن</th>
                                                            <th class="sorting" tabindex="0"
                                                                aria-controls="m_table_1"
                                                                rowspan="1" colspan="1"
                                                                style="width: 82.25px;"
                                                                aria-label="Company Agent: activate to sort column ascending">
                                                                طريقه الدفع</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="m-accordion__item">
                            <div class="m-accordion__item-head show" role="tab"
                                 id="m_accordion_2_item_3_head" data-toggle="collapse"
                                 href="#m_accordion_2_item_3_body" aria-expanded="false">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-coins"></i></span>
                                <span class="m-accordion__item-title">التكلفه</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body show" id="m_accordion_2_item_3_body"
                                 role="tabpanel" aria-labelledby="m_accordion_2_item_3_head"
                                 data-parent="#m_accordion_2">
                                <div class="m-accordion__item-content">

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td> <label>التكلفة :</label>
                                                <label id="productCost">0</label>
                                                <input type="hidden" value=""
                                                       id="productCost_hidden" name="productCost">
                                            </td>
                                            <td> <label>تكلفة الشحن :</label>
                                                <label id="TransferCost">0</label>
                                                <input type="hidden" value=""
                                                       id="TransferCost_hidden" name="TransferCost">
                                            </td>
                                            <td> <label>الخصم :</label>
                                                <label id="DiscountValue">0</label>
                                                <input type="hidden" value=""
                                                       id="DiscountValue_hidden" name="DiscountValue">
                                            </td>
                                            <td> <label>الاجمالى :</label>
                                                <label id="Total">0</label>
                                                <input type="hidden" value="" id="Total_hidden"
                                                       name="Total">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">
                                            تاريخ</label>
                                        <div class="col-lg-8 col-md-4 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text" name="date"
                                                       class="form-control DatebakerInput"
                                                       id="m_datetimepicker_6"
                                                       value="<?php echo date("Y-m-d")?>" id="date"
                                                       data-format="yyyy-mm-dd">

                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-calendar glyphicon-th"></i>
                                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-3 col-sm-12">الوقت</label>
                                        <div class="col-lg-8 col-md-9 col-sm-12">
                                            <div class="input-group date">

                                                <input type="text" name="time"
                                                       class="form-control m-input timebakerInput1" id="dates"

                                                       data-template="dropdown" data-show-seconds="true"
                                                       data-show-meridian="false" data-minute-step="5"
                                                       data-second-step="5" >

                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-time glyphicon-th"></i>
                                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-lg-3">تعليق :</label>
                                            <div class="col-lg-8">
                                                                <textarea class="form-control estext w-100 ckeditor"  rows="7"
                                                                          id="comment" name="comment"></textarea>

                                                <input type="hidden" name="callStatus" id="callStatus"
                                                       value="0">
                                                <input type="hidden" class="CallID" name="callID"
                                                       value="0">
                                                <input type="hidden" class="IsCall" name="IsCall"
                                                       value="0">
                                                <input class="btn btn-info btn-md mb-3 w-25 mt-4 float-right"
                                                       type="submit" value="تم">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Item-->
                </div>

                <!--end::Section-->
            </div>
        </div>
    </div>
</div>
<!--اضافه-->

<!--تعديل-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  تعديل </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo $url."ClientOrders/UpdateOrderData"?>">
                <input type="hidden" value="" name="DetailsID" id="DetailsID">
                <input type="hidden" value="<?= $Order_ID?>" name="OrderID">
                <div class="modal-body">
                    <div class="EDIT">
                        <div class="form-group">
                            <label class="col-lg-3">الاسم</label>
                            <div class="col-lg-12">
                                <label id="itemName"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3">الكميه</label>
                            <div class="col-lg-12">
                                <input type="number" name="Quantity" id="Quantity" class="form-control">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">طريقه الشحن</label>
                            <div class="col-lg-12">
                                <select class="form-control" name="truckType" id="truckType">
                                    <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                        <option
                                                value="<?php echo $trucks[$i]->transfer_ID?>"
                                                cost="<?php echo $trucks[$i]->Price?>">
                                            <?php echo $trucks[$i]->transfer_Name?>
                                        </option>
                                    <?php }  }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">طريقه الدفع</label>
                            <div class="col-lg-12">
                                <select class="form-control" name="PaymentType" id="PaymentType">
                                    <?php  if(isset($PaymentTypes)){ for($i=0;$i<count($PaymentTypes);$i++){?>
                                        <option
                                                value="<?php echo $PaymentTypes[$i]->ID?>">
                                            <?php echo $PaymentTypes[$i]->Name?>
                                        </option>
                                    <?php }  }?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"> حفظ </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> غلق </button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--تعديل-->





<script>

    $(".deleteOrder").click(function () {
        let conf = confirm('هل انت متاكد من عملية الحذف ؟');
        if (conf){
            var ID = $(this).attr("uintID");
            var Order = $(this).attr("orderID");
            var client = $(this).attr("clientID");
            if (ID > 0){
                $.ajax({
                    type: "POST",
                    url: base + "ClientOrders/Delete",
                    data: ({
                        unitID: ID,
                        OrderID :Order,
                        clientID:client
                    }),
                    success: function (data) {
                        if (data == 0) {
                            toastr.error("حدث خطأ");
                        } else if (data == 1) {
                            toastr.success("تم الحذف بنجاح");
                            document.location.reload();
                        }else if (data == 2) {
                            location.href=base + "Client/Details/"+client;
                        }



                    }
                });
            }
        }
    });


    $("#OrderTable").DataTable({
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
    })



    var Neworderchangetype = function (type) {
        document.getElementById("selectServiceandProudct").innerHTML = "";
        document.getElementById("selectServiceandProudct").textContent = "";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("selectServiceandProudct").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type=" + type, true);
        xhttp.send();
    };



</script>

<script>

    $("#EditOrder").click(function () {
        var ID = $(this).attr("uintID");
        $.ajax({
            type: "POST",
            url: base + "ClientOrders/GetOrderData",
            data: ({
                unitID: ID
            }),
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.error == 0) {

                    $("#itemName").text(result.data['Product_Name']);
                    $("#Quantity").val(result.data['Quantity']);
                    $("#truckType").val(result.data['Transfer_ID']);
                    $("#PaymentType").val(result.data['Payment_ID']);
                    $("#DetailsID").val(result.data['ID']);
                }
            }
        });

    });






    var orderTable = $("#OrderItems").DataTable({
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

    //AddOrder
    $("#AddOrder").click(function () {

        var name = $("#selectServiceandProudct option:selected").text();
        var quantity = $("#quantity").val();
        var transferType = $("#transferType option:selected").text();
        var paymentType =$("#paymentType option:selected").text();
        var oldtransferCost = parseInt($("#TransferCost").text(),0);
        var oldproductCost = parseInt($("#productCost").text(),0);
        var olddiscount = parseInt($("#DiscountValue").text(),0);
        var transferCost = $("#transferType option:selected").attr("cost");
        var productCost = $("#selectServiceandProudct option:selected").attr("cost");
        var transfer = $("#transferType option:selected").val();
        var payment = $("#paymentType option:selected").val();
        var nameIndex = $("#selectServiceandProudct option:selected").val();

        var truckCost =  parseInt($("#truckCost").val(),0);
        var tcost = 0;
        if (truckCost == 0){
            tcost = transferCost*1;
        }else {
            tcost = truckCost;
        }
        var pcost = productCost*quantity;
        var newProductCost =oldproductCost+pcost ;
        var newtransferCost=oldtransferCost+tcost;
        var discount = 0;
        var discountValue = parseInt($("#discount").val(),0);
        var discountType = $("#discountType option:selected").val();
        if (discountValue > 0){
            if (discountType == 0){
                discount = (discountValue/100) * pcost;
            }else{
                discount = discountValue;
            }

        }
        if  (quantity <=0){
            alert("الكمية لا يمكن ان تكون " + quantity);
        }else{
            $("#productCost").html(newProductCost);
            $("#TransferCost").html(newtransferCost);
            $("#Total").html((newProductCost - (discount+olddiscount)) + newtransferCost);
            $("#DiscountValue").html( discount+olddiscount);

            $("#productCost_hidden").val(newProductCost);
            $("#TransferCost_hidden").val(newtransferCost);
            $("#Total_hidden").val((newProductCost - (discount+olddiscount)) + newtransferCost);
            $("#DiscountValue_hidden").val(discount+olddiscount);
            var row = new Array(
                "<input type='text' name='names[]' hidden value= '" + nameIndex + "'><label>" + name.trim() + "</label> ",
                "<input type='text' name='quantity[]' hidden value= '" + quantity.trim() + "'><label>" + quantity.trim() + "</label>",
                "<input type='text' name='transferType[]' hidden value= '" + transfer + "'><label>" + transferType.trim() +"</label>",
                "<input type='text' name='paymentType[]' hidden value= '" + payment + "'><label>" + paymentType.trim() + "</label>",
                "<button class='btn btn-danger btn-sm' style='font-weight: bold' discount = '"+discount+"' TransferCost = '"+tcost+"' productCost = '"+pcost+"'>حذف</button>"
            );
            orderTable.row.add(row).draw(false);
        }
    });

    $('#OrderItems tbody').on( 'click', 'button', function () {
        var result = confirm("هل انت متاكد ؟");
        if (result) {
            var row = orderTable.row($(this).parents('tr'));
            row.remove();
            orderTable.draw();
            // Get Old Values
            var productCost =  parseInt($("#productCost").text(),0);
            var TransferCost = parseInt($("#TransferCost").text(),0);
            var DiscountValue  = parseInt($("#DiscountValue").text(),0);
            // Set New Valuse
            productCost = productCost - parseInt($(this).attr('productCost'),0)
            TransferCost = TransferCost - parseInt($(this).attr('TransferCost'),0)
            DiscountValue = DiscountValue - parseInt($(this).attr('discount'),0)
            var total = productCost + TransferCost - DiscountValue;
            $("#productCost").html(productCost);
            $("#TransferCost").html(TransferCost);
            $("#Total").html(total);
            $("#DiscountValue").html(DiscountValue);
        }
    } );
</script>

</body>

</html>