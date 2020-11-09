<?php
$UploadFile =get_premissions($_SESSION["userid"],'01');
$Reports =get_premissions($_SESSION["userid"],'02');
$Database =get_premissions($_SESSION["userid"],'03');
$Settings =get_premissions($_SESSION["userid"],'04');
$DelayedCalls =get_premissions($_SESSION["userid"],'05');
$upcomingCalls =get_premissions($_SESSION["userid"],'06');
$SMS_Mails =get_premissions($_SESSION["userid"],'07');
$Employee =get_premissions($_SESSION["userid"],'08');
$Clients =get_premissions($_SESSION["userid"],'09');
$InternalMessages =get_premissions($_SESSION["userid"],'10');
$AssignMissions =get_premissions($_SESSION["userid"],'11');
?>



<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i
            class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light "
         data-menu-vertical="true" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
        <div class="logo">
            <a href="<?php echo isset($_SESSION['date1']) ? $url.'CRM_Users/index/'.$_SESSION['date1'].'@'.$_SESSION['date2'] : $url.'users/'?>">
                <?php $CompanyData = get_row("settingcrm",["settingcrmId"=>1],null) ?>
                <img src="assets/images/<?= $CompanyData->settingcrmLogo ?>" class="w-75 ml-3" alt="" />
            </a> </div>
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow  ">
            <li class="m-menu__item  m-menu__item--submenu <?= $_SESSION["PAGE"] == "index" ? "active" : "" ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="<?php echo isset($_SESSION['date1']) ? $url.'CRM_Users/index/'.$_SESSION['date1'].'@'.$_SESSION['date2'] : $url.'users/'?>"
                        class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon flaticon-home-1"></i><span
                            class="m-menu__link-text">الصفحه
                                    الرئيسيه</span></a>

            </li>
            <li class="m-menu__item <?=  ($_SESSION["PAGE"] == "Distributors") ? "active" : "" ?> "
                aria-haspopup="true" m-menu-link-redirect="1"><a
                        href="<?php echo isset($_SESSION['date1']) ? $url.'Client/Distributors/'.$_SESSION['date1'].'@'.$_SESSION['date2'] :$url.'Client/Distributors' ?>"
                        class="m-menu__link"><i class="m-menu__link-icon flaticon-users"></i><span
                            class="m-menu__link-text"> <?php echo get_change(12)?>
                                </span></a></li>
            <li class="m-menu__item <?=  ($_SESSION["PAGE"] == "DelayedCalls") ? "active" : "" ?> "
                aria-haspopup="true" m-menu-link-redirect="1"><a
                        href="<?php echo $url.'CRM_Follows/DelayedCalls'?>" class="m-menu__link"><i
                            class="m-menu__link-icon la la-phone"></i><span class="m-menu__link-text">
                                    <?php echo get_change(13)?>
                                    <span class="m-menu__link-badge"><span id="DelayedCalls"
                                                                           class="m-badge m-badge--danger"><?php echo GetDelayedCallsCount() ?></span></span> </span>
                </a></li>
            <li class="m-menu__item <?=  ($_SESSION["PAGE"] == "upcomingCalls") ? "active" : "" ?> "
                aria-haspopup="true" m-menu-link-redirect="1"><a
                        href="<?php echo $url.'CRM_Follows/upcomingCalls'?>" class="m-menu__link"><i
                            class="m-menu__link-icon flaticon-alert"></i><span class="m-menu__link-text">
                                    <?php echo get_change(2)?>
                                    <span class="m-menu__link-badge"><span id="UpcommingCallsCount"
                                                                           class="m-badge m-badge--danger"><?php echo GetUpcommingCallsCount() ?></span></span> </span>
                </a></li>

            <?php
            if( $UploadFile == 1 || $AssignMissions == 1){ ?>
                <li class="m-menu__item  m-menu__item--submenu <?= ( $_SESSION["PAGE"] == "task_view" || $_SESSION["PAGE"] == "mission" ) ? "opened" : "" ?>"
                    m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href=""
                                                                              class="m-menu__link m-menu__toggle"><i
                                class="m-menu__link-icon flaticon-folder-2"></i><span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap"> <span class="m-menu__link-text">
                                            <?php echo get_change(3)?>
                                        </span>
                                    </span></span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">

                            <?php if($_SESSION["usertype"]!=1){?>


                            <?php }?>
                            <?php

                            if($_SESSION["usertype"] < 3 || $UploadFile==1 || $AssignMissions ==1 ){?>

                                <li class="m-menu__item " data-toggle="modal" data-target="#load_file"
                                    aria-haspopup="true" m-menu-link-redirect="1"><a class="m-menu__link"><i
                                                class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                class="m-menu__link-text" data-toggle="modal"
                                                data-target="#exampleModalLong"> رفع الملف </span></a></li>

                            <?php }if($_SESSION["usertype"]!=3 || $AssignMissions == 1){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "task_view" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'Mission/Assign'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">تعيين مهام </span></a></li><?php }?>
                        </ul>
                    </div>
                </li>
            <?php }
            if( $Employee == 1){?>
                <li class="m-menu__item <?= $_SESSION["PAGE"] == "Employees" ? "active" : "" ?>"
                    aria-haspopup="true" m-menu-link-redirect="1"><a href="<?php echo $url.'Employees'?>"
                                                                     class="m-menu__link "><i class="m-menu__link-icon flaticon-user-settings"></i><span
                                class="m-menu__link-text"><?php echo get_change(4)?>
                                   </span></a></li>
            <?php  } ?>

            <li class="m-menu__item <?= $_SESSION["PAGE"] == "message_view" ? "active" : "" ?> "
                aria-haspopup="true" m-menu-link-redirect="1"><a
                        href="<?php echo $url.'CRM_Messages/index'?>" class="m-menu__link "><i
                            class="m-menu__link-icon flaticon-chat-1"></i><span
                            class="m-menu__link-text"><?php echo get_change(8)?>
                                    <span class="m-menu__link-badge"><span
                                                class="m-badge m-badge--danger"><?php echo GetMessages() ?></span></span></span></a></li>
            <li class="m-menu__item <?= $_SESSION["PAGE"] == "sms" ? "active" : "" ?>"" aria-haspopup="
            true" m-menu-link-redirect="1"> <a href="<?php echo $url.'users/emails_view'?>"
                                               class="m-menu__link "><i class="m-menu__link-icon flaticon-multimedia-2"></i><span
                        class="m-menu__link-text"><?php echo get_change(7)?></span></a></li>
            <li class="m-menu__item <?= $_SESSION["PAGE"] == "sms" ? "active" : "" ?> " aria-haspopup="true"
                m-menu-link-redirect="1"><a href="<?php echo $url."sms/index"?>" class="m-menu__link "><i
                            class="m-menu__link-icon flaticon-edit-1"></i><span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap"> <span class="m-menu__link-text"> رسائل نصيه </span>
                                                                          </span></a></li>
            <li class="m-menu__item <?= $_SESSION["PAGE"] == "Complains" ? "active" : "" ?>"
                aria-haspopup="true"
                m-menu-link-redirect="1"><a href="<?php echo $url.'CRM_Complain/index'?>" class="m-menu__link "><i
                            class="m-menu__link-icon flaticon-clipboard"></i><span
                            class="m-menu__link-text"><?php echo get_change(9)?>
                                        <span class="m-menu__link-badge"><span
                                                    class="m-badge m-badge--danger"><?php echo GetcomplaintsCount() ?></span></span></span></a></li>
            <li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-1 <?= ( $_SESSION["PAGE"] == "company_data" ||$_SESSION["PAGE"] == "OrderSettings" || $_SESSION["PAGE"] == "reservations_view" || $_SESSION["PAGE"] == "change_view"|| $_SESSION["PAGE"] == "edit_mail"|| $_SESSION["PAGE"] == "Products"|| $_SESSION["PAGE"] == "Transfer" ) ? "opened" : "" ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">

                <?php
                if($Settings==1  || $Database==1  ){?>
                <a href="" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon flaticon-cogwheel-1"></i><span
                            class="m-menu__link-text"><?php echo get_change(10)?></span><i
                            class="m-menu__ver-arrow la la-angle-right"></i></a>
                <div class="m-menu__submenu m-menu__submenu--up"><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <?php if( $Settings==1  ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "Transfer" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'Transfer'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text"> طرق الشحن </span></a></li>
                        <?php }
                        if( $Settings==1  ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "Products" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'Products'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">منتجات / وخدمات</span></a></li>
                        <?php }
                        if($Settings==1 || $Database == 1 ){?>
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?= $url.'copydata/Export'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">قاعده البيانات</span></a></li>
                        <?php }
                        if($Settings==1  ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "change_view" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'users/change_view'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">تعديل لوحه التحكم</span></a></li>
                        <?php }
                        if($Settings==1  ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "company_data" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'users/company_data'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">بيانات الشركه</span></a></li>
                        <?php }
                        if($Settings==1  ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "edit_mail" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'users/setEmail'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">الاعدادات البريد الالكترونى</span></a></li>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "smsSettings" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?php echo $url.'SMS/SMSAPI'?>" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">إعدادات الرسائل النصية</span></a></li>
                        <?php }?>
                        </li>
                    </ul>
                </div>
            </li>

        <?php }
        ?>
            <li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-1 <?= ( $_SESSION["PAGE"] == "reports_employee" ||$_SESSION["PAGE"] == "TargetedClients" ||$_SESSION["PAGE"] == "StaffEvaluation" ||$_SESSION["PAGE"] == "reports_Supervisor" || $_SESSION["PAGE"] == "reports_products" || $_SESSION["PAGE"] == "reports_calls" ) ? "opened" : "" ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="#"
                                                                      class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-file-2"></i><span
                            class="m-menu__link-text"><?php echo get_change(11)?></span><i
                            class="m-menu__ver-arrow la la-angle-right"></i></a>
                <div class="m-menu__submenu m-menu__submenu--up"><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <?php
                        if($Reports == 1 ){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_employee" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employee/3"
                                                                                 class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">الموظفين</span></a></li>
                        <?php}
                        if($Reports == 1)
                        {?>
                            <li class="m-menu__item  <?= $_SESSION["PAGE"] == "reports_Supervisor" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employee/2"
                                                                                 class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">المشرفين</span></a></li>
                        <?php }

                        if($Reports == 1)
                        {?>
                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "StaffEvaluation" ? "active" : "" ?> "
                            aria-haspopup="true" m-menu-link-redirect="1">
                            <a href="<?= $url ?>reports/StaffEvaluation"
                               class="m-menu__link "><i
                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                        class="m-menu__link-text">تقييم اداء الموظفين</span></a></li>
                        <?php }
                        ?>
                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_employee" ? "active" : "" ?> "
                            aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employeeDetails"
                                                                             class="m-menu__link "><i
                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                        class="m-menu__link-text">تقاريرى</span></a></li>
                        <?php if( $Reports == 1){?>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "TargetedClients" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a
                                        href="<?= $url ?>reports/TargetedClients" class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">العملاء المستهدفين</span></a></li>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_products" ? "active" : "" ?> "
                                aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/products/"
                                                                                 class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text">المنتجات والخدمات</span></a></li>
                            <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_calls" ? "active" : "" ?>"
                                aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/calls/"
                                                                                 class="m-menu__link "><i
                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                            class="m-menu__link-text"> المكالمات</span></a></li>
                        <?php }?>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->

