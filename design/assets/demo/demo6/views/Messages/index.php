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
                                                <textarea name="content" id="content" cols="70" rows="7" class="form-control"></textarea>
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
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body tabs_border">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab"> <i class="flaticon-reply"></i>المرسلة</a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab"><i class="flaticon-file ml-2"></i>المستقبلة</a>
                                </li>
                                <?php
                                if ($_SESSION['usertype'] == 1 || $per == 1){?>

                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4" role="tab"><i class="flaticon-chat-1"></i>المتداولة</a>
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
                                          <th></th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-multimedia-2"></i> </th>

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
                                            for($i=0;$i<count($sent);$i++){



                                                ?>
                                                <tr class="unread" >
                                                    <td><i class="flaticon-multimedia"></i></td>
                                                    <td class="col-name">
                                                        <a class="col-name">

                                                            <?php echo get_Emp_name($sent[$i]->From_User,1).get_Emp_role($sent[$i]->From_User)?></a>
                                                    </td>
                                                    <td class="col-subject">
                                                        <a>
                                                            <?php
                                                            if($sent[$i]->To_User==0){

                                                                echo get_Emp_name($sent[$i]->To_User,2).get_Emp_role($sent[$i]->To_User);
                                                            }
                                                            else
                                                            {
                                                                echo get_Emp_name($sent[$i]->To_User,1).get_Emp_role($sent[$i]->To_User);
                                                            }
                                                            ?>
                                                        </a>
                                                    </td>
                                                    <td class="col-subject">
                                                        <a>
                                                            <?php echo $sent[$i]->Titel?>
                                                        </a>
                                                    </td>





                                                    <td class="mt-3">
                                                        <p class="mt-3">
                                                          

                                                            <a href="<?php echo $url.'CRM_Messages/message_details/'.$sent[$i]->ID?>" class="mr-1">
                                                                <span class="ml-2"></span>
                                                                <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="تفاصيل"></i>

                                                            </a>
                                                            <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $sent[$i]->ID?>">
                                                                <span></span>
                                                                <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
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
                                            <th></th>
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
                                                    <a class="col-name">
                                                        <?php echo get_Emp_name($received[$i]->From_User,1).get_Emp_role($received[$i]->From_User)?></a>
                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php
                                                        if($received[$i]->To_User==0){

                                                            echo get_Emp_name($received[$i]->To_User,2).get_Emp_role($received[$i]->To_User);
                                                        }
                                                        else
                                                        {
                                                            echo get_Emp_name($received[$i]->To_User,1).get_Emp_role($received[$i]->To_User);
                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php echo $received[$i]->Titel?>
                                                    </a>
                                                </td>


                                                <td class="mt-3">
                                                    <p class="mt-3">
                                                    <a href="<?php echo $url.'CRM_Messages/message_details/'.$received[$i]->ID?>" class="mr-1">
                                                            <span class="ml-2"></span>
                                                            <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="تفاصيل"></i>
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $received[$i]->ID?>">
                                                            <span></span>
                                                            <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
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
                                            <th></th>
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
                                                <td>

                                                    <?php
                                                    if ($Circulated[$i]->Admin_Seen == 1){?>
                                                        <i class="fa fa-envelope-open" style="color: #ff69b4;" aria-hidden="true"></i>
                                                    <?php }else{?>
                                                        <i class="fa fa-envelope"  style="color: #ff6347;"  aria-hidden="true"></i>
                                                    <?php }

                                                    ?>
                                                    <!--                                            <i class="fa fa-envelope-open" aria-hidden="true"></i>-->

                                                </td>
                                                <td class="col-name">
                                                    <a class="col-name">
                                                        <?php echo get_Emp_name($Circulated[$i]->From_User,1).get_Emp_role($Circulated[$i]->From_User)?></a>
                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php
                                                        if($Circulated[$i]->To_User==0){

                                                            echo get_Emp_name($Circulated[$i]->To_User,2).get_Emp_role($Circulated[$i]->To_User);
                                                        }
                                                        else
                                                        {
                                                            echo get_Emp_name($Circulated[$i]->To_User,1).get_Emp_role($Circulated[$i]->To_User);
                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                                <td class="col-subject">
                                                    <a>
                                                        <?php echo $Circulated[$i]->Titel?>
                                                    </a>
                                                </td>


                                                <td class="mt-3">
                                                    <p class="mt-3">
                                                        

                                                        <a href="<?php echo $url.'CRM_Messages/message_details/'.$Circulated[$i]->ID?>" class="mr-1">
                                                            <span class="ml-2"></span>
                                                            <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="تفاصيل"></i>
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $Circulated[$i]->ID?>">
                                                            <span></span>
                                                            <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
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



    $(".btn-sm").click(function(){
        // debugger;

        var type = $(this).siblings('.type').val();

        var y= confirm("  هل انت متاكد من عمليه الحذف ");
        if(y==true)
        {
            var status=$(this).attr("mess");
            var base=$("#base").val();
            var element=$(this);
            $.ajax({
                type: "POST",
                url: base+"CRM_Messages/DeleteInstruction",
                data: ({messid:status,
                    type:type
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