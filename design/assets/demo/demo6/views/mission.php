<?php $this->load->view("header");?>
<div class="contains">

    <?php
    //print_r($total.PHP_EOL);

    // print_r("<pre>".$clients."</pre>");
    //    print_r($clients);
    //    die();
    ?>
    <div class="row">
        <div class="escharge">
            <div class="row">
                <div class="col-sm-4">
                    <img src="assets/images/calls.png" class="esrotate" />
                    <p>المكالمات</p>
                    <p><?php echo $total?></p>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/done.png" class="esrotate" />
                    <p>تمت</p>
                    <p><?= $Completed ?></p>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/rest.png" class="esrotate" />
                    <p>المتبقية</p>
                    <p><?= $remainder?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">


        <div class="col-md-4">

        </div>

        <div class="col-md-4">
            <div class="mail-sidebar-row">
                <!--                <a id="opener-mail" class="btn btn-success btn-icon btn-block">-->
                <!--                    ارسال رسالة-->
                <!--                    <i class="entypo-mail"></i>-->
                <!--                </a>-->
                <div id="dialog-mail" title=" ارسال رسالة " style="display:none">

                    <div class="mail-body">


                        <br>

                        <div class="mail-compose">


                            <form method="post" role="form" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label class=" control-label" for="select1">العنوان</label>

                                    <input type="text" class="form-control smssubject" value="">


                                </div>






                                <div class="form-group">
                                    <label for="subject">الموضوع:</label>
                                    <textarea row="4" col="50" class="form-control etextar2 smscontent"></textarea>
                                </div>


                                <input type="button" value="ارسال" class="sendsms">

                            </form>

                        </div>

                    </div>

                </div>

            </div>


        </div>
        <div class="col-md-4">

        </div>
    </div>
    <div class="row">
        <table id="myTable" class="table table-striped display data-table">

            <thead>
            <tr>
                <th ><input type="checkbox" id="chk-1" class="clncheckAll"></th>
                <th>الكود</th>
                <th>الاسم</th>
                <th>التليفون</th>
                <th>الايميل</th>
                <th>حالة الحجز</th>
                <th>الشركة</th>
                <th>الوظيفة</th>
<!--                <th>الموظف</th>-->
<!--                <th>المشرف</th>-->
<!--                <th>تاريخ بدايه المكالمة</th>-->
<!--                <th>تاريخ نهايه المكالمة</th>-->

            </tr>
            </thead>
            <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : "0" ?>">
            <tbody>
            <?php if(isset($clients)){ for($i=0;$i< $remainder;$i++){
                $status = 1;

                ?>
                <tr id="task-1" class="task-list-row" data-priority="<?php echo $status?>">
                    <td>
                        <input type="checkbox" id="chk-1" cid="<?php echo $clients[$i]->userID?>" class="<?php echo 'customer'.$i?>">
                    </td>
                    <td><a href="<?php echo $url.'users/customer/'.$clients[$i]->customerCrmId?>"><?php echo $clients[$i]->customerCrmId?></a></td>
                    <th data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmName?>"><a href="<?php echo $url.'users/customer/'.$clients[$i]->customerCrmId?>"><?php echo $clients[$i]->customerCrmName?></th>
                    <th><?php echo $clients[$i]->customerCrmPhone?></th>
                    <th><?php echo $clients[$i]->customerCrmEmail?></th>
                    <th><?php echo $clients[$i]->Status_Name?></th>
                    <th><?php echo $clients[$i]->customerCrmCompany?></th>
                    <th><?php echo $clients[$i]->customerCrmJob?></th>
<!--                    <th>--><?php //echo get_name($clients[$i]->userID,1)?><!--</th>-->
<!--                    <th>--><?php //$getId = get_row("usercrm",["userCrmId" =>$clients[$i]->customerCrmEmp],null) ; echo get_name($getId->userCrmSuper,1)?><!--</th>-->
<!--                    <th>--><?php //echo $clients[$i]->startcall?><!--</th>-->
<!--                    <th>--><?php //echo $clients[$i]->endcall?><!--</th>-->
                </tr>
            <?php } }?>
            </tbody>
        </table>
    </div>




</div>


<br />








<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">


<!-- Bottom Scripts -->
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
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script>
    var url=$("#base").val();
    function customer() {
        window.location=url+"users/customer";
    }

    $(".sendsms").click(function(){

        var nums=$(".cliecount").val();
        var base=$("#base").val();
        var clientid;
        var subject=$(".smssubject").val();
        var content=$(".smscontent").val();
        var Check=true;

        if(subject!="" && content!="")
        {
            for (var index = 0; index < nums; index++)
            {

                if ($('.customer'+index).is(':checked'))
                {
                    clientid= $('.customer'+index).attr("cid");
                    $.ajax({
                        type: "POST",
                        url: base+"users/sendsms",
                        data: ({clientid:clientid,
                            subject:subject,
                            content:content
                        }),
                        success: function(data) {
                            if(Check==true)
                            {
                                Check=false;
                                toastr.success("تم  ارسال الرساله بنجاح");
                            }

                        }
                    });
                }
            }
            if(Check==true)
            {
                toastr.error("يجب عليك اختيار عميل");
            }
        }
        else
        {
            toastr.error("لا يمكن ان يكون العنوان فارغ او المحتوي");

        }



    });
</script>
</body>

</html>