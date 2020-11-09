<?php $this->load->view("header");?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top:2%; margin-right:9%; margin-left:2%;">
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3>بيانات الشركه</h3>
                        </div>
                    </div>
                </div>
                <div class="container">





                    <div class="row no-gutters my-3">
                        <div class="col-lg-12 company_data">
                            <div class="border p-3">
                                <div class="form-row mb-2">
                                    <p class="col-lg-1">اسم الشركه :</p>
                                    <div class="col-lg-9">
                                        <p name="name"  id="field-1" ><?php echo $company[0]->settingcrmName?></p>
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <p class="col-lg-1"> التليفون : </p>
                                    <div class="col-lg-9">
                                        <p name="phone" required  id="field-1" ><?php echo $company[0]->settingcrmPhone?></p>
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <p class="col-lg-1">  الفاكس :</p>
                                    <div class="col-lg-9">
                                        <p  name="fax" required id="field-1"><?php echo $company[0]->settingcrmFax?></p>
                                    </div>
                                </div>
                                <div class="form-row  mb-2">
                                    <p class="col-lg-1"> الايميل : </p>
                                    <div class="col-lg-">
                                        <p  name="email" id="field-1"><?php echo $company[0]->settingcrmEmail?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart(base_url().'users/update_company');?>
                    <div class="row ">
                        <div class="col-lg-6 my-3 text-center border p-3">
                            <h4 class="text-center"> لوجو الشركه</h4>
                            <div class="fileinput-new thumbnail mx-auto" style="width:104px; height: auto;" data-trigger="fileinput">
                                <img id="ImagePreview" src="<?php echo $url.'design/assets/images/'.$company[0]->settingcrmLogo?>" alt="logo">
                            </div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" value="<?php echo $url.'design/assets/images/'.$company[0]->settingcrmLogo?>" name="fileToUpload"
                                               id="fileToUpload" accept="image/*">
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 my-3 bg-login border p-4">
                            <h4 class="text-center">  خلفيه تسجيل الدخول </h4>
                            <div class="fileinput-new thumbnail mx-auto" style="width:104px; height: auto; " data-trigger="fileinput">
                                <img id="ImagePreview2" src="<?php echo $url.'design/assets/images/'.$company[0]->loginbg ?>" alt="logo">
                            </div>
                            <span class="btn btn-white btn-file d-flex justify-content-center">
                                    <span class="fileinput-new">Select image
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file"  name="fileToUpload2" value="<?php echo $url.'design/assets/images/'.$company[0]->loginbg ?>"
                                               id="fileToUpload2" accept="image/*">
                                    </span>
                                </span>
                        </div>
                    </div>
                    <div class="row  mb-2">
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-info mt-2 float-right w-25 update_company" style="cursor: pointer" value="حفظ"/>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    function readURL(input,img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(img).attr('src', e.target.result);
            };


            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#fileToUpload").change(function() {
        readURL(this,$('#ImagePreview'));
    });
    $("#fileToUpload2").change(function() {
        readURL(this,$('#ImagePreview2'));
    });


</script>
<script>

    $(document).ready(function () {
        $('.error').delay(1000).fadeOut(1000);
    });

    // $(document).on("click", ".update_company", function () {
    //     var name = $("[name=name]").val();
    //     var phone = $("[name=phone]").val();
    //     var fax = $("[name=fax]").val();
    //     var email = $("[name=email]").val();
    //
    //
    //     alert($("#fileToUpload").prop('files')[0]);
    //     var newImg = $("[name=fileToUpload]");
    //
    //     var data = new FormData();
    //     if (typeof newImg.prop('files')[0] == 'undefined') {
    //         data.append('pic', 0);
    //     } else {
    //         data.append('pic', 1);
    //     }
    //     data.append('img', newImg.prop('files')[0]);
    //     data.append('name', name);
    //     data.append('email', email);
    //     data.append('fax', fax);
    //     data.append('phone', phone);
    //     var base = $("#base").val();
    //     //add td to table and attech the class names to them
    //
    //     $.ajax({
    //         type: 'post',
    //         processData: false, // important
    //         contentType: false, // important
    //         datatype: "json",
    //         url: base + "users/update_company",
    //         data: data,
    //         success: function (doc) {
    //             var Dataarray = $.parseJSON(doc);
    //             if (Dataarray['error'] == false) {
    //
    //                 toastr.success(Dataarray['msg']);
    //             } else {
    //                 toastr.error(Dataarray['msg']);
    //             }
    //         }
    //     });
    // });
</script>

</body>

</html>