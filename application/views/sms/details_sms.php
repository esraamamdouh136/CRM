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
                            تفاصيل الرساله النصيه
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <div class="m-portlet__body ">
                <div class="m-widget3">

                        <div class="Email_sent">

                            <div class="m-widget3__item">

                                <div class="m-widget3__header">
                                    <div class="m-widget3__user-img">

                                        <?php $Image = get_Emp_ProfileImage($SMSDetails->UserID); ?>
                                        <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="m-widget3__img">
                                    </div>
                                    <div class="m-widget3__info">
                                            <span class="m-widget3__username">
                                                <b>اسم الوظف :</b> <?= get_Emp_name($SMSDetails->UserID); ?>
                                            </span><br>
                                        <span class="m-widget3__time image">
                                                <span><b class="mr-1">اسم العميل :</b>
                                                   <?php echo get_name($SMSDetails->ClientID,2) ?> </span>
                                            </span><br>
                                        <span class="m-widget3__time image">
                                                <span><b class="mr-1"> رقم التليفون :</b><?php echo $SMSDetails->Phone?>
                                                  </span>
                                            </span>
                                    </div>

                                    <span class="m-widget3__status d-flex justify-content-center">
                                            <p class="pr-2"><?php echo $SMSDetails->Date?></p>
                                          <i class="flaticon-calendar-with-a-clock-time-tools"></i>

                                        </span>


                                </div>



                            </div>
                            <div class="m-widget3__body">
                                <p class="m-widget3__text w-75 text-break">
                                    <?php echo $SMSDetails->MessageText?>
                                </p>
                            </div>
                        </div>


                </div>
            </div>
        </div>

    </div>
</div>











</body>
</html>