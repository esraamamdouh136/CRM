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
                                إعدادات البريد الإلكترونى

                            </h3>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($communication_settings) && $communication_settings !=null && count($communication_settings) >0){?>
                    <div class="container">
                        <div class="row no-gutters my-5">
                            <input type="hidden" value="<?=$communication_settings[0]->id ?>" id="Update">
                            <div class="col-lg-12">
                                <div class="form-row mb-2">
                                    <label class="col-lg-2 col-form-label"> خادم البيانات </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="mail-server" value="<?= $communication_settings[0]->Mail_Server ?>"
                                               placeholder=" خادم البيانات">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> رقم التنفيذ </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="port-number" value="<?= $communication_settings[0]->Port?>" placeholder="رقم التنفيذ">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المستخدم </label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" id="user-mail"  value="<?= $communication_settings[0]->Mail_Address?>"
                                               placeholder="اسم المستخدم">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> كلمه السر </label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" id="user-password" placeholder="كلمه السر" value="<?= $communication_settings[0]->Mail_Password?>">
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
                            <div class="col-lg-12">
                                <div class="form-row mb-2">
                                    <input type="hidden" value="0">
                                    <label class="col-lg-2 col-form-label"> خادم البيانات </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="mail-server" value=""
                                               placeholder=" خادم البيانات">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> رقم التنفيذ </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="port-number" value="" placeholder="رقم التنفيذ">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> اسم المستخدم </label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" id="user-mail" value=""
                                               placeholder="اسم المستخدم">
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <label class="col-lg-2 col-form-label"> كلمه السر </label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" id="user-password" value="" placeholder="كلمه السر">
                                    </div>
                                </div>
                                <div class="form-row mb-2">

                                    <div class="col-lg-12">
                                        <button class="btn btn-info mt-2 w-25 float-right update_Settings" value="حفظ"> حفظ</button>
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
        var uName = $("#user-mail").val();
        var IsUpdate = $("#Update").val();
        var uPass = $("#user-password").val();
        var portNo = $("#port-number").val();
        var mailServer = $("#mail-server").val();
        var data = new FormData();
        data.append('uName', uName);
        data.append('uPass', uPass);
        data.append('portNo', portNo);
        data.append('mailServer', mailServer);
        data.append('IsUpdate', IsUpdate);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype: "json",
            url: "<?=$url?>users/update_mail_settings",
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