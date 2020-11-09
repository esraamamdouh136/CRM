<?php $this->load->view("header");?>
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:2%; margin-top:2%;">
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                إعدادات الرسائل النصية
                            </h3>

                        </div>
                    </div>
                </div>
                <?php
                if (isset($settings) && $settings !=null ){?>
                    <div class="container">
                        <div class="row no-gutters my-5">
                            <input type="hidden" value="<?=$settings->ID ?>" id="Update">
                            <div class="col-lg-12">
                                <div class="form-row mb-2">
                                    <label class="col-lg-2 col-form-label"> مقدم الخدمة </label>
                                    <div class="col-lg-6">
                                        <label class="col-lg-2 col-form-label">http://tekegy.org</label>
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المستخدم </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="UserID" value="<?= $settings->UserID ?>"
                                               placeholder="اسم المستخدم">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المرسل </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="SenderName" value="<?= $settings->SenderName?>" placeholder="اسم المرسل">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label">  كلمة المرور</label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" id="UserPassword"  value="<?= $settings->UserPassword?>"
                                               placeholder="كلمة المرور">
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="col-lg-12">
                                        <button class="btn btn-info mt-2 float-right update_Settings"> حفظ</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="container">
                        <div class="row no-gutters my-5">
                            <input type="hidden" value="0" id="Update">
                            <div class="col-lg-12">
                                <div class="form-row mb-2">
                                    <label class="col-lg-2 col-form-label"> مقدم الخدمة </label>
                                    <div class="col-lg-6">
                                        <label class="col-lg-2 col-form-label">http://tekegy.org</label>
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المستخدم </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="UserID" placeholder="اسم المستخدم">
                                    </div>

                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المرسل </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="SenderName"  placeholder="اسم المرسل">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label">  كلمة المرور</label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" id="UserPassword" placeholder="كلمة المرور">
                                    </div>
                                </div>
                                <div class="form-row mb-2">

                                    <div class="col-lg-12">
                                        <button class="btn btn-info mt-2 float-right update_Settings"> حفظ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.error').delay(1000).fadeOut(1000);
    });
    // update settings

    $(document).on("click", ".update_Settings", function () {
        debugger;
        var IsUpdate = $("#Update").val();
        var User = $("#UserID").val();
        var Sender = $("#SenderName").val();
        var Password = $("#UserPassword").val();
        var data = new FormData();
        data.append('Update', IsUpdate);
        data.append('UserID', User);
        data.append('SenderName', Sender);
        data.append('UserPassword', Password);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype: "json",
            url: "<?=$url?>SMS/SaveSMSSettings",
            data: data,
            success: function (doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['error'] == false) {
                    toastr.success(Dataarray['msg']);
                } else {
                    toastr.error(Dataarray['msg']);
                }
            }
        });
    });
</script>



</body>

</html>