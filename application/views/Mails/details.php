<?php  $this->load->view("header");?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin: 2% 10% 0% 3%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--full-height no-padding ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            تفاصيل الايميل
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <div class="m-portlet__body ">
                <div class="m-widget3">
                    <?php
                    if (isset($MailDetails) && !is_null($MailDetails)){?>
                        <div class="Email_sent">

                            <div class="m-widget3__item">

                                <div class="m-widget3__header">
                                    <div class="m-widget3__user-img">
                                        <?php $Image = get_Emp_ProfileImage($MailDetails[0]->UserID); ?>
                                        <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="m-widget3__img">
                                    </div>
                                    <div class="m-widget3__info">
                                            <span class="m-widget3__username">
                                                <b>من :</b><?php echo get_Emp_name($MailDetails[0]->UserID);?>
                                            </span><br>
                                        <span class="m-widget3__time image">
                                                <span><b class="mr-1"> الى :</b>
                                                    <?= $MailDetails[0]->Mail ?> </span>
                                            </span><br>
                                        <span class="m-widget3__time image">
                                                <span><b class="mr-1"> عنوان :</b>
                                                   <?php echo $MailDetails[0]->Title;?></span>
                                            </span>
                                    </div>
                                    <div >
                                        <button class="btn btn-info btn-block" name="" data-toggle="modal"
                                                data-target="#newEmail"> إعادة الارسال </button>
                                        <span class="m-widget3__status d-flex justify-content-center">
                                            <p class="pr-2"><?php echo $MailDetails[0]->Date;?></p>
                                          <i class="flaticon-calendar-with-a-clock-time-tools"></i>

                                        </span>
                                    </div>



                                </div>



                            </div>
                            <div class="m-widget3__body">
                                <p class="m-widget3__text w-75 text-break">


                                    <?php echo htmlspecialchars_decode($MailDetails[0]->Message);?>


                                </p>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" data-keyboard="false" data-backdrop="static" id="newEmail" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="add-label">ارسال ايميل </h4>
            </div>




            <form method="post" action="<?= base_url().'CRM_Mails/sendMailWithAttach'?>" enctype="multipart/form-data">

                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <label for="mto[]">الي</label>
                                <input type="email" id="SelectWord" name="To" class="form-control"  value="<?= $MailDetails[0]->Mail ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="source_type">العنوان</label>
                                <input class="form-control" name="title" required id="Mailsubject">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row add-only">
                                <label for="source_id">الموضوع</label>
                                <div class="col-lg-12">
                                    <textarea class="form-control ckeditor" id="Mailcontent" name="Mailcontent"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            إرفاق الملف : <input type="file" id="file[]" accept="application/pdf,image/*" name="file[]" multiple>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="sendMail" class="btn btn-info submit-form">ارسال</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    //send mail with attachment Files




</script>







</body>
</html>