<?php $this->load->view("header"); ?>
<div class="contains">
    <div class="row">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    تعديل المستخدم
                </div>
            </div>
            <div class="panel-body">
                <form enctype="multipart/form-data" class="form-horizontal form-groups-bordered" id="contactus-form" method="post">
                    <?php
                    if(isset($error)){?>
                        <div class="form-group error" style="color:red;text-align:center">
                            <?php echo $error?>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if(isset($success)){?>
                        <div class="form-group error" style="color:Green;text-align:center">
                            <?php echo $success ?>
                        </div>
                    <?php }
                    ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> الاسم</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-user"></i></span>
                                <input type="text" value="<?php echo $user[0]->userCrmName?>" name="name" class="form-control" placeholder="الاسم" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">التليفون</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-phone"></i></span>
                                <input type="text" value="<?php echo $user[0]->userCrmPhone?>" name="phone" class="form-control" placeholder="التلفون" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="<?php echo $user[0]->userCrmId ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">البريد الالكتروني</label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-mail"></i></span>
                                <input type="email" value="<?php echo $user[0]->userCrmEmail?>" name="email" class="form-control" placeholder="الايميل" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">العنوان</label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-address"></i></span>
                                <input type="text" value="<?php echo $user[0]->userCrmAddress?>" name="address" class="form-control" placeholder="العنوان" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">تاريخ الميلاد</label>

                        <div class="col-sm-5">
                            <div class="input-g111roup">
                                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                <input type="text" value="<?php echo $user[0]->userCrmBirthDate?>" name="birthdate" class="form-control datepicker"  placeholder="تاريخ الميلاد" data-format="yyyy-mm-dd" required>
                            </div>
                        </div>
                    </div>
                    <?php if(!isset($super)){?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">المشرف</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="entypo-user"></i></span>
                                    <select name="supervisor"class="form-control" required>
                                        <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){
                                            if($supers[$i]->userCrmId==$user[0]->userCrmSuper)
                                            {
                                                ?>
                                                <option value="<?php echo $supers[$i]->userCrmId?>" selected><?php echo $supers[$i]->userCrmName?></option>
                                            <?php }else{?>
                                                <option value="<?php echo $supers[$i]->userCrmId?>"><?php echo $supers[$i]->userCrmName?></option>
                                            <?php }} }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">تاريخ التعيين</label>

                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                <input type="text" value="<?php echo $user[0]->userCrmJoinDate?>" name="joinDate" class="form-control datepicker"  placeholder="تاريخ التعيين" data-format="yyyy-mm-dd" required>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> عددالرسائل المسموحه له</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="entypo-attention"></i></span>
                                <input type="number" min="1" max="20" value="<?php echo $user[0]->num_message?>" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"> الصلاحيات</label>
                        <div class="col-sm-3">
                            <ul class="icheck-list">
                                <li>
                                    <input tabindex="5" <?= (check_permission_user($userid, 1)) ? "checked" : "" ?> name="alerts" type="checkbox" class="icheck" id="minimal-checkbox-1">
                                    <label for="minimal-checkbox-1">تنبيهات الكل</label>
                                </li>
                                <li>
                                    <input tabindex="6" <?= (check_permission_user($userid, 2)) ? "checked" : "" ?>  name="acceptmess" type="checkbox" class="icheck" id="minimal-checkbox-2">
                                    <label for="minimal-checkbox-2">الموافقة على الرسائل</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 3)) ? "checked" : "" ?> name="uploadfile" class="icheck" id="minimal-checkbox-3">
                                    <label for="minimal-checkbox-3">رفع ملف مهام</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 4)) ? "checked" : "" ?> name="assigntask" class="icheck" id="minimal-checkbox-4">
                                    <label for="minimal-checkbox-4">تعيين مهام(للكل)</label>
                                </li>
                                <li>
                                    <input tabindex="6" <?= (check_permission_user($userid, 5)) ? "checked" : "" ?> type="checkbox" name="pemp" class="icheck" id="minimal-checkbox-11">
                                    <label for="minimal-checkbox-11"> موظفين</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 6)) ? "checked" : "" ?> class="icheck" name="psuper" id="minimal-checkbox-12">
                                    <label for="minimal-checkbox-12"> مشرفين</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 7)) ? "checked" : "" ?> class="icheck" name="complains" id="minimal-checkbox-13">
                                    <label for="minimal-checkbox-13"> استقبال الشكاوي </label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="icheck-list">
                                <li>
                                    <input tabindex="5" <?= (check_permission_user($userid, 8)) ? "checked" : "" ?> type="checkbox" name="instr" class="icheck" id="minimal-checkbox-5">
                                    <label for="minimal-checkbox-5"> ارسال تعليمات للكل</label>
                                </li>
                                <li>
                                    <input tabindex="6" <?= (check_permission_user($userid, 9)) ? "checked" : "" ?> type="checkbox" name="services" class="icheck" id="minimal-checkbox-6">
                                    <label for="minimal-checkbox-6"> المنتجات/الخدمات وطرق الشحن</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 10)) ? "checked" : "" ?> class="icheck" name="databas" id="minimal-checkbox-7">
                                    <label for="minimal-checkbox-7">تحميل قاعدة البيانات</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 11)) ? "checked" : "" ?> class="icheck" name="reports" id="minimal-checkbox-8">
                                    <label for="minimal-checkbox-8">التقارير الكاملة </label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 12)) ? "checked" : "" ?> class="icheck" name="panel" id="minimal-checkbox-9">
                                    <label for="minimal-checkbox-9">تعديل لوحة التحكم</label>
                                </li>
                                <li>
                                    <input type="checkbox" <?= (check_permission_user($userid, 13)) ? "checked" : "" ?> class="icheck" name="company" id="minimal-checkbox-10">
                                    <label for="minimal-checkbox-10">بيانات الشركة</label>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">المرتب</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" value="<?php echo $user[0]->userCrmSalary?>" name="salary" class="form-control" min="0" placeholder="المرتب" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">نسبة زيادة المرتب السنوية</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">%</span>
                                <input type="number" value="<?php echo $user[0]->userCrmAnnInc?>" name="annualInc" class="form-control" min="0" placeholder="نسبة زياده المرتب" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">نسبة الزيادة على عدد الحجوزات </label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">%</span>
                                <input type="number" value="<?php echo $user[0]->userCrmSellInc?>" name="target" class="form-control" min="0" placeholder="نسبة الزيادة على عدد الحجوزات" required>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <?php if(isset($super)){?>
                    <input type="hidden" name="job" value="2">
                    <input type="hidden" name="supervisor" value="0">
                <?php }else{?>
                    <input type="hidden" name="job" value="3">
                <?php }?>
                <div class="form-group">
                    <label class="col-sm-3 control-label">اسم المستخدم</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-user"></i></span>
                            <input type="text" value="<?php echo $user[0]->userCrmUserName?>" name="username" class="form-control" placeholder="اسم المستخدم" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"> كلمه السر</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-login"></i></span>
                            <input type="password" name="password" class="form-control" minlenght="6"  placeholder="كلمة السر" required>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <button type="button" id="edit_user" class="btn btn-blue esbutton" >حفظ</button>
                <br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<br />
</div>
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
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        $('.error').delay(2000).fadeOut(1000);
    });

    $("#edit_user").click(function(){

        var name=$('[name=name]').val();
        var userid=$('[name=userid]').val();

        var phone=$('[name=phone]').val();
        var email=$('[name=email]').val();
        var birthdate=$('[name=birthdate]').val();
        var job=$('[name=job]').val();
        var joinDate=$('[name=joinDate]').val();
        var salary=$('[name=salary]').val();
        var annualInc=$('[name=annualInc]').val();
        var supervisor=$('[name=supervisor]').val();
        var target=$('[name=target]').val();
        var username=$('[name=username]').val();

        var password=$('[name=password]').val();
        var address=$('[name=address]').val();
        var base=$("#base").val();

        if(name=="" || phone==""|| email=="" || birthdate=="" || job=="" || joinDate=="" || salary==""
            || annualInc=="" || supervisor=="" || target=="" || username=="" )
        {
            toastr.error("كل البيانات مطلوبه");
            return false;
        }

        var formData = new FormData($("#contactus-form")[0]);
        $.ajax({
            type: "POST",
            url: base+"users/updateUser",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data==1)
                {
                    toastr.success("تم تعديل المستخدم بنجاح");
                }else if(data==3)
                {
                    toastr.error("كل البيانات مطلوبه11");
                }
                else
                {
                    toastr.error("هذا البريد الالكتروني او اسم المستخدم موجود من قبل");
                }
            }
        });

    });
</script>
</body>
</html>