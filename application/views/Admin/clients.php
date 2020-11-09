
<?php $this->load->view("header");?>


<div class="esmaincontent" >
    <div class="DateRangeData" dateRange="<?= $dateRange ?>"  style="margin:3%">


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
    </div>
    <br>

    <div class="row" style="direction: rtl">
        <?php if($statusData!= 4){ ?>
            <div class="col-sm-3" >
            <div class="tile-stats tile-green"  style=" background: #815cda; " >
                <div class="icon"><i class="entypo-chart-bar"></i></div>
                <div class="num" data-start="0" data-end="<?= $ClientCount ?>" data-postfix="" data-duration="1500" data-delay="600">0</div>
                <h3>اجمالي المكالمات</h3>
                <p>عدد المكالمات</p>
            </div>
            </div><?php } ?>

        <?php if (isset($statusCrm) && $statusData!= 4){
            for ($i= 0 ;$i < count($statusCrm);$i++){ ?>
                <div class="col-sm-3" id="t-<?= $i ?>">

                    <div class="tile-stats tile-aqua"  >
                        <div class="icon"><i class="entypo-chart-bar"></i></div>
                        <div class="num" data-start="0"  data-postfix="" data-duration="1500" data-delay="600">0</div>
                        <h3 id="statusName-<?= $i ?>"><?= $statusCrm[$i]->Status_Name ?></h3>
                        <p> عدد المكالمات</p>
                    </div>

                </div>
            <?php }} ?>

    </div>

    <div class="row" style= "direction: ltr">

        <div class="panel panel-default" data-collapsed="0">


            <div class="panel-body" style="padding: 0px 15px;">
                <?php if($statusData==4){?>
                    <p style="direction: rtl;   font-size: 25px;color: #1f77b4;">تقسيم العملاء من حيث</p>
                <?php }?>
                <?php if($statusData==4){?>
                <div class="col-sm-6 espie1" style="display:none">
                    <?php } else{ ?>
                    <div  class="col-sm-6 espie1">
                        <?php }?>
                        <p>حالات المكالمات</p>
                        <div class="attend-chart bg-light"  style="height: 300px;cursor:pointer;">
                            <div id="chart3"></div>
                        </div>
                    </div>
                </div>

                <?php if($statusData!=4){?>
                <div class="col-sm-3 espie1" style="display:none">
                    <?php } else{ ?>
                    <div  class="col-sm-3 espie1">
                        <?php }?>
                        <p>العمر</p>
                        <div class="attend-chart bg-light"  style="height: 300px;cursor:pointer;">
                            <div id="chart"></div>
                        </div>
                    </div>



                    <?php if($statusData!=4){?>
                    <div class="col-sm-3 espie1" style="display:none">
                        <?php } else{ ?>
                        <div  class="col-sm-3 espie1">
                            <?php }?>
                            <p>المؤهل الدراسي</p>
                            <div class="attend-chart bg-light"  style="height: 300px;cursor:pointer;">
                                <div id="chart1"></div>
                            </div>
                        </div>



                        <?php if($statusData!=4){?>
                        <div class="col-sm-3 espie1" style="display:none">
                            <?php } else{ ?>
                            <div  class="col-sm-3 espie1">
                                <?php }?>
                                <p>النوع</p>
                                <div class="attend-chart bg-light"  style="height: 300px;cursor:pointer;">
                                    <div id="chart2"></div>
                                </div>
                            </div>



                            <?php if($statusData!=4){?>
                            <div class="col-sm-3 espie1" style="display:none">
                                <?php } else{ ?>
                                <div  class="col-sm-3 espie1">
                                    <?php }?>
                                    <p>المنطقه</p>
                                    <div class="attend-chart bg-light"  style="height: 300px;cursor:pointer;">
                                        <div id="chart4"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <br><br>

                        <div class="row" style="direction: rtl">
                            <div class="col-sm-12">

                                <div class="col-sm-12">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">
                                        <?php
                                        if ($statusData !=4){?>
                                            <select class="form-control" id="priority-filter">
                                                <option selected>الكل</option>
                                                <?php if (isset($statusCrm)){ for ($i= 0 ;$i < count($statusCrm);$i++){ ?>
                                                    <option> <?= $statusCrm[$i]->Status_Name ?> </option>
                                                <?php }} ?>
                                            </select>

                                        <?php }?>

                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>

                                <br>

                                <table class="table table-striped display data-table">

                                    <thead>
                                    <br>
                                    <div class="col-sm-5"></div>
                                    <div class="form-check form-check-inline col-sm-4">
                                        <label class="radio-inline" for="rs1" id="opener-message2" style="margin-left: 4%"><input type="radio"id="rs1" name="optradio">ايميل</label>
                                        <label class="radio-inline" for="rs2" id="opener-mail"><input type="radio" id="rs2" name="optradio">رسالة</label>
                                        <div>

                                            <?php if(($_SESSION["usertype"] == 1 || $_SESSION["usertype"] == 2) && $statusData ==1){?>
                                                <p>تعيين الى:</p>
                                                <select id="empID" name="newemp">
                                                    <option value="" selected disabled>الموظفين</option>
                                                    <?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){?>
                                                        <option value="<?php echo $emps[$i]->userCrmId?>"><?php echo $emps[$i]->userCrmName?></option>
                                                    <?php } }?>
                                                </select>
                                                <INPUT type="button" value="تعين" class="btn btn-black btn-lg reasign"  />
                                            <?php } ?>

                                            <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($clients)?>">

                                        </div>
                                        <div id="dialog-message2" title="ارسال ايميل " style="display:none">

                                            <div class="mail-body">


                                                <div class="mail-compose">

                                                    <form method="post" role="form" class="form-horizontal form-groups-bordered">

                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <label class=" control-label" for="select1">العنوان</label>

                                                                <input type="text" class="form-control emailsubject" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="subject">الموضوع:</label>
                                                                <textarea row="4" col="50" class="form-control etextar2-text emailcontent"></textarea>
                                                            </div>
                                                            <input type="button" value="ارسال" class="sendemail">
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
                                                            <label for="subject">محتوي الرساله:</label>
                                                            <textarea row="4" col="50" class="form-control etextar2-text smscontent"></textarea>
                                                        </div>
                                                        <input type="button" value="ارسال" class="sendsms">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <th ><input type="checkbox" id="chk-1" class="clncheckAll"></th>
                                        <th>الاسم</th>
                                        <th>حالة الحجز</th>
                                        <th>الشركة</th>
                                        <th>الوظيفة</th>
                                        <th>الموظف</th>
                                        <th>المشرف</th>
                                        <th>الملاحظات</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                    </tr>
                                    </thead>
                                    <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : 0 ?>">
                                    <tbody>
                                    <?php if(isset($clients)){ for($i=0;$i<count($clients);$i++){?>
                                        <tr id="task-1"
                                            class="task-list-row"
                                            data-priority="<?= $clients[$i]->Status_Name ?>">

                                            <td><input type="checkbox"   class="checkboxMy  <?php echo 'chk elem'.$i?>">
                                                <input type="hidden" class="dataID <?php echo 'custid'.$i?>" value="<?php echo $clients[$i]->customerCrmId?>">
                                            </td>

                                            <?php
                                            if ($statusData == 1)
                                                echo "<td><a href=".$url."users/Followedcustomer/".$clients[$i]->customerCrmId.">".$clients[$i]->customerCrmName."</td>";
                                            else
                                                echo "<td>".$clients[$i]->customerCrmName."</td>";
                                            ?>

                                            <th><?php echo $clients[$i]->Status_Name?></th>
                                            <th><?php echo $clients[$i]->customerCrmCompany?></th>
                                            <th><?php echo $clients[$i]->customerCrmJob?></th>

                                            <th><?php echo get_name($clients[$i]->userID,1)?></th>

                                            <th><?php $getId = get_row("usercrm",["userCrmId" =>$clients[$i]->userID],null); echo get_name($getId->userCrmSuper,1)?></th>
                                            <th><?php echo $clients[$i]->note?></th>
                                            <th><?php echo $clients[$i]->Follow_Date?></th>

                                            <th><?php echo date('h:i A', strtotime($clients[$i]->Follow_Time))?></th>


                                            <?php

                                            ?>
                                        </tr>
                                    <?php } }?>
                                    </tbody>
                                </table>


                            </div>

                        </div>

                    </div>


                </div>


                <br />


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
<script src="assets/js/d3.min.js"></script>
<script src="assets/js/c3.js"></script>

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
        var Data ='';
        var subject=$(".emailsubject").val();
        var content=$(".emailcontent").val();
        var Check=true;

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
                    alert(data);
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
        window.location.href = "<?= $url ?>users/client/<?= $statusData ?>/"+DateRange;
    });
    $(".reasign").click(function(){
        var base=$("#base").val();
        var resetcount=$("#resestcount").val();
        var emp;
        if($("#empID").val()!=null )
        {
            emp=$("#empID").val();
            var customerid='';
            for(var i=0;i<resetcount;i++)
            {
                if($('.elem'+i).is(":checked")){
                    customerid +=$('.custid'+i).val() + ',';
                }
            }
            $.ajax({
                type: "POST",
                url: base + "users/ReAssignTasks",
                data: ({
                    customerid:customerid,
                    emp:emp
                }),
                success: function (data) {
                    window.location.href = "<?php echo $url .'users/client/1/'.$date1.'@'.$date2?>";
                    alert("تم تعين المهام بنجاح");
                }
            });
        }
    });
</script>

</body>
</html>
