<?php $this->load->view("header");?>
<div  style="margin:3%">
    <div class="row">
        <div class="col-sm-12">

            <div class="row" style="direction: rtl">
                <div >
                    <div style="text-align: left" class="col-sm-6" >
                        <label style="font-size: 20px;font-weight: bold;color: black">من تاريخ</label>
                        <input value="<?= $date1 ?>" type="date" id="FromDate">
                    </div>
                    <div style="text-align: right" class="col-sm-3" >
                        <label style="font-size: 20px;font-weight: bold;color: black">الي تاريخ</label>
                        <input value="<?= $date2 ?>" type="date" id="ToDate">
                    </div>
                    <div style="" class="col-sm-3" >
                        <input type="button" value="بحث" class="btn btn-black btn-lg" id="searchButton" />
                    </div>
                </div>
            </div>
            <br>
            <table class="table table-striped display data-table">
                <thead>
                <br>
                <div class="col-sm-5"></div>
                <div class="form-check form-check-inline col-sm-4">
                    <label class="radio-inline" for="rs1" id="opener-message2" style="margin-left: 4%"><input type="radio"id="rs1" name="optradio">ايميل</label>
                    <label class="radio-inline" for="rs2" id="opener-mail"><input type="radio" id="rs2" name="optradio">رسالة</label>
                    <div id="dialog-message2" title="ارسال ايميل " style="display:none">
                        <div class="mail-body">
                            <div class="mail-compose">
                                <form method="post" role="form" class="form-horizontal form-groups-bordered">
                                    <div class="form-group">
                                        <label class=" control-label" for="select1">العنوان</label>
                                        <input type="text" class="form-control emailsubject" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">محتوي الرساله:</label>
                                        <textarea row="4" col="50" class="form-control etextar2-text emailcontent"></textarea>
                                    </div>
                                    <input type="button" value="ارسال" class="sendemail btn btn-black">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="dialog-mail" title="ارسال رسالة" style="display:none">
                        <div class="mail-body">
                            <div class="mail-compose">
                                <form method="post" role="form" class="form-horizontal form-groups-bordered">
                                    <div class="form-group">
                                        <label class=" control-label" for="select1">العنوان</label>
                                        <input type="text" class="form-control smssubject" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">الموضوع:</label>
                                        <textarea row="4" col="50" class="form-control etextar2-text smscontent"></textarea>
                                    </div>
                                    <input type="button" value="ارسال" class="sendsms btn btn-black">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <tr>
                    <th ><input type="checkbox" id="chk-1" class="clncheckAll"></th>
                    <th>الكود</th>
                    <th>الاسم</th>
                    <th>التليفون</th>
                    <th>الايميل</th>
                    <th>حالة الحجز</th>
                    <th>الشركة</th>
                    <th>الوظيفة</th>
                    <th>الموظف</th>
                    <th>المشرف</th>
                    <th>تاريخ بدايه المكالمة</th>
                    <th>تاريخ نهايه المكالمة</th>
                    <th>مده المكالمه</th>
                </tr>
                </thead>
                <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : "0" ?>">
                <tbody>
                <?php if(isset($clients)){
                    for($i=0;$i<count($clients);$i++){?>
                        <tr id="task-1"
                            class="task-list-row"
                            data-priority="">
                            <td>
                                <input type="checkbox" id="chk-1" cid="<?php echo $clients[$i]->customerCrmId?>" class="<?php echo 'customer'.$i?>">
                            </td>
                            <td><?php echo $clients[$i]->customerCrmId?></td>
                            <td><?php echo $clients[$i]->customerCrmName?></td>
                            <td><?php echo $clients[$i]->customerCrmPhone?></td>
                            <td><?php echo $clients[$i]->customerCrmEmail?></td>
                            <td><?php echo $clients[$i]->Status_Name?></td>
                            <td><?php echo $clients[$i]->customerCrmCompany?></td>
                            <td><?php echo $clients[$i]->customerCrmJob?></td>
                            <td><?php echo get_name($clients[$i]->customerCrmEmp,1)?></td>
                            <td><?php echo get_name($clients[$i]->supervisor_ID,1)?></td>
                            <td><?php echo $clients[$i]->startcall?></td>
                            <td><?php echo $clients[$i]->endcall?></td>
                            <td><?= (strtotime($clients[$i]->endcall) > strtotime($clients[$i]->startcall)) ?  ( $difference_in_seconds = strtotime($clients[$i]->endcall) - strtotime($clients[$i]->startcall) )   : "لم يتم انهاء المكالمه بعد" ?></td>
                        </tr>
                    <?php }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br />
</div>

<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
<script src="assets/js/calltable.js"></script>
<script src="assets/js/gsap/main-gsap.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>

<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script>


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

    $(".sendemail").click(function(){

        var nums=$(".cliecount").val();
        var base=$("#base").val();
        var clientid;
        var subject=$(".emailsubject").val();
        var content=$(".emailcontent").val();
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
                        url: base+"users/sendemail",
                        data: ({clientid:clientid,
                            subject:subject,
                            content:content
                        }),
                        success: function(data) {
                            if(Check==true)
                            {
                                check=false;
                                toastr.success("تم  ارسال الايميال بنجاح");
                            }

                        }
                    });
                }
            }
        }
        else
        {
            toastr.error("لا يمكن ان يكون العنوان فارغ او المحتوي");

        }

    });
</script>
<script>
    $(document).on("click","#searchButton",function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>users/clientviewBydate/"+DateRange;
    });
</script>
</body>
</html>