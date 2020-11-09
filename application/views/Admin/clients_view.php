<?php $this->load->view("header");?>

<div  style="margin:3%">



    <div class="row">
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
        <div class="col-sm-12">
            <br>
            <table class="table table-striped display data-table">
                <thead>
                <br>
                <div class="row action-row">
                <div class="col-sm-2 col-sm-offset-10">
                    <button class="btn btn-success btn-lg btn-block btn-icon"  id="opener-message2" name="optradio">
                        ارسال ايميل 
                        <i class="entypo-mail"></i>
                    </button>
                </div>
                </div>
                
                <div class="form-check form-check-inline col-sm-4">
                    <!-- <label class="radio-inline" for="rs1" id="opener-message2" style="margin-left: 4%">
                        <input type="radio" id="rs1" name="optradio">ايميل</label> -->
                    <!--                    <label class="radio-inline" for="rs2" id="opener-mail">-->
                    <!--                        <input type="radio" id="rs2" name="optradio">رسالة</label>-->
                    <div class="sed-mail-modal fade " id="mail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" >
                        <!--send mail-->
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

                    </div>

                    <!--send sms-->
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

                    <th>الاسم</th>
                    <th>الشركة</th>
                    <th>الوظيفة</th>
                    <th>الملاحظات</th>
                    <th>الموظف</th>
                    <th>المشرف</th>

                </tr>
                </thead>
                <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : 0 ?>">
                <tbody>
                <?php if(isset($clients)){ for($i=0;$i<count($clients);$i++){

                    ?>
                    <tr id="task-1"
                        class="task-list-row clickable-row"

                        data-href= "<?=$clients[$i]->customerCrmId?>"
                        style="cursor: pointer;" ClientID = "<?php echo $clients[$i]->customerCrmId?>">
                        <td class="checkable-td">
                            <input type="checkbox" id="chk-1" cid="<?php echo $clients[$i]->customerCrmId?>" class="<?php echo 'customer'.$i?>">
                        </td>

                        <td data-toggle="tooltip" data-placement="top" title="<?php echo $clients[$i]->customerCrmName?>"><?php echo $clients[$i]->customerCrmName?></td>

                        <td><?php echo $clients[$i]->customerCrmCompany?></td>
                        <td><?php echo $clients[$i]->customerCrmJob?></td>
                        <td><?php echo $clients[$i]->ONotes?></td>
                        <td><?php echo get_Emp_name($clients[$i]->UserID)?></td>
                        <td><?php  $empID=get_row('crm_users',array('ID'=>$clients[$i]->UserID),null);
                            echo get_Emp_name($empID->Super);
                            ?></td>



                    </tr>
                <?php } }?>
                </tbody>
            </table>

        </div>

    </div>


</div>


<br />


</div>


<div class="modal fade " id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-white" id="exampleModalLabel2" style="text-align: center;color: #ffffff;">بيانات العميل</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="CID">
                <div class="form-group">

                    <table>
                        <tr>
                            <td>الاسم:</td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>الشركة:</td>
                            <td id="com"></td>
                        </tr
                        <tr>
                            <td>الوظيفة:</td>
                            <td id="job"></td>
                        </tr>
                        <tr>
                            <td>الملاحظات:</td>
                            <td id="notes"></td>
                        </tr>
                        <tr>
                            <td>رقم التليفون:</td>
                            <td id="phone"></td>
                        </tr>
                        <tr>
                            <td>البريد الإلكترونى:</td>
                            <td id="email"></td>
                        </tr>
                        <tr>
                            <td>المحافظة:</td>
                            <td id="government"></td>
                        </tr>
                        <tr>
                            <td>النوع:</td>
                            <td id="type"></td>
                        </tr>
                        <tr>
                            <td>السن:</td>
                            <td id="age"></td>
                        </tr>
                        <tr>
                            <td>العنوان:</td>
                            <td id="address"></td>
                        </tr>

                    </table>
                </div>


            </div>
            <div class="modal-footer col-sm-12" >
                <div class="col-sm-6"  style="width: 50%; margin: 0 auto; text-align: left">
                    <button type="button" class="btn btn-primary" id="sendemail"  data-toggle="modal" data-target="#exampleModalemail" >ارسال ايميل</button>
                </div>
                <!--                <div class="col-sm-6" style="align-content: center">-->
                <!--                    <button type="button" class="btn btn-primary" id="sendsms">ارسال رساله</button>-->
                <!---->
                <!--                </div>-->


            </div>
        </div>
    </div>
</div>








<div class="modal fade " id="exampleModalemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-white" id="exampleModalLabel2" style="text-align: center;color: #ffffff;">بيانات العميل</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="mail-body">
                        <div class="mail-compose">
                            <form method="post" role="form" class="form-horizontal form-groups-bordered">
                                <div class="form-group">
                                    <label class=" control-label" for="select1">العنوان</label>
                                    <input type="text" class="form-control " id="emailsubject" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="subject">محتوي الرساله:</label>
                                    <textarea id="emailcontent" class="form-control " style="height: 150px;" required></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-12" style="width: 100%; margin: 0 auto; text-align: left">
                                        <input type="button" value="ارسال" class="sendesinglemail btn btn-black">
                                    </div>

                                </div>




                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
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


    $(document).on("click",".GotoMissions",function(){
        var id=$(this).attr("taskid");
        $.ajax({
            type: "POST",
            url: "<?= $url ?>users/missionBack",
            data: ({id:id}),
            success: function(data) {
                if(data==true)
                {
                    toastr.success("تم تحويل العميل الي المهام");
                }else{
                    toastr.error("حدث مشكله اثناء تحويل العميل  الي المهام");
                }

            }
        });
    });

    $(".sendemail").click(function(){

        var nums=$(".cliecount").val();
        var base=$("#base").val();
        var clientid;
        var subject=$(".emailsubject").val();
        var content=$(".emailcontent").val();
        var Check=true;
        var Data ='';




        if(subject!="" && content!="")
        {
            for (var i = 0; i < nums; i++) {
                if ($('.elem' + i).is(":checked")) {
                    clientid = $('.custid' + i).val();
                    Data += clientid + ',';
                    //alert(clientid);
                }
            }
            $.ajax({
                type: "POST",
                url: base+"users/sendemail",
                data: ({to:Data,
                    subject:subject,
                    content:content
                }),
                success: function(data) {
                    //  alert(data);
                    if( data == '1')
                    {
                        toastr.success("تم  ارسال الايميال بنجاح");
                    }else {
                        toastr.error("لم يتم  ارسال الايميال ");
                    }

                }
            });

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
        window.location.href = "<?= $url ?>users/clients_view/"+DateRange;
    });
</script>


<script>
    function GetClient(a) {
        var  clientid= $(a).attr("ClientID");

        $.ajax({
            type: "POST",
            url: "<?= $url ?>users/ClientDetails",
            data: ({clientid:clientid}),
            success: function(data) {
                var result = $.parseJSON(data);
                if(result != null)
                {
                    document.getElementById('name').innerText = result.customerCrmName;
                    document.getElementById('com').innerText = result.customerCrmCompany;
                    document.getElementById('job').innerText = result.customerCrmJob;
                    document.getElementById('notes').innerText = result.Notes;
                    document.getElementById('phone').innerText =  result.customerCrmPhone;
                    document.getElementById('email').innerText =  result.customerCrmEmail;
                    document.getElementById('government').innerText =  result.customerCrmGov;
                    document.getElementById('type').innerText =  result.ftype;
                    document.getElementById('age').innerText =  result.fage;
                    document.getElementById('address').innerText =  result.customerCrmAddress;


                    //document.getElementById('sendemail').innerText =  result.customerCrmAddress;
                    $("#CID").attr("value",result.customerCrmId);

                    //alert(result.customerCrmId);
                    // ViewData
                }

            }
        });



        //alert(clientid);
    }
    $("#sendemail").click(function () {
        // send Email
        // alert($("#CID").attr("value"));
    });
    $("#sendsms").click(function () {
        // Send SMS
        //  alert($("#CID").attr("value"));
    });





    $(".sendesinglemail").click(function(){

        var clientid =$("#CID").attr("value") + ',';
        var subject=$("#emailsubject").val();
        var content=$("#emailcontent").val();
        //alert(clientid);
        $.ajax({
            type: "POST",
            url: "<?= $url ?>users/sendemail",
            data: ({to:clientid,
                subject:subject,
                content:content
            }),
            success: function(data) {
                //  alert(data);
                if( data == '1')
                {
                    toastr.success("تم  ارسال الايميال بنجاح");
                    document.getElementById("emailsubject").innerText = '';
                    document.getElementById("emailcontent").innerText = '';


                }else {
                    toastr.error("لم يتم  ارسال الايميال ");
                }

            }
        });

    });


</script>
<script>
    var url=$("#base").val();
    $(document).ready(function($) {
        $(".clickable-row:not(.checkable-td)").click(function() {
            var ClientID = $(this).data("href");
            window.location=url+"Client/Details/" +ClientID ;
        });
    });

</script>
</body>
</html>