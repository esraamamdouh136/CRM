<?php $this->load->view("header");
$per = get_premissions($_SESSION['userid'],"10");

?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:8%; margin-left:2%; margin-top:1%;">


    <?php
    if ($_SESSION['usertype'] > 1){?>

        <div class="row action-row">
            <div class="col-md-12" >
                <div class="mail-sidebar-row">


                    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="infoSend" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header d-flex flex-row-reverse">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-label">شكوى / ملاحظة جديدة</h4>

                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" id="error" style="display: none"></div>

                                    <form method="post" action="<?php echo $url.'CRM_Complain/newComplain'?>">
                                        <div class="form-group row all-labels">
                                            <div class="col-lg-6">
                                                <label>الى :</label>
                                                <label class=" control-label control-label-2 " for="select1" style="padding-left: 20px;">

                                                    <input type="checkbox" name="ToAdmin" checked disabled>
                                                    <b class="ml-2"> المدير</b>
                                                </label>

                                            </div>
                                            <div class="col-lg-6">
                                                <label class=" control-label control-label-2 " for="select1">

                                                    <input type="checkbox" name="ToSuper" id="To-super" >
                                                    <b class="ml-2"> مشرف</b>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row all-labels">
                                            <div class="col-lg-6">

                                                <label>النوع : </label>
                                                <input type="radio" value="0" name="type" checked>
                                                <b class="ml-2">شكوى </b>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="radio" value="1" name="type">
                                                <b class="ml-2">ملاحظة  </b>
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
                                        <div class="form-group row all-labels mt-5">
                                            <label for="subject" class="col-lg-2">العنوان:</label>
                                            <div class="col-lg-10">
                                                <input type="text" required name="title" class="form-control " tabindex="1" />
                                            </div>
                                        </div>
                                        <div class="form-group row all-labels">
                                            <label for="subject" class="col-lg-2">الموضوع:</label>
                                            <div class="col-lg-10">
                                            <textarea required name="content" class="form-control etextar2 ckeditor" id="subject"
                                                      tabindex="1"></textarea>


                                            </div>
                                        </div>
                                        <hr>
                                        <input type="submit" value="ارسال" class="btn btn-info float-right">
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
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        شكوى / ملاحظة جديدة
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="#" onclick="return false;" id="opener2"
                                           class="btn btn-info m-btn--icon btn btn-info m-btn--icon float-lg-right" data-toggle="modal"
                                           data-target="#infoSend">
                                            شكوى / ملاحظة جديدة
                                            <i class="entypo-mail" ></i>
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
                                <?php
                                if ($_SESSION['usertype'] !=2){?>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active TabButton" data-toggle="tab" href="#Complain"
                                           role="tab"> <i class="flaticon-list "></i>الشكاوي</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link TabButton" data-toggle="tab" href="#notes"
                                           role="tab"><i class="flaticon-layers "></i>الملاحظات</a>
                                    </li>
                                <?php } else{ ?>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active TabButton" data-toggle="tab" href="#Complain"
                                           role="tab"> <i class="flaticon-list"></i>شكاوى مرسلة</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link TabButton" data-toggle="tab" href="#ReceivedComplain"
                                           role="tab"><i class="flaticon-layers"></i>شكاوى مستقبلة</a>
                                    </li>

                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link TabButton" data-toggle="tab" href="#notes"
                                           role="tab"> <i class="flaticon-list"></i>ملاحظات مرسلة</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link TabButton" data-toggle="tab" href="#ReceivedNotes"
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

                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox" class="clncheckAll selectall">
                                            </th>


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
                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem0" mess="<?= $Complain[$i]->ID?>">
                                                    <input type="hidden" class="dataID custid0" value="11">
                                                </td>

                                                <td class="col-name">

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($Complain[$i]->UserID); ?>
                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="col-name text-left pt-4"><?php echo get_Emp_name($Complain[$i]->UserID); ?></p>
                                                        </div>
                                                    </div>
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
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$Complain[$i]->ID?>" class="btn btn-outline-info">
                                                        تفاصيل</a>
                                                    <button class="btn btn-outline-danger delete" mess="<?php echo $Complain[$i]->ID?>">
                                                        حذف</button>
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


                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox" class="clncheckAll selectall">
                                            </th>
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
                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem0" mess="<?= $notes[$i]->ID?>">
                                                    <input type="hidden" class="dataID custid0" value="11">
                                                </td>

                                                <td class="col-name">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($notes[$i]->UserID); ?>

                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">


                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="col-name text-left pt-4"><?php echo get_Emp_name($notes[$i]->UserID); ?></p>

                                                        </div>
                                                    </div>
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
                                                    <a href="<?php echo $url.'CRM_Complain/details/'.$notes[$i]->ID?>" class="btn btn-outline-info">
                                                         تفاصيل </a>
                                                    <button class="btn btn-outline-danger" mess="<?php echo $notes[$i]->ID?>">
                                                        حذف</button>
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
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox" class="clncheckAll selectall">
                                            </th>
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
                                                <i class="fas fa-setting" style="color:blue"></i>    الاعداداتss
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
                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem0" mess="<?= $ReceivedComplain[$i]->ID?>">
                                                    <input type="hidden" class="dataID custid0" value="11">
                                                </td>

                                                <td class="col-name">

                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($ReceivedComplain[$i]->UserID); ?>

                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="col-name text-left pt-4"><?php echo get_Emp_name($ReceivedComplain[$i]->UserID); ?></p>

                                                        </div>

                                                    </div>

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
                                                    <button class="btn btn-danger delete" mess="<?php echo $ReceivedComplain[$i]->ID?>">
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
                                            <th class="sorting_asc" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 15px;" aria-label="

                                            " first"="" :="" activate="" to="" sort="" column="" descending"="">
                                            <input type="checkbox" class="clncheckAll selectall">
                                            </th>
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
                                                <td class="checkable-td sorting_1">
                                                    <input type="checkbox" class="checkboxMy chk elem0" mess="<?= $ReceivedNotes[$i]->ID?>">
                                                    <input type="hidden" class="dataID custid0" value="11">
                                                </td>
                                                <td class="col-name">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <?php $Image = get_Emp_ProfileImage($ReceivedNotes[$i]->UserID); ?>

                                                            <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="img-fluid">
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p class="col-name text-left pt-4"><?php echo get_Emp_name($ReceivedNotes[$i]->UserID); ?></p>

                                                        </div>

                                                    </div>

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
                                                    <button class="btn btn-danger delete" mess="<?php echo $ReceivedNotes[$i]->ID?>">
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



    $(".selectall").change(function () {
        var element = this;
        $(':checkbox.checkboxMy').each(function() {
            this.checked = element.checked;
        });
    });
    $(".TabButton").click(function () {
        $(".selectall").prop('checked', false);
        $(':checkbox.checkboxMy').each(function() {
            this.checked =false;
        });
    });

    $("#remove_All").click(function () {
        var y= confirm("هل انت متاكد من عملية الحذف ؟");
        var count = 0;
        if(y==true){
            $(':checkbox.checkboxMy').each(function() {
                if (this.checked){
                    count++;
                    var ID=$(this).attr("mess");
                    var base=$("#base").val();
                    $.ajax({
                        type: "POST",
                        url: base+"CRM_Complain/Delete",
                        data: ({ComplainID:ID
                        }),
                        success: function(data) {

                        }
                    });
                }

            });
        }
        if (count == 0){
            alert("برجاء إختيار العناصر المراد حذفها");
        }else{
            alert("تم المسح  بنجاح");
            window.location.reload();
        }



    });

 

    $(".delete").click(function(){
        debugger;
        var y= confirm("هل انت متاكد من عملية الحذف");
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