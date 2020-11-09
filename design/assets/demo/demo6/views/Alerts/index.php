<?php  $this->load->view("header");?>

<div style="margin:3%">
    <div class="row">
        <div class="col-sm-12">

            <ul class="nav nav-tabs bordered">
                <!-- available classes "bordered", "right-aligned" -->
                <li class="active">
                    <a href="#home" data-toggle="tab">
                        <span>مكالمات فائتة</span>
                        <span class="badge badge-secondary"><?= isset($calls) ? count($calls) : 0 ?></span>
                    </a>
                </li>
                <?php $per=get_pre($_SESSION["userid"],1);
                if($_SESSION["usertype"]==1 || $per==1 )
                {?>
                    <li>
                        <a href="#profile" data-toggle="tab">
                            <span>رسائل</span>
                            <span class="badge badge-secondary"><?= isset($messages) ? count($messages) : 0 ?></span>

                        </a>
                    </li>
                <?php }?>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="home">

                    <table  id="myTable" class="table table-striped display data-table">

                        <thead>

                        <tr>
                            <th>الوظيفة</th>
                            <th>من</th>
                            <th>العميل</th>
                            <th> ارسال تنبيه للموظف  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; تعيين موظف اّخر</th>



                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($calls)){
                            for($i=0;$i<count($calls);$i++){
                                if($calls[$i]->customerCrmSuper==0)
                                {
                                    $job="مشرف";
                                }
                                else
                                {
                                    $job="موظف";
                                }
                                ?>
                                <tr id="<?php echo 't-'.($i+1)?>">
                                    <td> <?php echo $job?></td>
                                    <!--                                    hear-->
                                    <td ><?php echo get_name($calls[$i]->customerCrmEmp,1)?></td>
                                    <td><?php echo get_name($calls[$i]->customerCrmId,2)?></td>
                                    <td><button  class="btn btn-green sendbtn" Emp ="<?php echo $calls[$i]->customerCrmEmp;?>" customer="<?php echo $calls[$i]->customerCrmId?>">ارسال تنبيه للموظف</button>
                                        <button onclick="$('.RowData').text($(this).parents('tr').attr('id'))" class="btn btn-green senditem" data-toggle="modal" data-target="#exampleModal2" customer="<?php echo $calls[$i]->customerCrmId?>">تعيين موظف اخر</button>
                                    </td>

                                </tr>
                            <?php } }?>

                        </tbody>

                    </table>



                </div>
                <div class="tab-pane" id="profile">


                    <!--<div class="table-responsive">-->
                    <table id="myTableDaily" class="table table-striped display data-table">

                        <thead>

                        <tr>
                            <th>من</th>
                            <th>الى</th>
                            <th>العنوان</th>

                            <th>ارسال</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($messages)){  for($i=0;$i<count($messages);$i++){?>
                            <tr>
                                <td><?php echo get_name($messages[$i]->CrmMessagesFrom,1)?></td>
                                <td>
                                    <?php if($messages[$i]->CrmMessagesTo==0){

                                        echo get_name($messages[$i]->CrmMessagesCustomer,2);
                                    }
                                    else
                                    {
                                        echo get_name($messages[$i]->CrmMessagesTo,1);
                                    }
                                    ?>
                                </td>

                                <td>

                                    <?php echo $messages[$i]->CrmMessagesTitle?>

                                </td>

                                <td>
                                    <a href="<?php echo $url.'users/mess_details/'.$messages[$i]->CrmMessagesId?>" class="btn btn-large btn-blue">التفاصيل</a>
                                    <button class="btn btn-green sendmes" messid="<?php echo $messages[$i]->CrmMessagesId?>" >ارسال</button></td>
                            </tr>
                        <?php } }?>
                        </tbody>
                    </table>



                </div>


            </div>


            <div class="modal fade" id="mysModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body" style="height: 150px;">
                            <form id="mainForm" name="mainForm" method="post" action="">
                                <p class="pull-left col-md-12">
                                <div class="col-md-4">
                                    <label class="pull-left">من :</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="pull-left" >اسراء</label>
                                </div>
                                </p>
                                <br>
                                <p class="pull-left col-md-12">
                                <div class="col-md-4">
                                    <label class="pull-left">الى :</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="pull-left" >مادونا</label>
                                </div>

                                </p>
                                <br>
                                <p class="pull-left col-md-12">
                                <div class="col-md-4">
                                    <label class="pull-left">العنوان :</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="pull-left" >مدينة نصر</label>
                                </div>
                                </p>
                                <br>
                                <p class="pull-left col-md-12">
                                <div class="col-md-4">
                                    <label class="pull-left">المحتوى :</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="pull-left" >اي كلام</label>
                                </div>


                                </p>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>



            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>تعيين موظف اّخر</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>

                                <span style="display: none" class="RowData"></span>
                            </button>
                        </div>
                        <?php		$startTime = date("H:i:s");
                        $plus='+'.$time[0]->settingcrmTimeMinute.' minutes';
                        $cenvertedTime = date('H:i:s',strtotime($plus,strtotime($startTime)));
                        ?>
                        <div class="modal-body">
                            <form >
                                <input type="hidden" name="customerid" id="customerid">
                                <div class="form-group">
                                    <div class="es-radio1">
                                        <p>اعادة التعيين الى:</p>


                                        <select id="sel2" name="emp">
                                            <?php if(isset($emps)){  for($i=0;$i<count($emps);$i++){?>
                                                <option value="<?php echo $emps[$i]->userCrmId?>"><?php echo $emps[$i]->userCrmName?></option>
                                            <?php } }?>

                                        </select>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="date">التاريخ:</label>
                                                <input type="date" class="rdate"  value="<?php echo date("Y-m-d")?>" >

                                            </div>
                                            <div class="form-group">
                                                <label for="dates">الوقت</label>


                                                <div class="input-group">
                                                    <input type="time" class="rtime"  value="<?php echo $cenvertedTime ?>"  />

                                                    <div class="input-group-addon">
                                                        <!--<a href="#"><i class="entypo-clock"></i></a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">ملاحظات:</label>
                                        <textarea rows="4" cols="50" name="note" class="etextar3 form-control rcomment" id="message-text"></textarea>
                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-primary senda" data-dismiss="modal" onclick="deleteRowpopup()">ارسال</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
</div>




<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">


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
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script type="text/javascript">
    $(document).ready( function() {
        $('.error').delay(1000).fadeOut(1000);
    });

    $(document).on("click", ".sendbtn", function () {

        var base=$("#base").val();
        var cutomerid=$(this).attr("customer");
        var empid=$(this).attr("Emp");
        //add td to table and attech the class names to them
        var data = new FormData();

        data.append('customer', cutomerid);
        data.append('UserID', empid);

        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype:"json",
            url: base + "users/add_alert",
            data: data,
            success: function(doc) {

                if (doc==1) {

                    toastr.success("تم ارسال التنبيه بنجاح");
                }else{
                    toastr.error("حدث خطأ ما");
                }
            }
        });
    });
    $(document).on("click", ".senditem", function () {

        var base=$("#base").val();
        var cutomerid=$(this).attr("customer");
        $(".senda").attr("customer",cutomerid);
    });
    $(document).on("click", ".senda", function () {

        var base=$("#base").val();
        var cutomerid=$(this).attr("customer");
        var emps=$("#sel2").val();
        var date=$(".rdate").val();
        var time=$(".rtime").val();
        var comment=$(".rcomment").val();

        //add td to table and attech the class names to them
        var data = new FormData();

        data.append('customer', cutomerid);
        data.append('empid', emps);
        data.append('date', date);
        data.append('time', time);
        data.append('comment', comment);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype:"json",
            url: base + "users/reasgin",
            data: data,
            success: function(doc) {

                if (doc==1) {

                    toastr.success("تم اعاده التعين  بنجاح");
                }else{
                    toastr.error("حدث خطأ ما");
                }
            }
        });
    });


    $(document).on("click", ".sendmes", function () {

        var base=$("#base").val();
        var messid=$(this).attr("messid");
        var ele=$(this);

        //add td to table and attech the class names to them
        var data = new FormData();

        data.append('messid', messid);

        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype:"json",
            url: base + "users/active",
            data: data,
            success: function(doc) {

                if (doc==1) {

                    toastr.success("تم الارسال");
                    ele.parent().parent().remove();
                }else{
                    toastr.error("حدث خطأ ما");
                }
            }
        });
    });

</script>

</body>

</html>