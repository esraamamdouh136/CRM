<?php $this->load->view("header");?>
<style>
    label{
        font-weight: bold;
    }

</style>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:11%; margin-left:3%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Aside Menu -->
            <!-- END: Aside Menu -->
            <div class="row no-gutters ml-0 mr-0 mt-4 p-0">


                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        عميل
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet m-portlet--tab">


                            <!--begin::Form-->
                            <form class="m-form m-form--fit m-form--label-align-right" method="post" action="<?php echo base_url() ?>Client/update">
                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId ?>" name="customerCrmId">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group m--margin-top-10">
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-lg-2 col-form-label">اسم  </label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="text" value="<?php echo $customer[0]->customerCrmName ?>" id="customerCrmName" name="customerCrmName">
                                        </div>
                                        <label for="example-tel-input"
                                               class="col-lg-2 col-form-label"> النوع :</label>
                                        <div class="col-lg-3">
                                            <div class="m-checkbox-inline">
                                                <label class="m-checkbox">
                                                    <input type="radio" <?php if($customer[0]->customerCrmGender !=0){ echo "checked"; } ?> id="customerCrmGender" value="1" name="customerCrmGender"> انثي
                                                    <span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="radio" <?php if($customer[0]->customerCrmGender ==0){ echo "checked"; } ?> id="customerCrmGender" value="0" name="customerCrmGender"> ذكر
                                                    <span></span>
                                                </label>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-search-input" class="col-lg-2 col-form-label">الهاتف</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="customerCrmPhone" class="form-control" id="customerCrmPhone" required value="<?php echo $customer[0]->customerCrmPhone ?>">
                                        </div>

                                        <label for="example-url-input" class="col-lg-2 col-form-label">الهاتف الاخر</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="customerCrmSecondPhone" class="form-control" id="customerCrmSecondPhone" value="<?php echo $customer[0]->customerCrmSecondPhone ?>">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-tel-input" class="col-lg-2 col-form-label">   السن </label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="number" name="customerCrmAge" id="age"  value="<?php echo $customer[0]->customerCrmAge?>" min="0">
                                        </div>
                                        <label for="example-tel-input" class="col-lg-2 col-form-label"> المؤهل الدراسى</label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="tel" value="<?php echo $customer[0]->customerCrmQualification ?>" id="certifi" name="customerCrmQualification">
                                        </div>

                                    </div>

                                    <div class="form-group m-form__group row check_box">
                                        <label for="example-email-input" class="col-lg-2 col-form-label">البريد الالكترونى</label>
                                        <div class="col-lg-3">
                                            <input type="email" name="customerCrmEmail" class="form-control" id="email" value="<?php echo $customer[0]->customerCrmEmail ?>">
                                        </div>
                                        <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> الدوله  </label>
                                        <div class="col-lg-3">
                                            <input type="text" class="form-control" id="country" value="<?php echo $customer[0]->customerCrmCountry ?>" name="customerCrmCountry">
                                        </div>

                                    </div>


                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> المحافظه  </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="customerCrmGov" class="form-control" id="job" value="<?php echo $customer[0]->customerCrmGov ?>">
                                    </div>
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label">  العنوان  </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" value="<?php echo $customer[0]->customerCrmAddress ?>" type="text" name="customerCrmAddress" class="form-control" id="customerCrmAddress">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> الشركه   </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="customerCrmCompany" class="form-control" id="customerCrmCompany" value="<?php echo $customer[0]->customerCrmCompany ?>">
                                    </div>
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label">  الوظيفه  </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="customerCrmJob" class="form-control" id="customerCrmJob" value="<?php echo $customer[0]->customerCrmJob ?>">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> النشاط   </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="customerCrmActivity" class="form-control" id="customerCrmActivity" value="<?php echo $customer[0]->customerCrmActivity ?>">
                                    </div>


                                </div>



                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row no-gutters">
                                            <div class="col-lg-2">
                                            </div>
                                            <div class="col-lg-10">
                                                <button type="submit" class="btn btn-success float-right px-5v esbutton">حفظ</button>

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













<div class="main-content">
    <div id="cust-details" class="tab-pane fade in active ">
        <form class="form-horizontal" method="post" action="<?php echo base_url() ?>Client/update">
            <input type="hidden" value="<?php echo $customer[0]->customerCrmId ?>" name="customerCrmId">
            <div class="row no-gutters">
                <div class="col-lg-6">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="name">الاسم:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="customerCrmName" id="name" value="<?php echo $customer[0]->customerCrmName ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="age">السن:</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="customerCrmAge" id="age" value="<?php echo $customer[0]-> customerCrmAge  ?>" min="0">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="certifi">المؤهل الدراسي:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="certifi" name="customerCrmQualification" value="<?php echo $customer[0]->customerCrmQualification ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="gender">النوع:</label>
                                    <div class="col-sm-6">
                                        <input type="radio" <?php if($customer[0]->customerCrmGender !=0){ echo "checked"; } ?> id="customerCrmGender" value="1" name="customerCrmGender"> انثي
                                        <input type="radio" <?php if($customer[0]->customerCrmGender ==0){ echo "checked"; } ?> id="customerCrmGender" value="0" name="customerCrmGender"> ذكر
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12" style=" margin-top: 27px;">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="country">الدولة:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="country" value="<?php echo $customer[0]->customerCrmCountry ?>" name="customerCrmCountry">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job">المحافظة:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmGov" class="form-control" id="job" value="<?php echo $customer[0]->customerCrmGov ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job">العنوان:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmAddress" class="form-control" id="job" value="<?php echo $customer[0]->customerCrmAddress ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row no-gutters">
                        <div class="col-lg-12">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="email">البريد الالكتروني:</label>
                                    <div class="col-lg-6">
                                        <input type="email" name="customerCrmEmail" class="form-control" id="email" value="<?php echo $customer[0]->customerCrmEmail ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="phone">الهاتف:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmPhone" class="form-control" id="phone" value="<?php echo $customer[0]->customerCrmPhone ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="phone2">هاتف اخر:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmSecondPhone" class="form-control" id="phone2" value="<?php echo $customer[0]->customerCrmSecondPhone ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12" style=" margin-top: 99px;">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="customerCrmCompany">الشركة:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmCompany" class="form-control" id="customerCrmCompany" value="<?php echo $customer[0]->customerCrmCompany ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="job">الوظيفة:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmJob" class="form-control" id="customerCrmJob" value="<?php echo $customer[0]->customerCrmJob ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="position">النشاط:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="customerCrmActivity" class="form-control" id="customerCrmActivity" value="<?php echo $customer[0]->customerCrmActivity ?>">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-4">
                    <button type="submit"  class="btn btn-blue btn-lg btn-block esbutton">حفظ</button>
                </div>
            </div>
        </form>

    </div>

</div>

</div>



<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

<!-- Bottom Scripts -->
<script src="assets/js/gsap/main-gsap.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>

<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/neon-custom.js"></script>

</body>

</html>