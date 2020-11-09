<?php $this->load->view("header");?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-top:2%; margin-right:9%; margin-left:2%;">
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                بيانات الشركه
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="container">

                    <?php echo form_open_multipart(base_url().'users/update_company');?>



                    <div class="row no-gutters my-5">
                        <div class="col-lg-6">
                            <div class="form-row mb-2">
                                <label class="col-lg-2 col-form-label">اسم الشركه</label>
                                <div class="col-lg-10">
                                    <input type="text" required name="name" value="<?php echo $company[0]->settingcrmName?>" class="form-control" id="field-1"
                                           placeholder="الاسم">
                                </div>
                            </div>
                            <div class="form-row  mb-2">
                                <label class="col-lg-2 col-form-label"> التليفون </label>
                                <div class="col-lg-10">
                                    <input type="text" name="phone" required value="<?php echo $company[0]->settingcrmPhone?>" class="form-control" id="field-1"
                                           placeholder="التليفون" required>
                                </div>
                            </div>
                            <div class="form-row  mb-2">
                                <label class="col-lg-2 col-form-label"> الفاكس </label>
                                <div class="col-lg-10">
                                    <input type="text" name="fax" required value="<?php echo $company[0]->settingcrmFax?>" class="form-control" id="field-1"
                                           placeholder="الفاكس">
                                </div>
                            </div>
                            <div class="form-row  mb-2">
                                <label class="col-lg-2 col-form-label"> الايميل </label>
                                <div class="col-lg-10">
                                    <input type="email" name="email" required value="<?php echo $company[0]->settingcrmEmail?>" class="form-control"
                                           id="field-1" placeholder="البريد">
                                </div>
                            </div>
                            <div class="form-row  mb-2">
                                <div class="col-lg-12">
                                    <input type="submit" class="btn btn-info mt-2 float-right w-25 update_company" value="حفظ"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center">
                            <h4 class="text-center"> لوجو الشركه</h4>
                            <div class="fileinput-new thumbnail " style="width: 200px; height: auto;margin-right: 30%;" data-trigger="fileinput">
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




                    </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>




<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#ImagePreview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#fileToUpload").change(function() {
        readURL(this);
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