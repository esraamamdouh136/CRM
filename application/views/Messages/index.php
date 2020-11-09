<?php $this->load->view("header");
$per = get_premissions($_SESSION['userid'],"10");

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%;margin-left: 2%">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">


        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="infoSend" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row-reverse">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="add-label">رسالة جديدة</h4>

                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="error" style="display: none"></div>

                            <form method="post" id="add-package" action="<?php echo $url.'CRM_Messages/sendMessage'?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="mtype" value="1">
                                            <input type="hidden" name="type" value="1" id="messto">
                                            <input type="hidden" name="mfrom" value="<?php echo $_SESSION['userid']?>">
                                            <label for="mto[]">الي</label>
                                            <select name="mto[]" id="select1" class="selectpicker form-control" multiple
                                                    required>
                                                <?php if(isset($emp)) { for($i=0;$i<count($emp);$i++){
                                                    $type="";
                                                    if ($emp[$i]->Type == 1){
                                                        $type="مدير";
                                                    }
                                                    if ($emp[$i]->Type == 2){
                                                        $type="مشرف";
                                                    }
                                                    if ($emp[$i]->Type == 3){
                                                        $type="موظف";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $emp[$i]->ID?>">
                                                        <?php echo $emp[$i]->Name." (".$type.") "?>
                                                    </option>
                                                <?php } }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group ">
                                            <label for="source_type">العنوان</label>
                                            <input class="form-control" name="title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group add-only">
                                            <label for="source_id">الموضوع</label>
                                            <div class="col-lg-12 col-md-9 col-sm-12">
                                                <textarea name="content" id="content" cols="70" rows="7" class="form-control ckeditor"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info submit-form">ارسال</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        الرسائل الداخلية
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="#" onclick="return false;" id="opener2"
                                           class="btn btn-info m-btn--icon " data-toggle="modal"
                                           data-target="#infoSend">
														<span>
															<i class="la la-plus"></i>
															<span> تعليمات جديدة</span>
														</span>
                                        </a>
                                        <button class="btn btn-danger m-btn--icon ml-2" id="remove_All">
                                    <span>
                                        <i class="flaticon-delete"></i>
                                        <span> حذف الكل</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body tabs_border">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active unchick" data-toggle="tab" href="#m_tabs_6_1" role="tab"> <i class="flaticon-reply"></i>المرسلة</a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link unchick" data-toggle="tab" href="#m_tabs_6_3" role="tab"><i class="flaticon-file ml-2"></i>المستقبلة</a>
                                </li>
                                <?php
                                if ($_SESSION['usertype'] == 1 || $per == 1){?>

                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link unchick" data-toggle="tab" href="#m_tabs_6_4" role="tab"><i class="flaticon-chat-1"></i>المتداولة</a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                    <table class="table m-table" id="example_1">
                                        <thead>
                                        <tr>
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;background: none" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox"  class="clncheckAll selectallsent">
                                            </th>
                                            <th><i class="flaticon-multimedia"></i></th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-home"></i> </th>

                                            <th style="width: 150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($sent)){
                                            for($i=0;$i<count($sent);$i++){ ?>
                                                <tr class="unread" >
                                                    <td class="checkable-td sorting_1">
                                                        <input mssID="<?php echo $sent[$i]->ID ?>" type="checkbox" class="checkboxMy chk elem1 sent">
                                                        <input type="hidden" class="dataID custid1" value="101">
                                                    </td>
                                                    <td><i class="flaticon-multimedia"></i></td>
                                                    <td class="col-name">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <?php $Image = get_Emp_ProfileImage($sent[$i]->FromUser); ?>
                                                                <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">


                                                            </div>
                                                            <div class="col-lg-8">
                                                                <p class="col-name text-left pt-4">

                                                                    <?php echo get_Emp_name($sent[$i]->FromUser,1).get_Emp_role($sent[$i]->FromUser)?></p>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td class="col-subject">

                                                        <?php
                                                        echo $sent[$i]->ToUsers;

                                                        ?>

                                                    </td>
                                                    <td class="col-subject">
                                                        <a>
                                                            <?php echo $sent[$i]->Titel?>
                                                        </a>
                                                    </td>
                                                    <td class="mt-3">
                                                        <p class="mt-3">


                                                            <a href="<?php echo $url.'CRM_Messages/message_details/'.$sent[$i]->ID?>" class="mr-1 btn btn-outline-info" role="button">
                                                                   تفاصيل

                                                            </a>
                                                            <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $sent[$i]->ID?>">
                                                                <span></span>
                                                                <button class="btn btn-outline-danger" data-toggle="tooltip"> حذف  </button>
                                                            </a>
                                                            <input type="hidden" value="1" class="type">
                                                        </p>
                                                    </td>
                                                </tr>
                                            <?php } }?>


                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                    <table class="table m-table" id="example_2">
                                        <thead>
                                        <tr>
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;background: none" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox"  class="clncheckAll selectallreceived">
                                            </th>
                                            <th style="width: 50px;"><i class="fa fa-envelope"  aria-hidden="true"></i></th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-multimedia-2"></i> </th>
                                            <th style="width: 150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(isset($received)){ for($i=0;$i<count($received);$i++){?>
                                            <tr class="unread" >
                                                <!-- new email class: unread -->

                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem1 received" mssID = "<?= $received[$i]->ID ?>">
                                                    <input type="hidden" class="dataID custid1" value="101">
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($received[$i]->Is_Seen == 1){?>
                                                        <i class="fa fa-envelope-open" style="color: #ff69b4;" aria-hidden="true"></i>
                                                    <?php }else{?>
                                                        <i class="fa fa-envelope"  style="color: #ff6347;"  aria-hidden="true"></i>
                                                    <?php }

                                                    ?>
                                                </td>
                                                <td class="col-name">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($received[$i]->FromUser); ?>
                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">

                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="col-name text-left pt-4">
                                                                <?php echo get_Emp_name($received[$i]->FromUser,1).get_Emp_role($received[$i]->FromUser)?></p>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="col-subject">
                                                    <?php
                                                    echo $received[$i]->ToUsers;

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php echo $received[$i]->Titel?>
                                                    </a>
                                                </td>


                                                <td class="mt-3">
                                                    <p class="mt-3">
                                                        <a href="<?php echo $url.'CRM_Messages/message_details/'.$received[$i]->ID?>" class="mr-1 btn btn-outline-info" role="button">
                                                             تفاصيل
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $received[$i]->ID?>">
                                                            <span></span>
                                                            <button class="btn btn-outline-danger">حذف</button>
                                                        </a>


                                                        <input type="hidden" value="2" class="type">
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php } }?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
                                    <table class="table m-table" id="example_3">
                                        <thead>
                                        <tr>
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;background: none" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox"  class="clncheckAll selectallCirculated">
                                            </th>

                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-multimedia-2"></i> </th>
                                            <th style="width: 150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($Circulated)){ for($i=0;$i<count($Circulated);$i++){?>
                                            <tr class="unread" >
                                                <!-- new email class: unread -->
                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem102 Circulated" mssID = "<?= $Circulated[$i]->ID ?>">

                                                </td>

                                                <td class="col-name">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php
                                                            $Image = get_Emp_ProfileImage($Circulated[$i]->FromUser,1);
                                                            ?>
                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image : "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-lg-8">

                                                            <p class="col-name text-left pt-4">
                                                                <?php echo get_Emp_name($Circulated[$i]->FromUser,1).get_Emp_role($Circulated[$i]->FromUser)?></p>
                                                        </div>
                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    echo $Circulated[$i]->ToUsers;

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php echo $Circulated[$i]->Titel?>
                                                    </a>
                                                </td>


                                                <td class="mt-3">
                                                    <p class="mt-3">


                                                        <a href="<?php echo $url.'CRM_Messages/message_details/'.$Circulated[$i]->ID?>" class="mr-1 btn btn-outline-info" role="button">
                                                             تفاصيل
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $Circulated[$i]->ID?>">
                                                            <span></span>
                                                            <button class="btn btn-outline-danger"> حذف </button>
                                                        </a>

                                                    </p>
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







<script>
    $(document).ready(function () {
        $("table[id^='example']").DataTable( {
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
    });


    $(".selectallsent").change(function () {
        $(this).find().parent();
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = false;
        });
        $(':checkbox.sent').each(function() {
            this.checked = element.checked;

        });
    });
    $(".selectallreceived").change(function () {
        $(this).find().parent();
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = false;
        });
        $(':checkbox.received').each(function() {
            this.checked = element.checked;
        });
    });
    $(".selectallCirculated").change(function () {
        $(this).find().parent();
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = false;
        });
        $(':checkbox.Circulated').each(function() {
            this.checked = element.checked;
        });
    });

    $("#remove_All").click (function () {
        var coun = 0;
        var y= confirm("هل انت متاكد من عملية الحذف ؟");
        if(y==true) {
            $(':checkbox.checkboxMy').each(function () {
                if ($(this).is(":checked")) {
                    coun++;
                    var status=$(this).attr("mssID");
                    var base=$("#base").val();
                    $.ajax({
                        type: "POST",
                        url: base+"CRM_Messages/DeleteInstruction",
                        data: ({messid:status
                        }),
                        success: function(data) {
                        }
                    });
                }
            });
            if (coun > 0){
                alert("تم المسح  بنجاح");
                document.location.reload();
            }else{
                alert("برجاء إختيار العناصر المراد حذفها");
            }
        }
    });



    $(".unchick").click(function () {
        $(':checkbox.checkboxMy').each(function() {
            this.checked = false;
        });
        $(':checkbox.selectall').each(function() {
            this.checked = false;
        });
    });







    $(".btn-sm").click(function(){
        // debugger;
        var y= confirm("هل انت متاكد من عملية الحذف ؟");
        if(y==true)
        {
            var status=$(this).attr("mess");
            var base=$("#base").val();
            var element=$(this);
            $.ajax({
                type: "POST",
                url: base+"CRM_Messages/DeleteInstruction",
                data: ({messid:status
                }),
                success: function(data) {
                    if (data == 1) {
                        alert("تم المسح  بنجاح");
                        location.reload();

                    }else{
                        alert("حدث خطأ اثناء عملية الحذف");
                    }
                }
            });
        }
    });








    $('input[type=radio][name=optionsRadios]').change(function () {
        var type = 2;
        if (this.value == 'option2') {
            var type = 2;
        } else if (this.value == 'option3') {
            var type = 3;
        }
        var base = $("#base").val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/get_empsuper",
            data: ({
                type: type
            }),
            success: function (data) {
                $('#select1').find('option').remove();

                var products = $.parseJSON(data);
                for (var index = 0; index < products.length; index++) {
                    if (type == 1) {
                        $("#messto").val(1);
                        $('#select1').append($('<option>', {
                            value: products[index].customerCrmId,
                            text: products[index].customerCrmName
                        }));
                    } else {
                        $("#messto").val(2);

                        $('#select1').append($('<option>', {
                            value: products[index].userCrmId,
                            text: products[index].userCrmName
                        }));
                    }
                }

            }
        });
    });





    $(document).on("click", "#send-message", function () {
        var uName = $("#user-mail").val();
        var uPass = $("#user-password").val();
        var portNo = $("#port-number").val();
        var mailServer = $("#mail-server").val();

        var data = new FormData();
        data.append('uName', uName);
        data.append('uPass', uPass);
        data.append('portNo', portNo);
        data.append('mailServer', mailServer);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype: "json",
            url: "<?=$url?>users/update_mail_settings",
            data: data,
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['error'] == false) {
                    toastr.success(Dataarray['msg']);
                } else {
                    toastr.error(Dataarray['msg']);
                }
            }
        });
    });
</script>


</body>

</html>