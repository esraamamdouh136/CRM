<?php $this->load->view("header");?>
<div class="contains">
    <div class="row">
        <div class="es-radio">

            <?php if($_SESSION["usertype"] == 1 || $_SESSION["usertype"] == 2){?>
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
                <?php if ($_SESSION["usertype"] == 1){?>
                    <th>إسم الموظف</th>
                    <th>إسم المشرف</th>
                <?php } elseif ($_SESSION["usertype"] == 2){?>
                    <th>إسم الموظف</th>
                <?php }?>
            </tr>
            </thead>
            <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : "0" ?>">
            <tbody>
            <?php if(isset($clients)){ for($i=0;$i< count($clients);$i++){
                $status = 1;

                ?>
                <tr id="task-1" class="task-list-row" data-priority="<?php echo $status?>">

                    <td><input type="checkbox"   class="checkboxMy  <?php echo 'chk elem'.$i?>">
                        <input type="hidden" class="dataID <?php echo 'custid'.$i?>" value="<?php echo $clients[$i]->customerCrmId?>">
                    </td>

                    <td><a href="<?php echo $url.'users/customer/'.$clients[$i]->customerCrmId?>"><?php echo $clients[$i]->customerCrmId?></a></td>
                    <th><a href="<?php echo $url.'users/customer/'.$clients[$i]->customerCrmId?>"><?php echo $clients[$i]->customerCrmName?></th>
                    <th><?php echo $clients[$i]->customerCrmPhone?></th>
                    <th><?php echo $clients[$i]->customerCrmEmail?></th>
                    <th><?php echo $clients[$i]->Status_Name?></th>
                    <th><?php echo $clients[$i]->customerCrmCompany?></th>
                    <th><?php echo $clients[$i]->customerCrmJob?></th>
                    <?php if ($_SESSION["usertype"] == 1){?>
                        <th><?php echo get_name($clients[$i]->userID,1)?></th>
                        <th><?php $getId = get_row("usercrm",["userCrmId" =>$clients[$i]->userID],null) ; echo get_name($getId->userCrmSuper,1)?></th>
                    <?php } elseif ($_SESSION["usertype"] == 2){?>
                        <th><?php echo get_name($clients[$i]->userID,1)?></th>
                    <?php }?>
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
           // alert(customerid);
            $.ajax({
                type: "POST",
                url: base + "users/ReAssignTasks",
                data: ({
                    customerid:customerid,
                    emp:emp
                }),
                success: function (data) {
                    window.location.href = base + "users/ViewDelayedMission";
                    alert("تم تعين المهام بنجاح");
                }
            });
        }
    });


</script>
</body>

</html>