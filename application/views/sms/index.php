<?php $this->load->view("header");?>
<?php
$per = get_premissions($_SESSION['userid'],"07");
?>

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body" style="margin-top:-2%;">
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



                                <button class="btn btn-info m-btn--icon mr-2" data-toggle="modal"
                                        data-target="#exampleModal">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>إرسال رسالة نصية</span>
                                    </span>
                                </button>

                                <?php
                                if( $_SESSION["usertype"] == 1 || $per==1){?>
                                    <button class="btn btn-danger m-btn--icon mr-3" id="remove_All">
                                    <span>
                                        <i class="flaticon-delete"></i>
                                        <span> حذف الكل</span>
                                    </span>
                                    </button>

                                <?php }
                                ?>




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

                                </th>
                            <?php } ?>
                            <th style="width: 100px;">اسم الموظف</th>
                            <th style="width: 100px;">اسم العميل</th>
                            <th>رقم التليفون</th>
                            <th>نص الرسالة</th>
                            <th>التاريخ</th>
                            <th>نوع الموظف</th>
                            <?php  if ($_SESSION['usertype'] == 1 || $per==1){?>
                                <th style="width: 100px">العلميات</th>
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
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <?php $Image = get_Emp_ProfileImage($smsList[$i]->UserID); ?>
                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">


                                        </div>

                                        <div class="col-lg-8">
                                            <p class="text-left">
                                                <?php echo $smsList[$i]->Name ?>
                                            </p>
                                        </div>
                                    </div>

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
                                        <a href="<?=$url."SMS/details/".$smsList[$i]->ID?>" class="btn btn-outline-info"> تفاصيل </a>
                                        <button style="cursor: pointer" class="btn btn-outline-danger deleteData"
                                                smsID="<?php echo $smsList[$i]->ID?>"> حذف </button>

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
                            <textarea class="form-control" id="smsContent"></textarea>
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
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = element.checked;
        });
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
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf){
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
        }
    });
</script>

</body>

</html>