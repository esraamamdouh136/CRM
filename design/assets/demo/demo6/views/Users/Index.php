<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:26 PM
 */
$this->load->view("header");
?>

<div class="contains">
    <div class="row">
        <div class="col-md-12">
            <div class="tab-content">
                <div class="tab-pane active" id="first">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-green add-done-btn3" href="<?= $url.'Transfer/add'?>">+ اضافة طريقة شحن</a>
                            <!--                            <button class="btn btn-green add-done-btn3">+ اضافة طريقة شحن</button>-->
                            <table id="estable" class="display  myTableDaily">
                                <thead>
                                <tr class="unread">

                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i>   طريقه الشحن
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i>   السعر
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الوصف
                                    </th>

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                if(isset($Transfer)){ for($i=0;$i<count($Transfer);$i++){?>
                                    <tr protype="1" class="unread" ><!-- new email class: unread -->
                                        <td class="col-name pname">
                                            <?php echo $Transfer[$i]->transfer_Name?>
                                        </td>
                                        <td class="pprice">
                                            <?php echo $Transfer[$i]->Price?>
                                        </td>
                                        <td class="col-subject pdesc">
                                            <?php echo $Transfer[$i]->Description?>
                                        </td>

                                        <td class="col-subject pdesc">
                                            <a href="<?= $url.'Transfer/update/'.$Transfer[$i]->transfer_ID?>" class="btn btn-blue btn-sm icon-left">
                                                <i class="flaticon flaticon-edit"></i>
                                                تعديل</a>
                                            <button class="btn btn-danger delete" transId="<?php echo $Transfer[$i]->transfer_ID?>">
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

<script>
    jQuery(document).ready(function ($) {
        var idtable2 = $("#estable").DataTable({
            "paging": true,
            "pagingType": "full_numbers",

            "responsive": true


        });
    });

</script>

<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">






<script src="assets/js/gsap/main-gsap.js"></script>

<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>

<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>

<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script>
    $(".delete").click(function(){

        var transID=$(this).attr("transId");
        var base=$("#base").val();
        $.ajax({
            type: "POST",
            url: base+"Transfer/delete",
            data: ({ID:transID}),
            success: function(data) {
                if (data==1){
                    alert("تم المسح بنجاح");
                    location.reload();
                }else {
                    alert("حدث خطأ");
                }

            }
        });

    });
</script>
</body>

</html>

