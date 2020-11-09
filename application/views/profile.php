<?php $this->load->view("header"); ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:2%; margin-top:2%;">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->

    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__body">


                <form role="form" class="form-horizontal form-groups-bordered">

                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">الاسم</label>

                        </div>
                        <div class="col-sm-6">

                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->Name?></label>
                        </div>
                    </div>

                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">التليفون</span>

                        </div>
                        <div class="col-sm-6">
                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->Phone?></label>
                        </div>
                    </div>
                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">البريد الالكتروني</span>

                        </div>
                        <div class="col-sm-6">
                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->Email?></label>
                        </div>
                    </div>

                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">العنوان</span>

                        </div>
                        <div class="col-sm-6">
                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"> <?=$user[0]->Address?></label>
                        </div>
                    </div>

                    <div class="row col-sm-12">
                        <div class="col-sm-4">
                            <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">تاريخ الميلاد</span>

                        </div>
                        <div class="col-sm-6">
                            <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->BirthDate?></label>
                        </div>
                    </div>

                    <?php if($_SESSION['usertype']!=1){?>

                        <div class="row col-sm-12">
                            <div class="col-sm-4">
                                <span for="field-ta" class="col-sm-3 control-label font" style="font-size: 20pt;">المشرف</span>
                            </div>
                            <div class="col-sm-6">

                                <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=getuname($user[0]->Super)?></label>
                            </div>
                        </div>

                        <div class="row col-sm-12">
                            <div class="col-sm-4">
                                <span for="field-4" class="col-sm-3 control-label font" style="font-size: 20pt;">تاريخ التعيين</span>
                            </div>
                            <div class="col-sm-6">

                                <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->JoinDate?></label>
                            </div>
                        </div>

                        <div class="row col-sm-12">
                            <div class="col-sm-4">
                                <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">المرتب</span>

                            </div>
                            <div class="col-sm-6">
                                <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"><?=$user[0]->Salary?></label>

                            </div>
                        </div>

                        <div class="row col-sm-12">
                            <div class="col-sm-4">
                                <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">عدد المكالمات حتي الان</span>
                            </div>
                            <div class="col-sm-6">
                                <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;"> 0</label>

                            </div>
                        </div>

                        <div class="row col-sm-12">
                            <div class="col-sm-4">
                                <span for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">عدد الحجوزات التي قام بها</span>
                            </div>
                            <div class="col-sm-6">
                                <label for="field-1" class="col-sm-3 control-label font" style="font-size: 20pt;">0</label>
                            </div>
                        </div>
                    <?php }?>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>