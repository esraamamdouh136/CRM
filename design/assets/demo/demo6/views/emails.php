<?php  $this->load->view("header");?>




<!-- BEGIN: Subheader -->

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin: 3% 8% 0% 2% ;">

    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="modal fade" data-keyboard="false" data-backdrop="static" id="newEmail" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-row-reverse">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="add-label">ارسال ايميل </h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="error" style="display: none"></div>
                            <form id="add-package" method="post">
                                <input type="hidden" id="edit" name="edit" value="0">
                                <input type="hidden" id="_id" name="_id" value="">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="mtype" value="1">
                                            <input type="hidden" name="type" value="1" id="messto">
                                            <input type="hidden" name="mfrom" value="3">
                                            <label for="mto[]">الي</label>
                                            <input type="email" class="form-control select2-static" id="mailaddress" name="title"/>


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group ">
                                            <label for="source_type">العنوان</label>
                                            <input class="form-control" name="title" required id="Mailsubject">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group add-only">
                                            <label for="source_id">الموضوع</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" id="Mailcontent" rows="7" cols="40"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" id="sendMail" class="btn btn-info submit-form">ارسال</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
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
                                           class="btn btn-info m-btn--icon " data-toggle="modal"
                                           data-target="#newEmail">
														<span>
															<i class="la la-plus"></i>
															<span> ايميل جديد</span>
														</span>
                                        </a>
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
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">من <i class="flaticon flaticon-user"></i>
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">
                                                الي <i class="flaticon flaticon-users"></i></th>
                                            <th style="width: 150px;">العنوان <i class="flaticon flaticon-multimedia-2"></i> </th>
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
                                            <tr class="unread" ><!-- new email class: unread -->


                                                <td class="col-name">

                                                    <a  class="col-name"><?php echo get_Emp_name($sent[$i]->CrmMessagesFrom)?></a>
                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php
                                                        if($sent[$i]->CrmMessagesTo==0){

                                                            echo get_name($sent[$i]->CrmMessagesCustomer,2);
                                                        }
                                                        else
                                                        {
                                                            echo get_name($sent[$i]->CrmMessagesTo,1);
                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $sent[$i]->CrmMessagesTitle?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $sent[$i]->CrmMessagesCreateDate?>
                                                </td>

                                                <td class="col-subject">
                                                    <p class="mt-3">

                                                        <a href="<?php echo $url.'CRM_Mails/details/'.$sent[$i]->CrmMessagesId?>" class="mr-1">
                                                            <span class="ml-2"></span>
                                                            <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="تفاصيل"></i>
                                                        </a>
                                                        <a style="cursor: pointer" class="mr-1 btn-sm" mess="<?php echo $sent[$i]->CrmMessagesId?>">
                                                            <span></span>
                                                            <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
                                                        </a>



                                                </td>

                                            </tr>
                                        <?php } } ?>







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
            }
        })
    });



    $("#sendMail").click(function () {

        var base = $("#base").val();
        var clientid =0;
        var subject = $("#Mailsubject").val();
        var content = $("#Mailcontent").val();
        var mail = $("#mailaddress").val();
        $.ajax({
            type: "POST",
            url: base + "CRM_Mails/sendemail",
            data: ({
                clientid: clientid,
                subject: subject,
                content: content,
                mail: mail

            }),
            success: function (data) {
                if (data == 0) {
                    alert("حدث خطأ");
                } else if (data==1) {
                    alert("تم إرسال البريد الإلكترونى بنجاح");
                    location.reload();
                }else if (data == 2){
                    alert("برجاء التاكد من إعدادات البريد الإلكترونى");
                }


            }
        });


    });
    $(".btn-sm").click(function(){

        var y= confirm("Are you Sure");
        if(y==true)
        {
            debugger;
            var status=$(this).attr("mess");
            var base=$("#base").val();
            var element=$(this);
            var t = 'mail';
            $.ajax({
                type: "POST",
                url: base+"users/delmess",
                data: ({messid:status,type:t
                }),
                success: function(data) {

                    toastr.success("تم المسح  بنجاح");
                    location.reload();

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

</script>

</body>

</html>