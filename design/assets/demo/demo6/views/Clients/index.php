<?php $this->load->view("header");?>
<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->

<style>
    /*font Awesome http://fontawesome.io*/
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    /*Comment List styles*/
    .comment-list .row {
        margin-bottom: 0px;
    }
    .comment-list .panel .panel-heading {
        padding: 4px 15px;
        position: absolute;
        border:none;
        /*Panel-heading border radius*/
        border-top-right-radius:0px;
        top: 1px;
    }
    .comment-list .panel .panel-heading.right {
        border-right-width: 0px;
        /*Panel-heading border radius*/
        border-top-left-radius:0px;
        right: 16px;
    }
    .comment-list .panel .panel-heading .panel-body {
        padding-top: 6px;
    }
    .comment-list figcaption {
        /*For wrapping text in thumbnail*/
        word-wrap: break-word;
    }
    /* Portrait tablets and medium desktops */
    @media (min-width: 768px) {
        .comment-list .arrow:after, .comment-list .arrow:before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-color: transparent;
        }
        .comment-list .panel.arrow.left:after, .comment-list .panel.arrow.left:before {
            border-left: 0;
        }
        /*****Left Arrow*****/
        /*Outline effect style*/
        .comment-list .panel.arrow.left:before {
            left: 0px;
            top: 30px;
            /*Use boarder color of panel*/
            border-right-color: inherit;
            border-width: 16px;
        }
        /*Background color effect*/
        .comment-list .panel.arrow.left:after {
            left: 1px;
            top: 31px;
            /*Change for different outline color*/
            border-right-color: #FFFFFF;
            border-width: 15px;
        }
        /*****Right Arrow*****/
        /*Outline effect style*/
        .comment-list .panel.arrow.right:before {
            right: -16px;
            top: 30px;
            /*Use boarder color of panel*/
            border-left-color: inherit;
            border-width: 16px;
        }
        /*Background color effect*/
        .comment-list .panel.arrow.right:after {
            right: -14px;
            top: 31px;
            /*Change for different outline color*/
            border-left-color: #FFFFFF;
            border-width: 15px;
        }
    }
    .comment-list .comment-post {
        margin-top: 6px;
    }
</style>
<div class="contains" style="margin: 0%;">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#cust-details">البيانات</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#cust-call">الاتصال </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#other">اخري</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="cust-details" class="tab-pane fade in active ">
                    <form class="form-horizontal">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-body">
                                    <input type="hidden" class="custid" value="<?php echo $customer[0]->customerCrmId ?>">
                                    <div class="form-group">
                                        <b>
                                            <label class="control-label col-sm-4" for="name">الاسم:</label>
                                        </b>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $customer[0]->customerCrmName ?>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b> <label class="control-label col-sm-4" for="email">البريد الالكتروني:</label>
                                        </b>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $customer[0]->customerCrmEmail ?>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b> <label class="control-label col-sm-4" for="phone">الهاتف:</label>
                                        </b>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $customer[0]->customerCrmPhone ?>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b> <label class="control-label col-sm-4" for="age">السن:</label>
                                        </b>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $customer[0]->fage ?>
                                            </label>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <b> <label class="control-label col-sm-4" for="gender">النوع:</label>
                                        </b>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php
                                                if  ($customer[0]->ftype!='male' ){
                                                    echo "انثي";
                                                }else{
                                                    echo "ذكر";
                                                }
                                                ?>
                                            </label>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <b> <label class="control-label col-sm-4" for="job">المحافظة:</label>
                                                </b>
                                                <div class="col-sm-6">
                                                    <label class="control-label">
                                                        <?php echo $customer[0]->customerCrmGov ?>
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <b> <label class="control-label col-sm-4" for="job">العنوان:</label>
                                                </b>
                                                <div class="col-sm-6">
                                                    <label class="control-label">
                                                        <?php echo $customer[0]->customerCrmAddress ?>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style=" margin-top: 27px;">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <b> <label class="control-label col-sm-4" for="company">الشركة:</label>
                                                </b>
                                                <div class="col-sm-6">
                                                    <label class="control-label">
                                                        <?php echo $customer[0]->customerCrmCompany ?>
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <b> <label class="control-label col-sm-4" for="job">الوظيفة:</label>
                                                </b>
                                                <div class="col-sm-6">
                                                    <label class="control-label">
                                                        <?php echo $customer[0]->customerCrmJob ?>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-4">
                                <!-- <button type="submit" class="btn btn-default esbutton">تعديل</button> -->
                                <a href="<?php echo base_url() ?>Client/edit/<?php echo $customer_id ?>" class="btn btn-blue btn-lg btn-block">تعديل</a>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-sm-8 CommentContainer" style="float : none;">
                                    <h2 class="page-header">التعليقات</h2>
                                    <div class="form-group">
                                        <textarea type="text" id="comment" class="form-control" placeholder="أكتب تعليقك"
                                                  rows="10" cols="33"></textarea>
                                        <input type="button" class="sendComment btn btn-blue btn-lg" style="margin: 15px;"
                                               value="إضافة تعليق">

                                    </div>
                                    <?php
                                    if (isset($Comments)){
                                        if (count($Comments) > 0){
                                            for ($i=0;$i<count($Comments);$i++){?>
                                                <section class="comment-list">
                                                    <article class="row">
                                                        <div class="col-md-2 col-sm-2 hidden-xs">
                                                            <figure class="thumbnail">
                                                                <img class="img-responsive" src="assets/images/user-avatar-placeholder.png" />
                                                                <figcaption class="text-center">
                                                                    <?php echo get_Emp_name($Comments[$i]->UserID)?>
                                                                </figcaption>
                                                            </figure>
                                                        </div>
                                                        <div class="col-md-10 col-sm-10">
                                                            <div class="panel panel-default arrow right">
                                                                <div class="panel-body">
                                                                    <header class="text-right">

                                                                        <time class="comment-date" datetime="<?php echo $Comments[$i]->date ?>"><i
                                                                                    class="fa fa-clock-o"></i>
                                                                            <?php echo ' '.$Comments[$i]->date ?></time>
                                                                    </header>
                                                                    <div class="comment-post text-break">

                                                                            <?php echo $Comments[$i]->Comment_Text ?>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </article>
                                                </section>

                                                <?php
                                            }
                                        }

                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div id="cust-call" class="tab-pane fade ">
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10 ">
                            <div class="call-action">
                                <input type="hidden" id="custmer_id" value="<?php echo $customer_id ?>">
                                <button onclick="startcall()" class="entypo-phone call-bagde start-call btn-success"
                                        title="بدأ الاتصال"></button>
                                <button class="entypo-block call-bagde end-call btn-danger" onclick="endcall()" title="انهاء الاتصال"
                                        disabled id="buttonCallEnded"></button>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10 ">
                            <div class="call-timer">
                                <span id="date_time" style="box-shadow: inset 1px -1px 8px 1px grey;padding: 2% 7%;">
                                    <label id="minutes">00</label>:<label id="seconds">00</label>
                            </div>
                        </div>

                    </div>
                    <?php		$startTime = date("H:i:s");
                    $plus='+'.$time[0]['settingcrmTimeMinute'].' minutes';
                    $cenvertedTime = date('H:i:s',strtotime($plus,strtotime($startTime)));
                    ?>
                    <div class="row" id="DivCallStatus" style="display:none;">
                        <div class="col-sm-4">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-7">حالة الاتصال بالعميل :</label>
                                        <div class="col-sm-5">
                                            <div class="ans-state">
                                                <label>
                                                    <input type="radio" name="ans-state-radio" value="ans"> تم الرد
                                                </label>
                                            </div>
                                            <div class="ans-state">
                                                <label>
                                                    <input type="radio" name="ans-state-radio" value="not-ans"> لم يتم
                                                    الرد</label>
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
                                        <label class="control-label col-sm-7">نتيجة المكالمة :</label>
                                        <div class="col-sm-5">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optradioes" value="0" class="status"
                                                           statusid="0">تم التعاقد </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optradioes" class="optradioes" value="3">قيد
                                                    الحجز </label>
                                            </div>
                                            
                                            <?php if(isset($answer))
                                            {
                                                for($i=0;$i<count($answer);$i++)
                                                {
                                                    if($answer[$i]->status  == 3)
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
                                                            <?php echo $answer[$i]->title?>
                                                        </label>
                                                    </div>
                                                <?php }

                                            }?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ans-state-div not-ans " hidden>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-7">نتيجة المكالمة :</label>
                                        <div class="col-sm-5">
                                            <?php
                                            if(isset($noanswer)){
                                                for($i=0;$i<count($noanswer);$i++){
                                                    if($noanswer[$i]->status == 3){
                                                        $val=0;
                                                    }else{
                                                        $val=1;
                                                    }
                                                    ?>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="status" statusid="<?php echo $noanswer[$i]->id?>"
                                                                   name="optradioes" value="<?php echo $val?>">
                                                            <?php echo $noanswer[$i]->title?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ans-state-div load-res" hidden id="3" style="margin-bottom: 28px;">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class=row>
                                        <label class="control-label col-sm-7">قيد الحجز :</label>
                                        <div class="col-sm-5">
                                            <?php if(isset($reserve)){ for($i=0;$i<count($reserve);$i++){?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" status="<?php echo $reserve[$i]->id ?>" name="optradioes12"
                                                               value="0" class="status" statusid="0">
                                                        <?php echo $reserve[$i]->title?>
                                                    </label>
                                                </div>
                                            <?php } }?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 load-res " hidden id="1" style=margin-top:20px;>
                            <form method="post" action="<?php echo $url."users/update_status"?>">
                                <input type="hidden"
                                       class="statusid" id="flag_num" name="flag">
                                <div class="form-body">
                                    <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                                    <input type="hidden" name="call_status_id2" class="call_status_id_hidden2">
                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-3">التاريخ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="date" class="form-control datepicker" value="<?php echo date("
                                                    Y-m-d ")?>" id="date" data-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-3">الوقت :</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" name="time" class="form-control timepicker" id="dates"
                                                           data-template="dropdown" data-show-seconds="true" value="<?php echo $cenvertedTime ?>"
                                                           data-show-meridian="false" data-minute-step="5"
                                                           data-second-step="5" />

                                                    <div class="input-group-addon">
                                                        <a href="#">
                                                            <i class="entypo-clock"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-3">تعليق :</label>
                                            <div class="col-sm-7">
                                                <textarea class="form-control estext" rows="5" id="comment" name="comment"></textarea>
                                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>"
                                                       name="clientid">
                                                <input class="btn btn-blue btn-lg btn-block" style="margin: 20px;" type="submit" value="تم">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6 load-res load-res2" hidden id="0" style=margin-top:20px;>
                            <form method="post" action="<?php echo $url."users/update_status"?>">
                                <div class="form-body">
                                    <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                                    <input type="hidden" name="call_status_id2" class="call_status_id_hidden2">

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="control-label col-sm-4">النوع</label>
                                            <div class="col-sm-4">
                                                <div class="">
                                                    <label>
                                                        <input type="radio" name="type" value="2" onclick="changetype(2)">
                                                        خدمه
                                                    </label>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" name="type" value="1" onclick="changetype(1)">
                                                        منتج</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4">المنتج / الخدمة :</label>
                                            <div class="col-sm-7">
                                                <select name="product" id="selectServiceandProudct" class="select2 form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4" for="quan"> الكميه:</label>
                                            <div class="col-sm-7">
                                                <input type="number" min="0" value="0" name="qyt" class="form-control" id="quan">

                                            </div>
                                            <div class="col-sm-1">
                                                <!--                                                <button type="button" class="entypo-check call-bagde  btn-success" title="حفظ" onclick="addRow()"></button>-->

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4"> طريقه الشحن :</label>
                                            <div class="col-sm-7">
                                                <select name="truck" class="select2 form-control">
                                                    <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                                        <option value="<?php echo $trucks[$i]->transfer_ID?>">
                                                            <?php echo $trucks[$i]->transfer_Name?>
                                                        </option>
                                                    <?php }  }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4">التاريخ :</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="date" class="form-control datepicker" value="<?php echo date("
                                                    Y-m-d ")?>" id="date" data-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4">الوقت :</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" name="time" class="form-control timepicker" id="dates"
                                                           data-template="dropdown" data-show-seconds="true" value="<?php echo $cenvertedTime ?>"
                                                           data-show-meridian="false" data-minute-step="5"
                                                           data-second-step="5" />

                                                    <div class="input-group-addon">
                                                        <a href="#">
                                                            <i class="entypo-clock"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class=row>
                                            <label class="control-label col-sm-4">تعليق :</label>
                                            <div class="col-sm-7">
                                                <textarea class="form-control estext" rows="5" id="comment" name="comment"></textarea>
                                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>"
                                                       name="clientid">
                                                <input class="btn btn-blue btn-lg btn-block" style="margin: 20px;" type="submit" value="تم">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!---->
                        <!--                        <div class="col-sm-6 prod-table load-res" hidden style=margin-top:20px;>-->
                        <!--                            <div class="form-body">-->
                        <!--                                <table class="table">-->
                        <!--                                    <thead>-->
                        <!--                                        <tr>-->
                        <!--                                            <th>النوع</th>-->
                        <!--                                            <th>الاسم</th>-->
                        <!--                                            <th>الكمية</th>-->
                        <!--                                        </tr>-->
                        <!--                                    </thead>-->
                        <!--                                    <tbody class="prod-table-body">-->
                        <!--                                        <tr>-->
                        <!--                                            <td>خدمة</td>-->
                        <!--                                            <td>اسم</td>-->
                        <!--                                            <td>50</td>-->
                        <!--                                        </tr>-->
                        <!--                                    </tbody>-->
                        <!--                                </table>-->
                        <!---->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!---->


                    </div>

                    <?php
                    if (get_premissions($_SESSION['userid'],'14')==1){?>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-sm-8">
                                <div class="form-body">
                                    <div class="card-header">
                                        <h3>
                                            ارسال رسالة</h3>
                                        <hr>
                                    </div>

                                    <form class="form-horizontal">
                                        <div class="form-group">

                                            <label class="control-label col-sm-2" for="email">الإيميل:</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="mailaddress" placeholder="ادخل الإيميل"
                                                       value="<?php echo $customer[0]->customerCrmEmail;?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="email">العنوان:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="Mailsubject" placeholder="ادخل عنوان الرسالة">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="mess"> رسالة:</label>
                                            <div class="col-sm-9">
                                            <textarea type="text" id="Mailcontent" class="form-control" placeholder="ادخل رسالتك"
                                                      rows="10" cols="33"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-4">
                                                <button type="button" class="btn btn-blue btn-lg btn-block" id="sendMail">إرسال</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>


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
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="control-label col-sm-2">النوع</label>
                                            <div class="col-sm-4">
                                                <div class="">
                                                    <label>
                                                        <input type="radio" name="note-type" value="2" checked> شكوي
                                                    </label>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" name="note-type" value="4"> ملاحظات</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <div class="col-sm-3 col-sm-offset-4">
                                            <input type="button" class="sendcomplain btn btn-blue btn-lg btn-block"
                                                   value="ارسال">

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
                                    <form class="form-horizontal">

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
                                <label>
                                    <input type="radio" name="optradioes12" value="0">زيارة</label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optradioes12" value="0">شراء </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optradioes12" value="0"> حجز</label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optradioes12" value="0"> موعد التحويل</label>
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
                <form method="post" action="<?php echo base_url(); ?>users/update_status ">
                    <div class="modal-dialog" role="document">
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

            <div class="modal fade" id="exampleModalLong16es" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="<?php echo $url." users/update_status"?>">
                            <input type="hidden" class="statusid" id="flag_num" name="flag">
                            <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                            <input type="hidden" name="call_status_id2" class="call_status_id_hidden2">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-sm-2">النوع</label>
                                        <div class="col-sm-4">
                                            <div class="">
                                                <label>
                                                    <input type="radio" name="type" value="2" onclick="changetype(2)">
                                                    خدمه
                                                </label>
                                            </div>
                                            <div class="">
                                                <label>
                                                    <input type="radio" name="type" value="1" onclick="changetype(1)">
                                                    منتج</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <script>
                                    var changetype=function(type){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                document.getElementById("selectServiceandProudct").innerHTML = this.responseText;
                                            }
                                        };
                                        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type="+type, true);
                                        xhttp.send();
                                    }
                                </script>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label" for="select1">المنتج/الخدمه</label>
                                            <select name="product" id="selectServiceandProudct" class="select2 form-control">


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class=" control-label" for="quan">لكميه</label>
                                            <input type="text" name="qyt" class="form-control" id="quan">
                                        </div>
                                    </div>
                                </div>

                                طريقه الشحن
                                <div class="form-group">
                                    <select name="truck" class="select2 form-control">
                                        <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                            <option value="<?php echo $trucks[$i]->transfer_ID?>">
                                                <?php echo $trucks[$i]->transfer_Name?>
                                            </option>
                                        <?php }  }?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="date">التاريخ:</label>
                                    <input type="text" name="date" class="form-control datepicker" value="<?php echo date("
                                        Y-m-d ")?>" id="date" data-format="yyyy-mm-dd">

                                </div>
                                <div class="form-group">
                                    <label for="dates">الوقت</label>


                                    <div class="input-group">
                                        <input type="text" name="time" class="form-control timepicker" id="dates"
                                               data-template="dropdown" data-show-seconds="true" value="<?php echo $cenvertedTime ?>"
                                               data-show-meridian="false" data-minute-step="5" data-second-step="5" />

                                        <div class="input-group-addon">
                                            <a href="#">
                                                <i class="entypo-clock"></i>
                                            </a>
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
                        </form>
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
    var changetype = function (type) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("selectServiceandProudct").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type=" + type, true);
        xhttp.send();
    }
</script>
<script>
    var url = $("#base").val();
    jQuery(document).ready(function ($) {
        $('#myTable').DataTable({
            responsive: true,
            ordering: false,
            "paging": true,
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ]
        });
        $(".page-size").click(function () {
            var size = document.getElementById('Data-Length').value;
            $('#myTable').DataTable().page.len(size).draw();


        });

    });
</script>

<script>
    var client_id = document.getElementById('custmer_id').value;
    var totalSeconds = 0;
    var interval;
    var startcall = function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('DivCallStatus').style.display = 'block';
                document.getElementById('buttonCallEnded').removeAttribute("disabled");
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/start_call?client_id=" + client_id, true);
        xhttp.send();
        interval = setInterval(setTime, 1000);
    }
    var endcall = function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                clearInterval(interval);
                window.location.href = "<?php echo base_url() ?>/Mission/index";
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/end_call?client_id=" + client_id, true);
        xhttp.send();
        // interval=setInterval(setTime, 1000);
    }

    function setTime() {
        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }
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
                                alert("تم  ارسال الرساله بنجاح");
                            }

                        }
                    });
                }
            }
            if (Check == true) {
                alert("يجب عليك اختيار عميل");
            }
        } else {
            alert("لا يمكن ان يكون العنوان فارغ او المحتوي");
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

                    alert("تم  ارسال الرساله بنجاح");
                }
            });
        } else {
            alert("لا يمكن ان يكون المحتوي فارغ  ");
        }
    });


    $(".sendcomplain").click(function () {

        var base = $("#base").val();
        var clientid = $(".custid").val();
        var subject = document.getElementById("subject").value;
        var content = $(".complaincontent").val();
        var type = $("input[name='note-type']:checked").val();


        if (subject != "" && content != "") {
            $.ajax({
                type: "POST",
                url: base + "CRM_Messages/sendComplaint",
                data: ({
                    clientid: clientid,
                    subject: subject,
                    content: content,
                    complain: type
                }),
                success: function (data) {
                    if (type == 2)
                        alert("تم  ارسال الشكوي بنجاح");
                    else
                        alert("تم  ارسال الملاحظة بنجاح");
                }
            });
        } else {
            alert("لا يمكن ان يكون المحتوي فارغ  ");
        }
    });
    // Send Comment
    $(".sendComment").click(function () {
        var base = $("#base").val();
        var Container = $(".CommentContainer");
        var Comment = $("#comment").val();
        var clientid = $(".custid").val();
        // $(Container).append("<p>test</p>");

        if (Comment != "") {
            $.ajax({
                type: "POST",
                url: base + "CRM_Messages/AddComment",
                data: ({
                    clientid: clientid,
                    content: Comment
                }),
                success: function (data) {
                    if (data == 1) {
                        alert("تم إضافة التعليق بنجاح");
                        document.location.reload();
                    } else
                        alert("لم تم إضافة التعليق بنجاح");
                }
            });
        } else {
            alert("لا يمكن ان يكون المحتوي فارغ  ");
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
        var statusid = $(this).attr("statusid");

        if (statusid == 0) {
            $(".call_status_id_hidden2").val(10);
        }
        $(".call_status_id_hidden").val(statusid);
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

    $("#sendMail").click(function () {

        var base = $("#base").val();



        var clientid = $(".custid").val();
        var subject = $("#Mailsubject").val();
        var content = $("#Mailcontent").val();
        var mail = $("#mailaddress").val();
        $.ajax({
            type: "POST",
            url: base + "CRM_Mails/sendemail",
            data: ({
                clientid: clientid,
                subject: subject,
                content: content,
                mail: mail

            }),
            success: function (data) {
                if (data == 0) {
                    alert("حدث خطأ");
                } else {
                    alert("تم إرسال الرسالة بنجاح");
                }


            }
        });


    });

    $("").click(function () {

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
                $("#" + $(this).val()).attr("hidden", false);
                if($(this).val()==0){
                    $(".prod-table").attr("hidden", false);
                }
                else{
                    $(".prod-table").attr("hidden", true);
                }
            }
        });
        $('input[name="optradioes12"]').click(function () {
            if ($(this).is(':checked')) {
                $("#" + $(this).val()).attr("hidden", false);
                $(".prod-table").attr("hidden", false);
            }
        });


    });

    // var addRow = function(){
    //
    //         var row="<tr><td></td><td></td><td></td></tr>";
    //         $(".prod-table-body").append(row);
    //     }
</script>
</body>

</html>