<?php $this->load->view("header");?>
<style>
    label{
        font-weight: bold;
    }

</style>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:8%; margin-left:3%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Aside Menu -->
            <!-- END: Aside Menu -->
            <div class="row ml-0 mr-0 mt-4 p-0">


                <div class="col-12">
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
                            <form class="m-form m-form--fit m-form--label-align-right" method="post" action="<?php echo base_url() ?>Client/Add">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group m--margin-top-10">
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-lg-2 col-form-label">اسم  </label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="text" value="" name="customerCrmName" id="customerCrmName">
                                        </div>
                                        <label for="example-tel-input"
                                               class="col-lg-2 col-form-label"> النوع :</label>
                                        <div class="col-lg-3">
                                            <div class="m-checkbox-inline">
                                                <label class="m-checkbox">
                                                    <input type="radio" checked id="customerCrmGender" value="0" name="customerCrmGender"> ذكر
                                                    <span></span>
                                                </label>
                                                <input type="radio" id="customerCrmGender" value="1" name="customerCrmGender"> انثي
                                                <span></span>
                                                </label>
                                                <label class="m-checkbox">


                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-search-input" class="col-lg-2 col-form-label">الهاتف</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="customerCrmPhone" class="form-control" id="customerCrmPhone" required>
                                        </div>

                                        <label for="example-url-input" class="col-lg-2 col-form-label">الهاتف الاخر</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="customerCrmSecondPhone" class="form-control" id="customerCrmSecondPhone">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-tel-input" class="col-lg-2 col-form-label">   السن </label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="number" name="customerCrmAge" id="customerCrmAge"  min="0">
                                        </div>
                                        <label for="example-tel-input" class="col-lg-2 col-form-label"> المؤهل الدراسى</label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="tel" value="" id="certifi" name="customerCrmQualification">
                                        </div>

                                    </div>

                                    <div class="form-group m-form__group row check_box">
                                        <label for="example-email-input" class="col-lg-2 col-form-label">البريد الالكترونى</label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="email" name="customerCrmEmail"  id="customerCrmEmail"">
                                        </div>
                                        <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> الدوله  </label>
                                        <div class="col-lg-3">
                                            <input class="form-control m-input" type="text" id="customerCrmCountry" name="customerCrmCountry">
                                        </div>

                                    </div>


                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> المحافظه  </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" type="text" name="customerCrmGov" class="form-control" id="customerCrmGov" >
                                    </div>
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label">  العنوان  </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" type="text" name="customerCrmAddress" class="form-control" id="customerCrmAddress">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> الشركه   </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" type="text" name="customerCrmCompany"id="customerCrmCompany" >
                                    </div>
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label">  الوظيفه  </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" type="text" name="customerCrmJob" class="form-control" id="customerCrmJob">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> النشاط   </label>
                                    <div class="col-lg-3">
                                        <input class="form-control m-input" type="text" value="" id="customerCrmActivity" name="customerCrmActivity">
                                    </div>
                                    <label for="example-datetime-local-input" class="col-lg-2 col-form-label"> بيان اخر   </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="customerCrmOther" class="form-control" id="customerCrmOther" placeholder="بيان آخر">
                                    </div>

                                </div>



                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-2">
                                            </div>
                                            <div class="col-10">
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






</body>

</html>