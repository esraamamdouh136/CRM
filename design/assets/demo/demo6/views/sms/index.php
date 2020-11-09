<?php $this->load->view("header");?>
<?php
$per = get_premissions($_SESSION['userid'],"07");
?>
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body" style="margin-bottom:5%;">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="col-12">
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                الرسائل النصيه
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">

                                <?php
                                if( $_SESSION["usertype"] == 1 || $per==1){?>
                                    <a href="#" onclick="return false;" class="btn btn-danger m-btn--icon mr-3" id="remove_All">
                                    <span>
                                        <i class="flaticon-delete"></i>
                                        <span> حذف الكل</span>
                                    </span>
                                    </a>

                                <?php }
                                ?>



                                <a href="#" onclick="return false;" class="btn btn-info m-btn--icon" data-toggle="modal"
                                   data-target="#exampleModal">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>إرسال رسالة نصية</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-portlet__body-progress">Loading</div>
                    <!--begin: Datatable -->
                    <table class="table m-table" id="example" width="100%">
                        <thead>
                        <tr>
                            <?php  if ($_SESSION['usertype'] == 1 || $per==1){?>
                                <th class="sorting_asc" tabindex="0" aria-controls="m_table_1"
                                    rowspan="1" colspan="1" style="width: 30px;background: none" aria-sort="ascending"
                                    aria-label=" name="first"

                                                            : activate to sort column descending">
                                <input type="checkbox" id="selectall" class="clncheckAll">
                            <?php } ?>
                            </th>
                            <th>اسم الموظف</th>
                            <th>اسم العميل</th>
                            <th>رقم التليفون</th>
                            <th>نص الرسالة</th>
                            <th>التاريخ</th>
                            <th>نوع الموظف</th>
                            <?php  if ($_SESSION['usertype'] == 1 || $per==1){?>
                                <th>العلميات</th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>


                        <?php if(isset($smsList)){ for($i=0;$i<count($smsList);$i++){

                            ?>
                            <tr>
                                <?php  if ($_SESSION['usertype'] == 1 || $per==1){?>
                                    <td class="checkable-td">
                                        <input type="checkbox" smsID="<?php echo $smsList[$i]->ID?>" class="checkboxMy
                              <?php echo 'chk elem'.$i?>">

                                    </td>
                                <?php }?>
                                <td>
                                    <?php echo $smsList[$i]->Name ?>
                                </td>

                                <td>
                                    <?php echo $smsList[$i]->customerCrmName?>
                                </td>
                                <td>
                                    <?php echo $smsList[$i]->Phone?>
                                </td>
                                <td>
                                    <?php echo $smsList[$i]->MessageText?>
                                </td>
                                <td>
                                    <?php echo $smsList[$i]->Date?>
                                </td>

                                <td>
                                    <?php if ($smsList[$i]->Type==1){
                                        echo "مدير";
                                    }else if ($smsList[$i]->Type==2){
                                        echo "مشرف";
                                    }else{
                                        echo "موظف";
                                    }?>

                                </td>

                                <?php
                                if ($_SESSION['usertype'] == 1 || $per==1){?>
                                    <td>

                                        <i style="cursor: pointer" class="deleteData flaticon flaticon-delete btn-sm"
                                           smsID="<?php echo $smsList[$i]->ID?>"></i>
                                    </td>
                                <?php  }
                                ?>

                            </tr>
                            <?php
                        }
                        }?>


                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>


    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ارسال رساله </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group m-form__group row">
                        <label for="example-time-input" class="col-lg-12 col-form-label"> رقم التليفون </label>
                        <div class="col-lg-12">
                            <input class="form-control m-input" type="text" value="" id="phoneNum">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-time-input" class="col-lg-12 col-form-label"> نص الرساله </label>
                        <div class="col-lg-12">
                            <textarea cols="60" rows="5" id="smsContent"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="sendSMS" class="btn btn-info"> ارسال </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
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
    });



    $("#remove_All").click(function(){
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf){
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
        if (smsids.length > 0) {
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
                alert("تم المسح بنجاح");
                window.location.reload();
            }else{
                alert("حدث مشكلة اثناء عملية المسح");
            }
        }else {
            alert("برجاء إختيار الرسائل المراد حذفها");
        }
        }

    });





    $("#sendSMS").click(function () {
        var phonenum = $("#phoneNum").val();
        var msg = $("#smsContent").val();

        $.ajax({
            type: "POST",
            url: base + "SMS/SendSMS",
            data: ({
                phone: phonenum,
                message: msg
            }),
            success: function (data) {
                var result = jQuery.parseJSON(data);
                if (result.errorCode == 0) {
                    alert("تم إرسال الرسالة بنجاح");
                    document.location.reload();
                } else
                    alert(result.message);
            }
        });
    });




    $(".deleteData").click(function () {
        var base = $("#base").val();
        var smsID = $(this).attr("smsID");
        $.ajax({
            type: "POST",
            url: base + "SMS/deleteSMS",
            data: ({
                id: smsID
            }),
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.error == 0) {
                    alert(result.message);
                    window.location.reload();
                } else {
                    alert(result.message);
                }
            }
        });
    });
</script>

</body>

</html>