<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:2%; margin-top:2%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">


                <form method="post"  action="<?=$url?>users/update_user" class="form-horizontal form-groups-bordered">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label font">اسم المستخدم</label>

                        <div class="col-sm-5">
                            <input type="text" name="uname" class="form-control" id="field-1"  value="<?=$user[0]->UserName?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label font">كلمه السر</label>

                        <div class="col-sm-5">
                            <input type="password" name="pass" class="form-control" id="field-2" >
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
                        <button  type="submit" class="btn btn-primary btn-green" style="margin-right:50%" >
                            حفظ
                        </button>
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
</script>

</body>
</html>