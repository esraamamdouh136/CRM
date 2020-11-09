<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:2%; margin-top:2%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">

                <?php echo form_open_multipart(base_url().'users/update_user');?>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label font">اسم المستخدم</label>

                            <div class="col-sm-12">
                                <input type="text" name="uname" class="form-control"  id="field-1" required  value="<?=$user[0]->UserName?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label font">كلمه السر</label>

                            <div class="col-sm-12">
                                <input type="password" name="pass" class="form-control" id="field-2" required >
                            </div>
                        </div>

                        <?php
                        if(isset($error)){?>
                            <div class="form-group error" style="color:red;text-align:center">
                                <?php echo $error?>
                            </div>
                        <?php }

                        if(isset($updated)){?>
                            <div class="form-group error" style="color:green;text-align:center">
                                <?php echo $updated?>
                            </div>
                        <?php }
                        ?>
                        <div class="form-group">
                            <button  type="submit" class="btn btn-primary btn-green float-right px-5">
                                حفظ
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="border d-flex justify-content-center">
                            <img id="blah" src="<?=(isset($user[0]->Image) && !is_null($user[0]->Image))? $url."ProfielsImages/".$user[0]->Image:"" ?>" alt="your image" >

                        </div>
                        <div class="d-flex justify-content-center">
                            <input type='file' id="imgInp" name="imgInp"  accept="image/x-png,image/gif,image/jpeg" />
                        </div>
                    </div>
                </div>
                </form>


            </div>
        </div>

    </div>
</div>







</div>




<script type="text/javascript">
    $(document).ready( function() {
        $('.error').delay(2000).fadeOut(2000);
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


    function myFunction(e) {
        if (e.keyCode >= 65 && e.keyCode<=90 ){
            alert("asdas");
        }else{
            return false;
        }
    }


    $("#field-1").on("keydown",function (event) {
        debugger;
        let Code = event.keyCode;
        if ((Code >= 65 && Code <= 90) || Code == 8){
            return true;
        }else{
            return false;
        }
    });

</script>

</body>
</html>