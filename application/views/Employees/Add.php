<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 6%;">
    <div class="m-content">
        <div class="container">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="row ml-0 mr-0 mt-4 p-0">
                    <div class="col-lg-12">
                        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            اضافه مستخدم
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet m-portlet--tab">
                                <!--begin::Form-->
                                <?php echo form_open_multipart(base_url().'Employees/Create');

                                if(isset($error)){?>
                                    <div class="form-group error" style="color:red;text-align:center">
                                        <?php echo $error?>
                                    </div>
                                <?php }
                                ?>
                                <?php
                                if(isset($success)){?>
                                    <div class="form-group error" style="color:Green;text-align:center">
                                        <?php echo $success?>
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
                                                <input type="text" value="" name="name" class="form-control"
                                                       placeholder="الاسم" required>
                                            </div>
                                        </div>
                                        <label for="example-search-input"
                                               class="col-lg-2 col-form-label">التليفون</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="entypo-phone"></i></span>
                                                <input type="text" value="" name="phone" class="form-control"
                                                       placeholder="التلفون" required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="userid" value="">

                                    <div class="form-group m-form__group row">
                                        <label for="example-email-input" class="col-lg-2 col-form-label">البريد
                                            الالكترونى</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="entypo-mail"></i></span>
                                                <input type="email" value="" name="email" class="form-control"
                                                       placeholder="الايميل" required>
                                            </div>
                                        </div>
                                        <label for="example-url-input"
                                               class="col-lg-2 col-form-label">العنوان</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-address"></i></span>
                                                <input type="text" value="" name="address" class="form-control"
                                                       placeholder="العنوان" required>
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
                                                    <option value="2">مشرف</option>
                                                    <option value="3">موظف</option>
                                                    <option value="4">إدارى</option>
                                                </select>
                                            </div>
                                        </div>
                                        <label for="example-date-input" class="col-lg-2 col-form-label">تاريخ
                                            الميلاد</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-calendar"></i></span>
                                                <input type="text" value="" name="birthdate"
                                                       class="DatebakerInput form-control datepicker"
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
                                                <input type="text" value="" name="joinDate"
                                                       class="DatebakerInput form-control datepicker"
                                                       placeholder="تاريخ التعيين" data-format="yyyy-mm-dd" required>
                                            </div>
                                        </div>


                                        <label for="example-datetime-local-input"
                                               class="col-lg-2 col-form-label">عدد
                                            الرسائل المسموح بها </label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="entypo-attention"></i></span>
                                                <input type="number" name="nmess" min="1" value="10"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>




                                    <div class="form-group m-form__group row">
                                        <label for="example-month-input"
                                               class="col-lg-2 col-form-label">المرتب</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="number" value="" name="salary" class="form-control"
                                                       min="0" placeholder="المرتب" required>
                                            </div>
                                        </div>
                                        <label for="example-month-input" class="col-lg-2 col-form-label">نسبه زياد
                                            المرتب</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">

                                                <input type="number" value="" name="annualInc" class="form-control"
                                                       min="0" placeholder="نسبة زياده المرتب" required>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-row m-form__group">
                                        <label for="example-week-input" class="col-lg-2 col-form-label">نسبه زياده
                                            الحجوزات</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="number" value="" name="target" class="form-control"
                                                       min="0" placeholder="نسبة الزيادة على عدد الحجوزات" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="Super" style="display: none;">
                                            <div  class="row">
                                                <label for="example-week-input"
                                                       class="col-lg-4 col-form-label text-right">المشرف</label>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <select name="supervisor" class="form-control" id="supervisor">
                                                            <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                                                                <option value="<?php echo $supers[$i]->ID?>">
                                                                    <?php echo $supers[$i]->Name?></option>
                                                            <?php } }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="m-form__group form-group" id="perDiv" style="display:none;">
                                            <hr>
                                            <label for="" style="font-size:18px;">الصلاحيات </label>
                                            <div class="m-checkbox-inline w-100">
                                                <div class="row">
                                                    <?php
                                                    if (isset($permissions) && !is_null($permissions) )
                                                        for ($i=0;$i<count($permissions);$i++){?>
                                                            <div class="col-lg-4">
                                                                <label class="m-checkbox">
                                                                    <input type="checkbox" style="width: max-content;"
                                                                           name="permissions[]"
                                                                           value="<?php echo $permissions[$i]->Code ?>"
                                                                           id="minimal-checkbox-1"><?php echo $permissions[$i]->Name ?>
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
                                                   placeholder="رقم المنفذ" value="587">
                                        </div>
                                        <label for="example-week-input" class="col-lg-2 col-form-label"> خادم
                                            البيانات
                                        </label>
                                        <div class="col-lg-4">
                                            <input type="text" name="mailserver" class="form-control"
                                                   placeholder="خادم البيانات">
                                        </div>

                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-time-input" class="col-lg-2 col-form-label"> اسم
                                            المستخدم</label>
                                        <div class="col-lg-4">
                                            <input type="email" name="usermail" class="form-control"
                                                   placeholder="إسم المستخدم">
                                        </div>
                                        <label for="example-time-input" class="col-lg-2 col-form-label"> كلمه السر
                                        </label>
                                        <div class="col-lg-4">
                                            <input type="password" name="userpassword" class="form-control"
                                                   placeholder="كلمة المرور">
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <div class="m-form__group row" style="margin-right: 20px">
                                                <div class="col-lg-12">
                                                    <div class="d-flex mb-2">
                                                        <label for="example-time-input" class="col-lg-3 col-form-label"> اسم
                                                            المستخدم</label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="entypo-user"></i></span>
                                                                <input id="username" name="username" type="text" value=""
                                                                       class="form-control" placeholder="اسم المستخدم" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <label for="example-time-input" class="col-lg-3 col-form-label"> كلمه السر
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="entypo-login"></i></span>
                                                                <input type="password" name="password" class="form-control"
                                                                       minlenght="6" placeholder="كلمة السر">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                            <div class="border d-flex justify-content-center">
                                                <img id="blah" type="image" src="" alt="">

                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <input type="file" id="imgInp" name="imgInp">
                                            </div>

                                        </div>
                                    </div>


                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                </div>
                                                <div class="col-lg-10">

                                                    <input type="submit" class="btn btn-success px-5 float-right" value="حفظ" />
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
        } else if ($(this).val() == 4) {
            Superdiv.style.display = "none";
            per.style.display = "block";
            Super.required = false;
        }else{
            Superdiv.style.display = "none";
            per.style.display = "none";
            Super.required = true;
        }
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });




</script>



</body>

</html>