<?php $this->load->view("header");?>
<div class="contains">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#cust-details">البيانات</a></li>
                <li><a data-toggle="tab" href="#cust-call">الاتصال </a></li>
                <li><a data-toggle="tab" href="#other">اخري</a></li>
            </ul>

            <div class="tab-content">
                <div id="cust-details" class="tab-pane fade in active ">
                    <form class="form-horizontal" action="/action_page.php">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="code">الكود:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="code" value="224" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">الاسم:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="name" value="Marwinda Mohamed"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="email">البريد الالكتروني:</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" id="email" value="haidy@" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="phone">الهاتف:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="phone" value="0211551" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="age">السن:</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="age" value="53" min="0"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="gender">النوع:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="gender" value="انثي" disabled>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="job">المحافظة:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="job" value="cairo"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="job">العنوان:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="job" value="cairo"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style=" margin-top: 27px;">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="company">الشركة:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="company" value="Quantum"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="job">الوظيفة:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="job" value="0211551"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-default esbutton">تعديل</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div id="cust-call" class="tab-pane fade ">
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10 ">
                            <div class="call-action">
                                <button class="entypo-phone call-bagde start-call btn-success" title="بدأ الاتصال"></button>
                                <button class="entypo-block call-bagde end-call btn-danger" title="انهاء الاتصال" disabled></button>
                               
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10 ">
                            <div class="call-timer">
                            <span id="date_time" style="box-shadow: inset 1px -1px 8px 1px grey;padding: 2% 7%;"> 
                                 02:08:34 </span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-6">حالة الاتصال بالعميل</label>
                                        <div class="col-sm-6">
                                            <div class="ans-state">
                                                <label><input type="radio" name="ans-state-radio" value="ans"> تم الرد
                                                </label>
                                            </div>
                                            <div class="ans-state">
                                                <label><input type="radio" name="ans-state-radio" value="not-ans"> لم
                                                    يتم الرد</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ans-state-div ans" hidden>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-5">نتيجة المكالمة :</label>
                                        <div class="col-sm-7">
                                            <?php if(isset($answer))
                                            {
                                                     for($i=0;$i<count($answer);$i++)
                                                    {
                                                        if($answer[$i]->Is_Confirm  == 1)
                                                        {
                                                            $val=0;
                                                        }
                                                        else
                                                        {
                                                            $val=1;
                                                        }
                                                        ?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="status" statusid="<?php echo $answer[$i]->id?>"
                                                        name="optradioes" value="<?php echo $val?>">
                                                    <?php echo $answer[$i]->Status_Name?>
                                                </label>
                                            </div>
                                            <?php } 
                                                
                                            }?>
                                            <div class="radio">
                                                <label><input type="radio" name="optradioes" value="0" class="status"
                                                        statusid="8">تم التعاقد </label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="optradioes" class="optradioes" value="load-res">قيد
                                                    الحجز </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ans-state-div not-ans " hidden>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-5">نتيجة المكالمة :</label>
                                        <div class="col-sm-7">
                                            <?php if(isset($noanswer)){
                                                                        for($i=0;$i<count($noanswer);$i++){
                                                                            if($noanswer[$i]->Is_Confirm  == 1)
                                                                            {
                                                                                $val=0;
                                                                            }
                                                                            else
                                                                            {
                                                                                $val=1;
                                                                            }
                                                                            ?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="status" statusid="<?php echo $noanswer[$i]->id?>"
                                                        name="optradioes" value="<?php echo $val?>">
                                                    <?php echo $noanswer[$i]->Status_Name?>
                                                </label>
                                            </div>
                                            <?php } } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ans-state-div load-res" hidden>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-5">قيد الحجز :</label>
                                        <div class="col-sm-7">
                                            <?php if(isset($reserve)){ for($i=0;$i<count($reserve);$i++){?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optradioes12" value="0" class="status"
                                                        statusid="<?php echo $reserve[$i]->id?>">
                                                    <?php echo $reserve[$i]->Status_Name?>
                                                </label>
                                            </div>
                                            <?php } }?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-sm-8">
                            <div class="form-body">
                                <div class="card-header">
                                    <h3>
                                        ارسال رسالة</h3>
                                    <hr>
                                </div>

                                <form class="form-horizontal" action="/action_page.php">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="email">الإيميل:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" placeholder="ادخل الإيميل">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="mess"> رسالة:</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="mess" placeholder="ادخل رسالتك"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2"> ارفاق ملف:</label>
                                        <div class="col-sm-3">
                                            <label class="entypo-attach col-sm-4" for="attach-file" style="cursor:pointer"></label>
                                            <input type="file" class="form-control hide" id="attach-file">

                                            <label class="entypo-picture col-sm-4" for="attach-pic" style="cursor:pointer"></label>
                                            <input type="file" class="form-control hide" id="attach-pic" accept="image/*">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-default esbutton">إرسال</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="other" class="tab-pane fade">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-body">
                                <div class="card-header">
                                    <h3>
                                        ارسال شكوي / ملاحظات </h3>
                                    <hr>
                                </div>
                                <form class="form-horizontal" action="/action_page.php">
                                    <div class="form-group">
                                        <label for="sel4" class=" control-label">العنوان</label>
                                        <input type="text" id="subject" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">المحتوي</label>
                                        <textarea rows="10" class=".etextar2 form-control complaincontent" id="field-1"
                                            placeholder="الشكوى"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="button" class="sendcomplain esbutton" value="ارسال">

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <?php
                            if ($_SESSION["usertype"] !=3){
                                                 ?>
                        <div class="col-sm-6">
                            <div class="form-body ">
                                <div class="card-header">
                                    <h3>
                                        تحويل الي موظف اخر
                                    </h3>
                                    <hr>
                                </div>
                                <form class="form-horizontal" action="/action_page.php">

                                    <div class="form-group">
                                        <label for="إسم الموظف" class="control-label">إسم الموظف</label>
                                        <select name="mto" id="select-employee" class="form-control" required>
                                            <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                                            <option value="<?php echo $users[$i]->userCrmId?>">
                                                <?php echo $users[$i]->userCrmName?>
                                            </option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment" class="control-label">تعليق</label>
                                        <textarea rows="10" class=".etextar2 form-control complaincontent" id="comment"
                                            placeholder="التعليق"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-default esbutton">تحويل</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        }
                        ?>


                    </div>

                </div>
            </div>
        </div>




        <!-- old html code -->

        <div class="row">


            <!--modal not interested-->
            <div class="modal fade" id="exampleModalLong11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">تعليق </h5>

                        </div>
                        <div class="modal-body">
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="button" class="btn btn-primary">تم</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="modal fade" id="exampleModalLongess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>


                        </div>
                        <div class="modal-body" style="margin: 5%">
                            <?php if(isset($reserve)){ for($i=0;$i<count($reserve);$i++){?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optradioes12" value="0" class="status" statusid="<?php echo $reserve[$i]->id?>">
                                    <?php echo $reserve[$i]->Status_Name?>
                                </label>
                            </div>
                            <?php } }?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">تم</button>
                        </div>
                    </div>
                </div>
            </div> -->



            <!---->



            <div class="modal fade" id="exampleModalLongrevise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>


                        </div>
                        <div class="modal-body">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optradioes12" value="0">شحن
                                </label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="optradioes12" value="0">زيارة</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="optradioes12" value="0">شراء </label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="optradioes12" value="0"> حجز</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="optradioes12" value="0"> موعد التحويل</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">تم</button>
                        </div>
                    </div>
                </div>
            </div>
            <!---->


            <!--modal not interested-->


            <div class="modal fade" id="exampleModalLong12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">تم الحجز</h5>

                        </div>
                        <div class="modal-body">

                            <label class="control-label">المنتج</label>
                            <select name="test" class="form-control" data-allow-clear="true" data-placeholder="المنتجات...">

                                <option value="1">المنتجات</option>
                                <option value="2">منتج2</option>
                                <option value="3">منتج3</option>
                                <option value="4"> منتج4</option>
                                <option value="5">منتج5</option>
                            </select>
                            <label class="control-label">طريقة الشحن</label>
                            <select name="test" class="form-control" data-allow-clear="true" data-placeholder=" طرق الشحن...">

                                <option value="1"> طرق الشحن</option>
                                <option value="2">شحنة 1</option>
                                <option value="3">شحنة 2</option>
                                <option value="4"> شحنة 3</option>
                                <option value="5">شحنة 4</option>
                            </select>
                            <label class=" control-label">موعد ووقت الشحن</label>



                            <div class="date-and-time">
                                <input type="text" class="form-control datepicker" data-format="D, dd MM yyyy">
                                <input type="text" class="form-control timepicker" data-show-seconds="true"
                                    data-default-time="11:25 AM" data-show-meridian="true" data-minute-step="5"
                                    data-second-step="5" />
                            </div>








                            <div class="modal-footer">
                                <div class="col-md-4"></div>
                                <button type="button" class="btn btn-primary">تم</button>
                                <button type="button" class="btn btn-primary"> منتج اخر </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!---->
            <!--modal not interested-->


            <div class="modal fade" id="exampleModalLong13" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">تحديد اخر موعد </h5>

                        </div>
                        <div class="modal-body">
                            <label class=" control-label">موعد ووقت الشحن</label>



                            <div class="date-and-time">
                                <input type="text" class="form-control datepicker" data-format="D, dd MM yyyy">
                                <input type="text" class="form-control timepicker" data-show-seconds="true"
                                    data-default-time="11:25 AM" data-show-meridian="true" data-minute-step="5"
                                    data-second-step="5" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="button" class="btn btn-primary">تم </button>
                        </div>
                    </div>
                </div>
            </div>


            <!---->

            <!--modal not interested-->


            <div class="modal fade" id="exampleModalLong14" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <form method="post" action="<?php echo $url." users/update_status"?>"> <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle"> لم يتم الرد</h5>

                        </div>

                        <input type="hidden" class="statusid" name="status">

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="comment">تعليق:</label>
                                <textarea class="form-control estext" rows="5" id="comment" name="comment"></textarea>
                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">

                            </div>




                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <input type="submit" class="btn btn-primary" value="تم">
                        </div>
                    </div>
            </div>
            </form>
        </div>


        <!---->
        <!--modal not interested-->

        <?php		$startTime = date("H:i:s");
        $plus='+'.$time[0]->settingcrmTimeMinute.' minutes';
        $cenvertedTime = date('H:i:s',strtotime($plus,strtotime($startTime)));
        ?>
        <form method="post" action="<?php echo $url." users/update_status"?>"> <div class="modal fade" id="exampleModalLong15"
            tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>
                    </div>
                    <input type="hidden" class="statusid" name="status">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">التاريخ:</label>
                            <input type="text" name="date" class="form-control datepicker" value="<?php echo date("
                                Y-m-d")?>" id="date" data-format="yyyy-mm-dd">

                        </div>
                        <div class="form-group">
                            <label for="dates">الوقت</label>


                            <div class="input-group">
                                <input type="text" name="time" class="form-control timepicker" id="dates" data-template="dropdown"
                                    data-show-seconds="true" value="<?php echo $cenvertedTime ?>" data-show-meridian="false"
                                    data-minute-step="5" data-second-step="5" />

                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-clock"></i></a>
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="comment">تعليق:</label>
                            <textarea class="form-control estext" rows="5" id="comment" name="comment"></textarea>
                            <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        <input type="submit" class="btn btn-primary" value="تم">
                    </div>
                </div>
            </div>
    </div>
    </form>

    <!---->
    <!--modal not interested-->


    <div class="modal fade" id="exampleModalLong16" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle"> مشغول/انتظار</h5>

                </div>
                <div class="modal-body">
                    <label class=" control-label">موعد ووقت الشحن</label>



                    <div class="date-and-time">
                        <input type="text" class="form-control datepicker" data-format="D, dd MM yyyy">
                        <input type="text" class="form-control timepicker" data-show-seconds="true" data-default-time="11:25 AM"
                            data-show-meridian="true" data-minute-step="5" data-second-step="5" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary">تم </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalLong16es" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form method="post" action="<?php echo $url." users/update_status"?>"> <input type="hidden" class="statusid"
                    name="status">
                    <div class="modal-body">



                        <div class="form-group">
                            <label class=" control-label" for="select1">المنتج/الخدمه</label>
                            <select name="product[]" id="select1" class="select2 form-control" multiple>
                                <?php if(isset($product)){ for($i=0;$i<count($product);$i++){?>
                                <option value="<?php echo $product[$i]->ProductCrmId?>">
                                    <?php echo $product[$i]->ProductCrmName?>
                                </option>
                                <?php } } ?>

                            </select>
                        </div>
                        طريقه الشحن
                        <div class="form-group">
                            <select name="truck">
                                <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                <option value="<?php echo $trucks[$i]->ProductCrmId?>">
                                    <?php echo $trucks[$i]->ProductCrmName?>
                                </option>
                                <?php }  }?>
                            </select>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="date">التاريخ:</label>
                                <input type="text" name="date" class="form-control datepicker" value="<?php echo date("
                                    Y-m-d")?>" id="date" data-format="yyyy-mm-dd">

                            </div>
                            <div class="form-group">
                                <label for="dates">الوقت</label>


                                <div class="input-group">
                                    <input type="text" name="time" class="form-control timepicker" id="dates"
                                        data-template="dropdown" data-show-seconds="true" value="<?php echo $cenvertedTime ?>"
                                        data-show-meridian="false" data-minute-step="5" data-second-step="5" />

                                    <div class="input-group-addon">
                                        <a href="#"><i class="entypo-clock"></i></a>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="comment">تعليق:</label>
                                <textarea class="form-control estext" rows="5" id="comment" name="comment"></textarea>
                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <input type="submit" class="btn btn-primary" value="تم">
                        </div>
                    </div>
            </div>
        </div>


    </div>



</div>


</div>



<div class="modal fade " id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" style="padding-top: 10%;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-white" id="exampleModalLabel2" style="text-align: center;color: #ffffff;">تحويل
                    إلى موظف آخر</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="CID">
                <div class="form-group">
                    <h3>إسم الموظف</h3>
                    <select name="mto" id="select-employee" class="form-control" required>
                        <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                        <option value="<?php echo $users[$i]->userCrmId?>">
                            <?php echo $users[$i]->userCrmName?>
                        </option>
                        <?php } }?>
                    </select>
                </div>


            </div>
            <div class="modal-footer col-sm-12">
                <div class="col-sm-6" style="width: 50%; margin: 0 auto; text-align: left">
                    <button type="button" class="btn btn-primary" id="reassign">تحويل</button>
                </div>
                <div class="col-sm-6" style="align-content: center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">إغلاق</button>
                </div>


            </div>
        </div>
    </div>
</div>
</div>

<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">


<!-- Bottom Scripts -->
<script src="assets/js/gsap/main-gsap.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>

<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script>
    var url = $("#base").val();
</script>
<script>
    $('input[name="optradioes"]').click(function () {
        if ($(this).is(':checked') && $(this).val() == '0') {
            $('#exampleModalLong15').modal('show');
        }
    });

    $('input[name="optradioes12"]').click(function () {
        if ($(this).is(':checked') && $(this).val() == '0') {
            $('#exampleModalLong16es').modal('show');
        }
    });

    $('input[name="optradioes"]').click(function () {
        if ($(this).is(':checked') && $(this).val() == '1') {
            $('#exampleModalLong14').modal('show');
        }
    });

    // $('input[class="optradioes"]').click(function () {
    //     $(".load-res").attr("hidden",true);
    //     if ($(this).is(':checked') && ($("input").hasClass("optradioes"))) {
    //         $(".ans-state-div.load-res").attr("hidden",false);
    //     }

    // });
</script>
<script>
    var url = $("#base").val();

    function customer_details() {
        var clientid = $(".custid").val();

        window.location = url + "users/customer_details/" + clientid;
    }

    $(".sendsms").click(function () {
        debugger;
        var nums = $(".cliecount").val();
        var base = $("#base").val();
        var clientid;
        var subject = $(".smssubject").val();
        var content = $(".smscontent").val();
        var Check = true;

        if (subject != "" && content != "") {
            for (var index = 0; index < nums; index++) {

                if ($('.customer' + index).is(':checked')) {
                    clientid = $('.customer' + index).attr("cid");
                    $.ajax({
                        type: "POST",
                        url: base + "users/sendsms",
                        data: ({
                            clientid: clientid,
                            subject: subject,
                            content: content
                        }),
                        success: function (data) {
                            if (Check == true) {
                                Check = false;
                                toastr.success("تم  ارسال الرساله بنجاح");
                            }

                        }
                    });
                }
            }
            if (Check == true) {
                toastr.error("يجب عليك اختيار عميل");
            }
        } else {
            toastr.error("لا يمكن ان يكون العنوان فارغ او المحتوي");
        }
    });

    $(".sendmess").click(function () {
        debugger;
        var base = $("#base").val();
        var clientid = $(".custid").val();
        var subject = " ";
        var content = $(".content").val();


        if (subject != "" && content != "") {
            $.ajax({
                type: "POST",
                url: base + "users/sendsms",
                data: ({
                    clientid: clientid,
                    subject: subject,
                    content: content
                }),
                success: function (data) {

                    toastr.success("تم  ارسال الرساله بنجاح");
                }
            });
        } else {
            toastr.error("لا يمكن ان يكون المحتوي فارغ  ");
        }
    });


    $(".sendcomplain").click(function () {
        debugger;
        var base = $("#base").val();
        var clientid = $(".custid").val();
        var subject = document.getElementById("subject").value;
        var content = $(".complaincontent").val();


        if (subject != "" && content != "") {
            $.ajax({
                type: "POST",
                url: base + "users/sendcomplain",
                data: ({
                    clientid: clientid,
                    subject: subject,
                    content: content,
                    complain: 1
                }),
                success: function (data) {
                    toastr.success("تم  ارسال الشكوي بنجاح");
                }
            });
        } else {
            toastr.error("لا يمكن ان يكون المحتوي فارغ  ");
        }
    });

    $(".startcall").click(function () {
        debugger;
        var base = $("#base").val();
        var clientid = $(".custid").val();

        $.ajax({
            type: "POST",
            url: base + "users/startcall",
            data: ({
                clientid: clientid

            }),
            success: function (data) {



            }
        });


    });
    $(".status").click(function () {
        debugger;
        var statusid = $(this).attr("statusid");
        $(".statusid").val(statusid);
    });

    $("#reassign").click(function () {

        var base = $("#base").val();
        var employee = document.getElementById("select-employee").options[document.getElementById(
            "select-employee").selectedIndex].value;
        var clientid = $(".custid").val();
        // alert(clientid);
        // var clientid=$(".custid").val();
        //
        $.ajax({
            type: "POST",
            url: base + "users/ReAssign",
            data: ({
                clientid: clientid,
                EmpID: employee

            }),
            success: function (data) {
                if (data == 0) {
                    toastr.error("حدث خطأ");
                } else {
                    toastr.success("تم تحويل العميل بنجاح");
                }


            }
        });


    });
</script>

<script>
    $(function () {
        $('input[name="ans-state-radio"]').click(function () {
            $(".ans-state-div").attr("hidden", true);
            if ($(this).is(':checked')) {
                $("." + $(this).val()).attr("hidden", false);
            }
        });
        $('input[name="optradioes"]').click(function () {
            $(".load-res").attr("hidden", true);
            if ($(this).is(':checked')) {
                $("." + $(this).val()).attr("hidden", false);
            }
        });
    });
</script>
</body>

</html>