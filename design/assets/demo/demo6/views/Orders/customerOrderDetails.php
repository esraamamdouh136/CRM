<?php $this->load->view("header");?>
<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->






<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-left: 3%; margin-right:9%; margin-bottom: 12%;">

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
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 100px;" aria-label="الاسم: activate to sort column ascending"> الاسم
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 100px;" aria-label="الاسم: activate to sort column ascending">
                                سعر الوحده </th>
                            <th>الكميه </th>
                            <th>طريقه الشحن </th>
                            <th>طريقه الدفع</th>
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




                            </tr>
                        <?php } }?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
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
</script>



</body>

</html>