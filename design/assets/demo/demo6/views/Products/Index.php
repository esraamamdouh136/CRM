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
                                        <a data-toggle="modal" data-target="#AddProduct" class="btn btn-info m-btn--icon">
                                            <span style="color:white;">
                                                <i class="la la-plus"></i>
                                                <span>  منتج & خدمه جديده</span>
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
                                                        اسم المنتج </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 65.25px;" aria-label="Country: activate to sort column ascending">
                                                        السعر</th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">
                                                        الوصف </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">
                                                        الغاء الحجز </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">
                                                        عمليات </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php

                                                if(isset($products)){ for($i=0;$i<count($products);$i++){?>
                                                    <tr protype="1" class="unread"  ><!-- new email class: unread -->

                                                        <td class="col-name pname">
                                                            <?php echo $products[$i]->Product_Name?>
                                                        </td>
                                                        <td class="pprice">
                                                            <?php echo $products[$i]->Price?>
                                                        </td>
                                                        <td class="col-subject pdesc">
                                                            <?php echo $products[$i]->Description?>
                                                        </td>
                                                        <td class="col-subject pcancel">
                                                            <?php echo $products[$i]->Cancel_IN." ايام  "?>
                                                        </td>
                                                        <td class="col-subject">
                                                            <a data-toggle="modal" data-target="#EditProduct" productId="<?php echo $products[$i]->Product_ID?>" class="btn btn-blue btn-sm icon-left EditProduct">
                                                                <i class="flaticon flaticon-edit"></i>
                                                                تعديل</a>
                                                            <button class="btn btn-danger deleteProduct" productId="<?php echo $products[$i]->Product_ID?>">
                                                                <i class="flaticon flaticon-delete"></i>مسح
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

                        <div class="m-portlet__body">

                            <!--begin: Datatable -->
                            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table m-table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="example-2" role="grid" aria-describedby="m_table_1_info" style="width: 974px;">
                                                <thead>

                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 63.25px;" aria-label="Order ID: activate to sort column ascending">
                                                        اسم الخدمة </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 65.25px;" aria-label="Country: activate to sort column ascending">
                                                        السعر</th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">
                                                        الوصف </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">
                                                        الغاء الحجز </th>
                                                    <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">
                                                        عمليات </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(isset($meto))
                                                {
                                                    print_r($meto);
                                                }
                                                if(isset($services)){ for($i=0;$i<count($services);$i++){?>
                                                    <tr protype="2" class="unread" >

                                                        <td class="col-name pname">
                                                            <?php echo $services[$i]->Product_Name?>
                                                        </td>
                                                        <td class="pprice">
                                                            <?php echo $services[$i]->Price?>
                                                        </td>
                                                        <td class="col-subject pdesc">
                                                            <?php echo $services[$i]->Description?>
                                                        </td>
                                                        <td class="col-subject pcancel">
                                                            <?php echo $services[$i]->Cancel_IN." ايام  "?>
                                                        </td>
                                                        <td class="col-subject">
                                                            <a data-toggle="modal" data-target="#EditProduct" productId="<?php echo $services[$i]->Product_ID?>" class="btn btn-blue btn-sm icon-left EditProduct">
                                                                <i class="flaticon flaticon-edit"></i>
                                                                تعديل</a>
                                                            <button class="btn btn-danger deleteProduct" productId="<?php echo $services[$i]->Product_ID?>">
                                                                <i class="flaticon flaticon-delete"></i>مسح
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


<!-- Modal_1 -->
<div class="modal fade" id="AddProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> المنتجات&الخدمات : اضافه</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'Products/create'); ?>
                <div class="form-row">
                    <label> اسم منتج </label>
                    <input type="text" name="ProductName" class="form-control" placeholder="إسم المنتج / الخدمه" required>
                </div>
                <div class="form-row my-3">
                    <label> النوع </label>
                    <div class="col-lg-12 col-sm-12">
                        <select class="form-control select2-static"  name="ProductType">
                            <option value="1">منتج</option>
                            <option value="2">خدمة</option>
                        </select>
                    </div>
                </div>
                <div class="form-row my-3">
                    <label> السعر </label>
                    <input type="number" class="form-control" min="0" value="0" name="ProductPrice" placeholder="السعر" required>
                </div>

                <div class="form-row my-3">
                    <label> ( بالايام)الغاء الحجز خلال  </label>
                    <input type="number" class="form-control" min="0" value="0" name="CancelIn" placeholder="إلغاء الحجز خلال" >
                </div>

                <div class="form-row">
                    <label> الوصف </label>
                    <textarea  name="ProductDescription" class="form-control" placeholder="الوصف" cols="30" rows="5" ></textarea>
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
<!--modal_1 -->


<!-- Modal_2 -->
<div class="modal fade" id="EditProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> المنتجات&الخدمات : اضافه</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'Products/updateData'); ?>
                <input type="hidden" name="productID" id="productID" value="0">
                <div class="form-row">
                    <label> اسم منتج </label>
                    <input type="text" name="ProductName" id="ProductName" class="form-control" placeholder="إسم المنتج / الخدمه" >
                </div>
                <div class="form-row my-3">
                    <label> النوع </label>
                    <div class="col-lg-12 col-sm-12">
                        <select class="form-control select2-static"  name="ProductType" id="ProductType">
                            <option value="1">منتج</option>
                            <option value="2">خدمة</option>
                        </select>
                    </div>
                </div>
                <div class="form-row my-3">
                    <label> السعر </label>
                    <input type="number" class="form-control" min="0" value="0" name="ProductPrice" id="ProductPrice" placeholder="السعر" >
                </div>

                <div class="form-row my-3">
                    <label> ( بالايام)الغاء الحجز خلال  </label>
                    <input type="number" class="form-control" min="0" value="0" name="CancelIn" id="CancelIn" placeholder="إلغاء الحجز خلال" >
                </div>

                <div class="form-row">
                    <label> الوصف </label>
                    <textarea  name="ProductDescription" id="ProductDescription" class="form-control" placeholder="الوصف" cols="30" rows="5" ></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info esbutton" value="حفظ">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>

            </div>
            </form>
        </div>
    </div>
</div>
<!--modal_2 -->











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


    $(".deleteProduct").click(function () {

        var productId = $(this).attr("productId");
        var base = $("#base").val();
        $.ajax({
            type: "POST",
            url: base + "Products/delete",
            data: ({
                ID: productId
            }),
            success: function (data) {
                if (data == 1) {
                    alert("تم المسح بنجاح");
                    location.reload();
                } else {
                    alert("حدث خطأ");
                }

            }
        });

    });
    $(".EditProduct").click(function () {
        var productId = $(this).attr("productId");
        // load Data
        $.ajax({
            type: "POST",
            url: base + "Products/GetData",
            data: ({
                ID: productId
            }),
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.Error == 0) {

                    $("#CancelIn").val(result.Product['Cancel_IN']);
                    $("#ProductDescription").val(result.Product['Description']);
                    $("#ProductPrice").val(result.Product['Price']);
                    $("#productID").val(result.Product['Product_ID']);
                    $("#ProductName").val(result.Product['Product_Name']);
                    $("#ProductType").val(result.Product['Product_Type']);
                } else {
                    alert("حدث خطأ");
                }
            }
        });
    });

</script>

</body>

</html>
