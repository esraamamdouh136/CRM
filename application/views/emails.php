<?php  $this->load->view("header");?>


<style>
    span.cke_button_icon.cke_button__smiley_icon {
        display: none;
    }
</style>

<!-- BEGIN: Subheader -->

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin: 3% 8% 0% 2% ;">

    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="newEmail" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row-reverse">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="add-label">ارسال ايميل </h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="error" style="display: none"></div>

                            <form method="post"  onSubmit = "return CheckData(event,this)" action="<?= base_url().'CRM_Mails/sendbulkMailWithAttach'?>" enctype="multipart/form-data">

                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <label for="mto[]">الي</label>
                                                <input type="email" id="SelectWord" class="form-control"  onkeypress="myFunction(event)" >
                                            </div>
                                            <div id="EnterMoreSms"  class="row parentAppend p-2">


                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label for="source_type">العنوان</label>
                                                <input class="form-control" name="title" required id="Mailsubject">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row add-only">
                                                <label for="source_id">الموضوع</label>
                                                <div class="col-lg-12">
                                                    <textarea class="form-control ckeditor" id="Mailcontent" name="Mailcontent"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            إرفاق الملف : <input type="file" id="file[]" accept="application/pdf,image/*" name="file[]" multiple>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="sendMail" class="btn btn-info submit-form">ارسال</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
                                </div>
                            </form>




                        </div>

                    </div>
                </div>
            </div>
            <div class="row ml-0 mr-0 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        الايميلات
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="#" onclick="return false;"
                                           class="btn btn-info m-btn--icon mr-3" data-toggle="modal"
                                           data-target="#newEmail">
														<span>
															<i class="la la-plus"></i>
															<span> ايميل جديد</span>
														</span>

                                        </a>
                                        <button class="btn btn-danger m-btn--icon" id="remove_All">
                                    <span>
                                        <i class="flaticon-delete"></i>
                                        <span> حذف الكل</span>
                                    </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                    <table class="table m-table" id="example">
                                        <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectall">
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 150px;" aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">البريد الإلكترونى<i class="flaticon flaticon-mail"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-home"></i> </th>
                                            <th style="width: 150px;">التاريخ <i class="flaticon flaticon-clock-2"></i></th>
                                            <th style="width: 150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($sent)){ for($i=0;$i<count($sent);$i++){?>
                                            <tr class="unread" >
                                                <td class="checkable-td">
                                                    <input type="checkbox" class="checkboxMy" smsID="<?=$sent[$i]->ID?>" >
                                                </td>
                                                <td class="col-name">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($sent[$i]->UserID); ?>

                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="pt-4 text-left"><?php echo get_Emp_name($sent[$i]->UserID)?></p>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    if(!is_null($sent[$i]->ClientID)){

                                                        echo get_name($sent[$i]->ClientID,2);
                                                    }
                                                    else
                                                    {
                                                        echo "لا يوجد";
                                                    }
                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $sent[$i]->Mail?>
                                                    </a>
                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $sent[$i]->Title?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $sent[$i]->Date?>
                                                </td>
                                                <td class="col-subject">
                                                    <p class="mt-3">
                                                        <a href="<?php echo $url.'CRM_Mails/details/'.$sent[$i]->ID?>" class="mr-1">
                                                            <span class="ml-2"></span>
                                                            <button class="btn btn-outline-info" > تفاصيل </button>
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $sent[$i]->ID?>">
                                                            <span></span>
                                                            <button class="btn btn-outline-danger" > حذف </button>
                                                        </a>
                                                </td>
                                            </tr>
                                        <?php }}?>
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


    function CheckData(e, form){

        var Mails = $('.mailaddress');
        if (Mails.length <= 0){
            alert("برجاء التاكد من البريد الالكترونى");
            e.returnValue = false;
        }

    }

    $(document).ready(function () {
        $("#example").DataTable( {
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
            }]
        })
    });

    $("#selectall").change(function () {
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = element.checked;
        });
    });

    // $("#sendMail").click(function () {
    //
    //     var base = $("#base").val();
    //     var clientid =0;
    //     var subject = $("#Mailsubject").val();
    //     var content = $("#Mailcontent").val();
    //     var mail = $("#mailaddress").val();
    //     $.ajax({
    //         type: "POST",
    //         url: base + "CRM_Mails/sendemail",
    //         data: ({
    //             clientid: clientid,
    //             subject: subject,
    //             content: content,
    //             mail: mail
    //
    //         }),
    //         success: function (data) {
    //             if (data == 0) {
    //                 alert("حدث خطأ");
    //             } else if (data==1) {
    //                 alert("تم إرسال البريد الإلكترونى بنجاح");
    //                 location.reload();
    //             }else if (data == 2){
    //                 alert("برجاء التاكد من إعدادات البريد الإلكترونى");
    //             }
    //
    //
    //         }
    //     });
    // });
    //

    $("#remove_All").click(function(){
        var y= confirm("هل انت متاكد من عمليه الحذف");
        //debugger;
        if (y==true){
            var smsids=[];
            var count = 0;
            var selectAll = $(".checkboxMy").toArray();
            for (var x=0; x < selectAll.length; x++){
                if(selectAll[x].checked){
                    smsids[count] = $(selectAll[x]).attr("smsID");
                    count++;
                }
            }
            //  alert(smsids);
            if (smsids.length > 0) {
                $.ajax({
                    type: "POST",
                    url: base + "CRM_Mails/deleteMail",
                    data: ({
                        id: smsids
                    }),
                    success: function (data) {

                        if (data == 0) {
                            alert("تم المسح بنجاح");
                            window.location.reload();

                        } else {
                            alert("حدث مشكلة اثناء عملية المسح");
                        }
                    }
                });
            }else {
                alert("برجاء إختيار الرسائل المراد حذفها");
            }
        }

    });
    $(".btn-sm").click(function(){

        var y= confirm("Are you Sure");
        if(y==true)
        {
            var status=$(this).attr("mess");
            var base=$("#base").val();
            var element=$(this);
            $.ajax({
                type: "POST",
                url: base+"CRM_Mails/DeleteSMail",
                data: ({messid:status
                }),
                success: function(data) {
                    if (data == 0) {
                        alert("تم المسح بنجاح");
                        window.location.reload();

                    } else {
                        alert("حدث مشكلة اثناء عملية المسح");
                    }
                }
            });
        }
    });
    $('input[type=radio][name=optionsRadios]').change(function() {
        if (this.value == 'option1') {
            var type=1;
        }
        else if (this.value == 'option2') {
            var type=2;
        }
        else
        {
            var type=3;
        }
        var base=$("#base").val();
        var element=$(this);
        $.ajax({
            type: "POST",
            url: base+"users/get_empsuper",
            data: ({type:type
            }),
            success: function(data) {
                $('#select1').find('option').remove();

                var products =  $.parseJSON(data);
                for (var index = 0; index < products.length; index++) {
                    if(type==1)
                    {
                        $("#messto").val(1);
                        $('#select1').append($('<option>', {
                            value: products[index].customerCrmId,
                            text : products[index].customerCrmName
                        }));
                    }
                    else
                    {
                        $("#messto").val(2);

                        $('#select1').append($('<option>', {
                            value: products[index].userCrmId,
                            text : products[index].userCrmName
                        }));
                    }
                }

            }
        });
    });


    function myFunction(x) {
        if(x.keyCode == 13) {
            var textInput = $("#SelectWord").val();
            if (validateEmail(textInput)){
                $("#EnterMoreSms").addClass("border m-2");
                $("#EnterMoreSms").append("<div class='text-break ml-auto'>" +
                    "<p class='pr-2'> <input type='hidden' name='mailAddress[]' class='mailaddress' value='"+textInput+"' >" +
                    "<span class='ml-2' onclick='DeleteElement(this)' style='color:red; cursor: pointer; font-weight:900; border: 1px solid; border-radius: 50%; padding: 3px;'>X</span>"+ textInput + "</p> " +
                    "<div>");
                $("#SelectWord").val(' ');
            }else{
                alert("برجاء التاكد من البريد الالكترونى");
            }
        }
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }


    function DeleteElement(p) {
        if ($('.mailaddress').length == 1 ) {
            $("#EnterMoreSms").removeClass("border m-2");
            $(p).parent().remove ();
        }else {
            $(p).parent().remove ();
        }

    }
</script>

</body>

</html>