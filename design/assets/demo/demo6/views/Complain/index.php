<?php $this->load->view("header");
$per = get_premissions($_SESSION['userid'],"10");

?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:10%; margin-left:4%; margin-top:1%;">


    <?php
    if ($_SESSION['usertype'] > 1){?>

        <div class="row action-row">
            <div class="col-md-12" >
                <div class="mail-sidebar-row">
                    <a href="#" onclick="return false;" id="opener2"
                       class="btn btn-info m-btn--icon btn btn-info m-btn--icon float-lg-right" data-toggle="modal"
                       data-target="#infoSend">
                        شكوى / ملاحظة جديدة
                        <i class="entypo-mail" ></i>
                    </a>

                    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="infoSend" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header d-flex flex-row-reverse">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-label">شكوى / ملاحظة جديدة</h4>

                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" id="error" style="display: none"></div>

                                    <form method="post" action="<?php echo $url.'CRM_Complain/newComplain'?>">
                                        <div class="form-group">
                                            <label class=" control-label" for="select1" style="padding-left: 20px;">
                                                الى المدير:
                                                <input type="checkbox" name="ToAdmin" checked disabled>
                                            </label>

                                            <label class=" control-label" for="select1">
                                                الى مشرف:
                                                <input type="checkbox" name="ToSuper" id="To-super" >
                                            </label>
                                            <div class="" style="display: flex">
                                                <label style="margin-left: 10px">النوع : </label>
                                                <label style="margin-left: 10px">شكوى </label><input type="radio" value="0" name="type" checked>
                                                <label style="margin-left: 10px;margin-right: 10px">ملاحظة  </label><input type="radio" value="1" name="type">
                                            </div>
                                            <div id="select-super" hidden>
                                                <?php
                                                if ($_SESSION['usertype'] == 2){?>
                                                    <select name="mto" id="select1" class="select2 form-control sclient"
                                                    >
                                                        <?php if(isset($super)) { for($i=0;$i<count($super);$i++){
                                                            $type="";
                                                            if ($super[$i]->Type == 1){
                                                                $type="مدير";
                                                            }
                                                            if ($super[$i]->Type == 2){
                                                                $type="مشرف";
                                                            }
                                                            if ($super[$i]->Type == 3){
                                                                $type="موظف";
                                                            }
                                                            ?>
                                                            <option value="<?php echo $super[$i]->ID?>">
                                                                <?php echo $super[$i]->Name." (".$type.") "?>
                                                            </option>
                                                        <?php } }?>
                                                    </select>
                                                <?php }

                                                ?>


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject">العنوان:</label>
                                            <input type="text" required name="title" class="form-control " tabindex="1" />
                                        </div>
                                        <div class="form-group">
                                            <label for="subject">الموضوع:</label>
                                            <input type="text" required name="content" class="form-control etextar2" id="subject"
                                                   tabindex="1" />
                                        </div>
                                        <input type="submit" value="ارسال">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    <?php }


    ?>


    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__body tabs_border">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php
                                if ($_SESSION['usertype'] !=2){?>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#Complain"
                                           role="tab"> <i class="flaticon-list"></i>الشكاوي</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#notes"
                                           role="tab"><i class="flaticon-layers"></i>الملاحظات</a>
                                    </li>
                                <?php } else{ ?>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#Complain"
                                           role="tab"> <i class="flaticon-list"></i>شكاوى مرسلة</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#ReceivedComplain"
                                           role="tab"><i class="flaticon-layers"></i>شكاوى مستقبلة</a>
                                    </li>

                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#notes"
                                           role="tab"> <i class="flaticon-list"></i>ملاحظات مرسلة</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#ReceivedNotes"
                                           role="tab"><i class="flaticon-layers"></i>ملاحظات مستقبلة</a>
                                    </li>
                                <?php }
                                ?>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="Complain" role="tabpanel">
                                    <table class="table mail-table" id="example_1">
                                        <!-- mail table header -->
                                        <thead>
                                        <tr class="unread">
                                            <!-- new email class: unread -->
                                            <th class="col-name size">
                                                <i class="flaticon-user" style="color:blue"></i>   من
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-users" style="color:blue"></i>   العميل
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-home" style="color:blue"></i>    العنوان
                                            </th>
                                            <th class="col-subject size">
                                                <i class="fas fa-setting" style="color:blue"></i>    الاعدادات
                                            </th>

                                        </tr>
                                        </thead>

                                        <!-- email list -->

                                        <tbody>
                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($Complain)){for($i=0;$i<count($Complain);$i++){?>
                                            <tr >

                                                <td class="col-name">
                                                    <a  class="col-name"><?php echo get_Emp_name($Complain[$i]->UserID); ?></a>
                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    if (isset($Complain[$i]->Client_ID) && !is_null($Complain[$i]->Client_ID))
                                                        echo get_name($Complain[$i]->Client_ID,2);
                                                    else
                                                        echo "لا يوجد";

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $Complain[$i]->Titel?>
                                                    </a>
                                                </td>




                                                <td class="col-subject">
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$Complain[$i]->ID?>" class="btn btn-green">
                                                        <i class="entypo-window"></i> تفاصيل </a>
                                                    <button class="btn btn-danger btn-sm" mess="<?php echo $Complain[$i]->ID?>">
                                                        <i class="entypo-trash"></i>مسح</button>
                                                </td>
                                            </tr>
                                        <?php } }?>

                                        </tbody>

                                        <!-- mail table footer -->

                                    </table>
                                </div>
                                <div class="tab-pane" id="notes" role="tabpanel">
                                    <table class="table mail-table" id="example_2">
                                        <!-- mail table header -->
                                        <thead>
                                        <tr class="unread">
                                            <!-- new email class: unread -->
                                            <th class="col-name size">
                                                <i class="flaticon-user" style="color:blue"></i>   من
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-users" style="color:blue"></i>   العميل
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-home" style="color:blue"></i>    العنوان
                                            </th>
                                            <th class="col-subject size">
                                                <i class="fas fa-setting" style="color:blue"></i>    الاعدادات
                                            </th>

                                        </tr>
                                        </thead>

                                        <!-- email list -->

                                        <tbody>
                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($notes)){for($i=0;$i<count($notes);$i++){?>
                                            <tr >

                                                <td class="col-name">
                                                    <a  class="col-name"><?php echo get_Emp_name($notes[$i]->UserID); ?></a>
                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    if (isset($notes[$i]->Client_ID) && !is_null($notes[$i]->Client_ID))
                                                        echo get_name($notes[$i]->Client_ID,2);
                                                    else
                                                        echo "لا يوجد";

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $notes[$i]->Titel?>
                                                    </a>
                                                </td>




                                                <td class="col-subject">
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$notes[$i]->ID?>" class="btn btn-green">
                                                        <i class="entypo-window"></i> تفاصيل </a>
                                                    <button class="btn btn-danger btn-sm" mess="<?php echo $notes[$i]->ID?>">
                                                        <i class="entypo-trash"></i>مسح</button>
                                                </td>
                                            </tr>
                                        <?php } }?>

                                        </tbody>

                                        <!-- mail table footer -->

                                    </table>

                                </div>

                                <div class="tab-pane" id="ReceivedComplain" role="tabpanel">
                                    <table class="table mail-table" id="example_2">
                                        <!-- mail table header -->
                                        <thead>
                                        <tr class="unread">
                                            <!-- new email class: unread -->
                                            <th class="col-name size">
                                                <i class="flaticon-user" style="color:blue"></i>   من
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-users" style="color:blue"></i>   العميل
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-home" style="color:blue"></i>    العنوان
                                            </th>
                                            <th class="col-subject size">
                                                <i class="fas fa-setting" style="color:blue"></i>    الاعدادات
                                            </th>

                                        </tr>
                                        </thead>

                                        <!-- email list -->

                                        <tbody>
                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($ReceivedComplain)){for($i=0;$i<count($ReceivedComplain);$i++){?>
                                            <tr >

                                                <td class="col-name">
                                                    <a  class="col-name"><?php echo get_Emp_name($ReceivedComplain[$i]->UserID); ?></a>
                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    if (isset($ReceivedComplain[$i]->Client_ID) && !is_null($ReceivedComplain[$i]->Client_ID))
                                                        echo get_name($ReceivedComplain[$i]->Client_ID,2);
                                                    else
                                                        echo "لا يوجد";

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $ReceivedComplain[$i]->Titel?>
                                                    </a>
                                                </td>




                                                <td class="col-subject">
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$ReceivedComplain[$i]->ID?>" class="btn btn-green">
                                                        <i class="entypo-window"></i> تفاصيل </a>
                                                    <button class="btn btn-danger btn-sm" mess="<?php echo $ReceivedComplain[$i]->ID?>">
                                                        <i class="entypo-trash"></i>مسح</button>
                                                </td>
                                            </tr>
                                        <?php } }?>

                                        </tbody>

                                        <!-- mail table footer -->

                                    </table>

                                </div>

                                <div class="tab-pane" id="ReceivedNotes" role="tabpanel">
                                    <table class="table mail-table" id="example_2">
                                        <!-- mail table header -->
                                        <thead>
                                        <tr class="unread">
                                            <!-- new email class: unread -->
                                            <th class="col-name size">
                                                <i class="flaticon-user" style="color:blue"></i>   من
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-users" style="color:blue"></i>   العميل
                                            </th>
                                            <th class="col-subject size">
                                                <i class="flaticon-home" style="color:blue"></i>    العنوان
                                            </th>
                                            <th class="col-subject size">
                                                <i class="fas fa-setting" style="color:blue"></i>    الاعدادات
                                            </th>

                                        </tr>
                                        </thead>

                                        <!-- email list -->

                                        <tbody>
                                        <?php
                                        if(isset($meto))
                                        {
                                            print_r($meto);
                                        }
                                        if(isset($ReceivedNotes)){for($i=0;$i<count($ReceivedNotes);$i++){?>
                                            <tr >

                                                <td class="col-name">
                                                    <a  class="col-name"><?php echo get_Emp_name($ReceivedNotes[$i]->UserID); ?></a>
                                                </td>
                                                <td class="col-subject">

                                                    <?php
                                                    if (isset($ReceivedNotes[$i]->Client_ID) && !is_null($ReceivedNotes[$i]->Client_ID))
                                                        echo get_name($ReceivedNotes[$i]->Client_ID,2);
                                                    else
                                                        echo "لا يوجد";

                                                    ?>

                                                </td>
                                                <td class="col-subject">
                                                    <a >
                                                        <?php echo $ReceivedNotes[$i]->Titel?>
                                                    </a>
                                                </td>




                                                <td class="col-subject">
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$ReceivedNotes[$i]->ID?>" class="btn btn-green">
                                                        <i class="entypo-window"></i> تفاصيل </a>
                                                    <button class="btn btn-danger btn-sm" mess="<?php echo $ReceivedNotes[$i]->ID?>">
                                                        <i class="entypo-trash"></i>مسح</button>
                                                </td>
                                            </tr>
                                        <?php } }?>

                                        </tbody>

                                        <!-- mail table footer -->

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
        $("table[id^='example']").DataTable({
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


    } );




    $(".btn-sm").click(function(){
        debugger;
        var y= confirm("  هل انت متاكده من عمليه الحذف");
        if(y==true)
        {
            var ID=$(this).attr("mess");
            var base=$("#base").val();

            $.ajax({
                type: "POST",
                url: base+"CRM_Complain/Delete",
                data: ({ComplainID:ID
                }),
                success: function(data) {
                    if (data == 1){
                        alert("تم المسح  بنجاح");
                        window.location.reload();
                    }else{
                        alert("حدث خطأ اثناء عملية الحذف");
                    }
                }
            });
        }
    });


    $('input[type=radio][name=optionsRadios]').change(function() {
        var type=2;
        if (this.value == 'option2') {
            var type=2;
        }
        else if (this.value == 'option3') {
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

    $(document).on("click", "#send-message", function () {
        var uName=$("#user-mail").val();
        var uPass=$("#user-password").val();
        var portNo=$("#port-number").val();
        var mailServer=$("#mail-server").val();

        var data = new FormData();
        data.append('uName', uName);
        data.append('uPass', uPass);
        data.append('portNo', portNo);
        data.append('mailServer', mailServer);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype:"json",
            url: "<?=$url?>users/update_mail_settings",
            data: data,
            success: function(doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['error'] == false) {
                    toastr.success(Dataarray['msg']);
                }else{
                    toastr.error(Dataarray['msg']);
                }
            }
        });
    });

    var url=$("#base").val();
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            var ClientID = $(this).data("href");
            window.location=url+"Client/Details/" +ClientID ;
        });
    });


</script>



<script>

    $('#To-super').change(function() {
        if($(this).is(":checked")) {
            $('#select-super').show();
        }else{
            $('#select-super').hide();
        }

    });



</script>

</body>

</html>