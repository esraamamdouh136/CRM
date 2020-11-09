<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper"  style="margin-right: 8%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">
        <div class="container">

            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <!-- BEGIN: Aside Menu -->
                <!-- END: Aside Menu -->
                <div class="row ml-0 mr-0 mt-4 p-0">


                    <div class="col-12">
                        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            تعديل مستخدم
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--tab">


                                <!--begin::Form-->
                                <form class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data"
                                      action="<?=$url?>Employees/Modifier" id="contactus-form" method="post">
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
                                    <div class="m-portlet__body">

                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-lg-2 col-form-label">الاسم
                                            </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-user"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->Name?>" name="name"
                                                           class="form-control" placeholder="الاسم" required>
                                                </div>
                                            </div>
                                            <label for="example-search-input"
                                                   class="col-lg-2 col-form-label">التليفون</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-phone"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->Phone?>" name="phone"
                                                           class="form-control" placeholder="التلفون" required>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="UserID" value="<?php echo $user[0]->ID ?>">

                                        <div class="form-group m-form__group row">
                                            <label for="example-email-input" class="col-lg-2 col-form-label">البريد
                                                الالكترونى</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-mail"></i></span>
                                                    <input type="email" value="<?php echo $user[0]->Email?>"
                                                           name="email" class="form-control" placeholder="الايميل"
                                                           required>
                                                </div>
                                            </div>
                                            <label for="example-url-input"
                                                   class="col-lg-2 col-form-label">العنوان</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-address"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->Address?>"
                                                           name="address" class="form-control" placeholder="العنوان"
                                                           required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">

                                            <label for="example-password-input" class="col-lg-2 col-form-label">نوع
                                                المستخدم</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-user"></i></span>
                                                    <select name="type" class="form-control" required id="UserType">
                                                        <option value="2" <?= ($user[0]->Type==2) ? "selected" : "" ?>>
                                                            مشرف</option>
                                                        <option value="3" <?= ($user[0]->Type==3) ? "selected" : "" ?>>
                                                            موظف</option>
                                                        <option value="4" <?= ($user[0]->Type==4) ? "selected" : "" ?>>إدارى</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <label for="example-date-input" class="col-lg-2 col-form-label">تاريخ
                                                الميلاد</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-calendar"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->BirthDate?>"
                                                           name="birthdate" class="DatebakerInput form-control datepicker"
                                                           placeholder="تاريخ الميلاد" data-format="yyyy-mm-dd" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label for="example-date-input" class="col-lg-2 col-form-label">تاريخ
                                                التعيين</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-calendar"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->JoinDate?>"
                                                           name="joinDate" class="DatebakerInput form-control datepicker"
                                                           placeholder="تاريخ التعيين" data-format="yyyy-mm-dd" required>

                                                </div>
                                            </div>
                                            <label for="example-datetime-local-input" class="col-lg-2 col-form-label">عدد
                                                الرسائل المسموح بيها </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-attention"></i></span>
                                                    <input type="number" min="1" value="<?php echo $user[0]->num_message?>"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-month-input" class="col-lg-2 col-form-label"> $المرتب</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <input type="number" value="<?php echo $user[0]->Salary?>" name="salary"
                                                           class="form-control" min="0" placeholder="المرتب" required>
                                                </div>
                                            </div>
                                            <label for="example-month-input" class="col-lg-2 col-form-label">نسبه زياد
                                                المرتب</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">

                                                    <input type="number" value="<?php echo $user[0]->AnnInc?>"
                                                           name="annualInc" class="form-control" min="0"
                                                           placeholder="نسبة زياده المرتب" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">

                                            <label for="example-week-input" class="col-lg-2 col-form-label">نسبه زياده
                                                الحجوزات</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <input type="number" value="<?php echo $user[0]->SellInc?>"
                                                           name="target" class="form-control" min="0"
                                                           placeholder="نسبة الزيادة على عدد الحجوزات" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" id="Super" style="display: <?= ($user[0]->Type==3)?"block":"none" ?>;">
                                                <div  class="row">

                                                    <label for="example-week-input" class="col-lg-4 col-form-label text-right">المشرف</label>
                                                    <div class="col-lg-8">
                                                        <div class="input-group">
                                                            <select name="supervisor" class="form-control" id="supervisor">
                                                                <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                                                                    <option value="<?php echo $supers[$i]->ID?>"
                                                                        <?= ($user[0]->Super==$supers[$i]->ID) ? "selected" : "" ?>>
                                                                        <?php echo $supers[$i]->Name?></option>
                                                                <?php } }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="container">

                                            <div class="m-form__group form-group" id="perDiv"
                                                 style="display:<?= ($user[0]->Type>=3) ? "" : "none" ?>" ;>
                                                <hr>
                                                <label for="" class="mb-2" style="font-size:24px; margin-bottom: 2px;">الصلاحيات </label>
                                                <div class="m-checkbox-inline w-100">
                                                    <div class="row">
                                                        <?php
                                                        if (isset($UserPermissions) && !is_null($UserPermissions) )
                                                            for ($i=0;$i<count($UserPermissions);$i++){?>
                                                                <div class="col-lg-4">
                                                                    <label class="m-checkbox">
                                                                        <input tabindex="5" style="width: max-content;" name="permissions[]"
                                                                               value="<?php echo $UserPermissions[$i]->ID ?>"
                                                                            <?php echo ($UserPermissions[$i]->IsGranted == 1 )?  "checked" : "" ?>
                                                                               type="checkbox" class="icheck" id="minimal-checkbox-1">
                                                                        <label
                                                                                for="minimal-checkbox-1" style="font-size:18px;"><?php echo $UserPermissions[$i]->Name ?></label>
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            <?php  }

                                                        ?>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <hr>
                                        <div class="form-group m-form__group row">

                                            <label for="example-time-input" class="col-lg-2 col-form-label"> رقم التنفيذ
                                            </label>
                                            <div class="col-lg-4">
                                                <input type="number" min="0" name="portnumber" class="form-control"
                                                       placeholder="رقم المنفذ"
                                                       value="<?php echo (isset($MailServerConfig) && !is_null($MailServerConfig)&& count($MailServerConfig))?  $MailServerConfig[0]->Port : 587?>">
                                            </div>
                                            <label for="example-week-input" class="col-lg-2 col-form-label"> خادم البيانات
                                            </label>
                                            <div class="col-lg-4">
                                                <input type="text" name="mailserver" class="form-control"
                                                       placeholder="خادم البيانات"
                                                       value="<?php echo (isset($MailServerConfig) && !is_null($MailServerConfig)&& count($MailServerConfig))?  $MailServerConfig[0]->Mail_Server :""?>">
                                            </div>

                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-time-input" class="col-lg-2 col-form-label"> اسم
                                                المستخدم</label>
                                            <div class="col-lg-4">
                                                <input type="email" name="usermail" class="form-control"
                                                       placeholder="إسم المستخدم"
                                                       value="<?php echo (isset($MailServerConfig) && !is_null($MailServerConfig)&& count($MailServerConfig))?  $MailServerConfig[0]->Mail_Address :""?>">
                                            </div>
                                            <label for="example-time-input" class="col-lg-2 col-form-label"> كلمه السر </label>
                                            <div class="col-lg-4">
                                                <input type="password" name="userpassword" class="form-control"
                                                       placeholder="كلمة المرور"
                                                       value="<?php echo (isset($MailServerConfig) && !is_null($MailServerConfig) && count($MailServerConfig))?  $MailServerConfig[0]->Mail_Password :""?>">
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="form-group m-form__group row">
                                            <label for="example-time-input" class="col-lg-2 col-form-label"> اسم
                                                المستخدم</label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-user"></i></span>
                                                    <input type="text" value="<?php echo $user[0]->UserName?>"
                                                           name="username" class="form-control" placeholder="اسم المستخدم"
                                                           required>
                                                </div>
                                            </div>
                                            <label for="example-time-input" class="col-lg-2 col-form-label"> كلمه السر </label>
                                            <div class="col-lg-4">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="entypo-login"></i></span>
                                                    <input type="password" name="password" class="form-control"
                                                           minlenght="6" placeholder="كلمة السر">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                            <div class="m-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="submit" class="btn btn-success px-5 esbutton float-right"
                                                               value="حفظ">
                                                    </div>
                                                </div>
                                            </div>
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

</div>



<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script>
    $(document).on('change', "#UserType", function () {

        var Superdiv = document.getElementById("Super");
        var Super = document.getElementById("supervisor");
        var per = document.getElementById("perDiv");
        if ($(this).val() == 3) {
            Superdiv.style.display = "block";
            per.style.display = "block";
            Super.required = false;
            $(':checkbox.icheck').each(function() {
                this.checked = false;
            });
        } else if ($(this).val() == 4){
            Superdiv.style.display = "none";
            per.style.display = "block";
            Super.required = false;
            $(':checkbox.icheck').each(function() {
                this.checked = false;
            });

        }else {
            Superdiv.style.display = "none";
            per.style.display = "none";
            Super.required = true;
            $(':checkbox.icheck').each(function() {
                this.checked = false;
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.error').delay(2000).fadeOut(1000);
    });

    $("#edit_user").click(function () {

        var name = $('[name=name]').val();
        var userid = $('[name=userid]').val();

        var phone = $('[name=phone]').val();
        var email = $('[name=email]').val();
        var birthdate = $('[name=birthdate]').val();
        var job = $('[name=job]').val();
        var joinDate = $('[name=joinDate]').val();
        var salary = $('[name=salary]').val();
        var annualInc = $('[name=annualInc]').val();
        var supervisor = $('[name=supervisor]').val();
        var target = $('[name=target]').val();
        var username = $('[name=username]').val();
        var password = $('[name=password]').val();
        var address = $('[name=address]').val();
        var base = $("#base").val();

        if (name == "" || phone == "" || email == "" || birthdate == "" || job == "" || joinDate == "" ||
            salary == "" ||
            annualInc == "" || supervisor == "" || target == "" || username == "") {
            alert("كل البيانات مطلوبه");
            return false;
        }

        var formData = new FormData($("#contactus-form")[0]);
        $.ajax({
            type: "POST",
            url: base + "users/updateUser",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    alert("تم تعديل المستخدم بنجاح");
                } else if (data == 3) {
                    alert("كل البيانات مطلوبه");
                } else {
                    alert("هذا البريد الالكتروني او اسم المستخدم موجود من قبل");
                }
            }
        });

    });





</script>

</body>

</html>
