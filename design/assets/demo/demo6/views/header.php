<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
    <base href="<?=$url?>design/">
    <meta charset="utf-8" />
    <title><?= $title ?> CRM</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->


    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="assets/demo/demo6/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="vendors/toast/css/toastr.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/c3.css">
    <link rel="stylesheet" href="vendors/jquery-paginate-master/src/jquery.paginate.css">
    <link rel="stylesheet" type="text/css" href="vendors/DataTables/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="vendors/bootstrap-select/dist/css/bootstrap-select.min.rtl.css"/>



    <!--RTL version:<link href="assets/demo/demo6/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->
    <link rel="stylesheet" href="vendors/summernote/dist/summernote.min.rtl.css">
    <link href="assets/demo/demo6/base/ProjectStyle.css" rel="stylesheet" type="text/css" />


</head>

<!-- end::Head -->

<!-- begin::Body -->


<!-- begin::Body -->

<body
        class="header m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--fixed m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default">
<div class="showLoading" style="width: 100%;height: 100% ;position: absolute;
         right: 0;
         top: 0;background:rgba(255,255,255, 0.7);z-index: 100;">
    <div class="loading" style="z-index: 1000;"></div>
</div>
<input type="hidden" value="<?=$url?>" id="base">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page" style="flex: 0">

      <!-- BEGIN: Header -->
      <header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">


                    <div class="m-stack__item m-brand  m-brand--skin-light ">
                        <div class="m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--middle m-brand__logo">

                                <h3 class="m-header__title"></h3>
                            </div>
                            <div class="m-stack__item m-stack__item--middle m-brand__tools">

                                <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                                    class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                    <span></span>
                                </a>

                                <!-- END -->

                                <!-- BEGIN: Topbar Toggler -->
                                <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                                    class="m-brand__icon m--visible-tablet-and-mobile-inline-block">

                                </a>

                                <!-- BEGIN: Topbar Toggler -->
                            </div>
                        </div>
                    </div>
                    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <div class="row pt-3">
<div class="col-sm-3">
                        <div class="m-header__title">
                            <h3 class="m-header__title-text"><?= $title ?></h3>
                        </div>
                        </div>
<div class="col-sm-6">
                        <div id="clockdate" class="d-flex justify-content-center mt-2">
                            <div id="date"></div>
                                <div id="clock"></div>
                                
                            </div>
                            </div>
                        <!-- BEGIN: Horizontal Menu -->
                        <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light "
                            id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>


                        <!-- END: Horizontal Menu -->

                        <!-- BEGIN: Topbar -->
                        <div class="col-sm-3">
                        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-light"
                                id="m_quicksearch" m-quicksearch-mode="default">

                                <!--BEGIN: Search Form -->
                                <form></form>


                                <!--END: Search Form -->

                                <!--BEGIN: Search Results -->
                                <div class="m-dropdown__wrapper">
                                    <div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true"
                                                data-height="300" data-mobile-height="200">
                                                <div
                                                    class="m-dropdown__content m-list-search m-list-search--skin-light">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--BEGIN: END Results -->
                            </div>
                            <div class="m-stack__item m-topbar__nav-wrapper">
                                <ul class="m-topbar__nav m-nav m-nav--inline">


                                    <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                        m-dropdown-toggle="click">
                                        <a href="#" class="m-nav__link m-dropdown__toggle">
                                            <span class="m-topbar__userpic m--hide">
                                                <img src="assets/app/media/img/users/user4.jpg"
                                                    class="m--img-rounded m--marginless m--img-centered" alt="" />
                                            </span>
                                            <span class="m-nav__link-icon m-topbar__usericon">
                                               <span class="m-nav__link-icon-wrapper"><p class="pr-2">Admin</p><img src="assets/demo/demo6/media/img/profile/images.jpg"></span></span>
                                            </span>

                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span
                                                class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">

                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__section m--hide">
                                                                <span class="m-nav__section-text">Section</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="<?php echo $url?>users/edituser/"
                                                                   class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">تعديل البيانات</span>
                                                                </a>
                                                            </li>

                                                            <li class="m-nav__item">
                                                                <a href="<?php echo $url?>CRM_Users/logout"
                                                                   class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">تسجيل
                                                                    الخروج</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>
</div>
                        <!-- END: Topbar -->
                    </div>
                </div>
</div>
            </div>
        </header>

        <!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i
                    class="la la-close"></i></button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">

            <!-- BEGIN: Aside Menu -->
            <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light "
                 data-menu-vertical="true" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
                <div class="logo">
                    <a
                            href="<?php echo isset($_SESSION['date1']) ? $url.'CRM_Users/index/'.$_SESSION['date1'].'@'.$_SESSION['date2'] : $url.'users/'?>">
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

                    <?php if ($_SESSION["usertype"] !=1){
                        ?>

                        <li class="m-menu__item <?=  ($_SESSION["PAGE"] == "upcomingCalls") ? "active" : "" ?> "
                            aria-haspopup="true" m-menu-link-redirect="1"><a
                                    href="<?php echo $url.'CRM_Follows/upcomingCalls'?>" class="m-menu__link"><i
                                        class="m-menu__link-icon flaticon-alert"></i><span class="m-menu__link-text">
                                    <?php echo get_change(2)?>
                                    <span class="m-menu__link-badge"><span id="UpcommingCallsCount"
                                                                           class="m-badge m-badge--danger"><?php echo GetUpcommingCallsCount() ?></span></span> </span>
                            </a></li>

                    <?php }
                    $per2 = get_premissions($_SESSION['userid'],"11");
                    $per=get_premissions($_SESSION["userid"],'01');
                    if($_SESSION["usertype"]!=3  || $per2 == 1 || $per == 1)
                    {?>
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

                                    if($_SESSION["usertype"] < 3 || $per==1 || $per2 ==1 ){?>

                                        <li class="m-menu__item " data-toggle="modal" data-target="#load_file"
                                            aria-haspopup="true" m-menu-link-redirect="1"><a class="m-menu__link"><i
                                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                        class="m-menu__link-text" data-toggle="modal"
                                                        data-target="#exampleModalLong"> رفع الملف </span></a></li>

                                    <?php }if($_SESSION["usertype"]!=3 || $per2 == 1){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "task_view" ? "active" : "" ?> "
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'Mission/Assign'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">تعيين مهام </span></a></li><?php }?>
                                </ul>
                            </div>
                        </li>
                    <?php } ?>

                    <?php
                    $per = get_premissions($_SESSION['userid'],"08");
                    if($_SESSION["usertype"]!=3 || $per == 1){?>
                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "Employees" ? "active" : "" ?>"
                            aria-haspopup="true" m-menu-link-redirect="1"><a href="<?php echo $url.'Employees'?>"
                                                                             class="m-menu__link "><i class="m-menu__link-icon flaticon-user-settings"></i><span
                                        class="m-menu__link-text"><?php echo get_change(4)?>
                                   </span></a></li>
                    <?php  }
                    ?>
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
                        $per=get_premissions($_SESSION["userid"],'04'); // الاعدادات
                        $perDB=get_premissions($_SESSION["userid"],'03');

                        if($_SESSION["usertype"]==1 || $per==1  || $perDB==1  ){?>
                        <a href="" class="m-menu__link m-menu__toggle"><i
                                    class="m-menu__link-icon flaticon-cogwheel-1"></i><span
                                    class="m-menu__link-text"><?php echo get_change(10)?></span><i
                                    class="m-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="m-menu__submenu m-menu__submenu--up"><span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <?php if($_SESSION["usertype"]==1 || $per==1  ){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "Transfer" ? "active" : "" ?> "
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'Transfer'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text"> طرق الشحن </span></a></li>
                                <?php }?>
                                <?php if($_SESSION["usertype"]==1 || $per==1  ){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "Products" ? "active" : "" ?> "
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'Products'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">منتجات / وخدمات</span></a></li>

                                <?php }?>
                                <?php if($_SESSION["usertype"]==1 || $per==1 || $perDB == 1 ){?>
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?= $url.'users/DBBackUp'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">قاعده البيانات</span></a></li>
                                <?php }?>
                                <?php if($_SESSION["usertype"]==1 || $per==1  ){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "change_view" ? "active" : "" ?> "
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'users/change_view'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">تعديل لوحه التحكم</span></a></li>

                                <?php }?>
                                <?php if($_SESSION["usertype"]==1 || $per==1  ){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "company_data" ? "active" : "" ?>"
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'users/company_data'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">بيانات الشركه</span></a></li>
                                <?php }?>
                                <?php if($_SESSION["usertype"]==1 || $per==1  ){?>
                                    <li class="m-menu__item <?= $_SESSION["PAGE"] == "edit_mail" ? "active" : "" ?>"
                                        aria-haspopup="true" m-menu-link-redirect="1"><a
                                                href="<?php echo $url.'users/setEmail'?>" class="m-menu__link "><i
                                                    class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                    class="m-menu__link-text">الاعدادات البريد الالكترونى</span></a></li>
                                <?php }?>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php }?>

                    <?php
                    $per=get_premissions($_SESSION["userid"],'02');
                    if($_SESSION["usertype"]<=3 || $per == 1){?>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--bottom-1 <?= ( $_SESSION["PAGE"] == "reports_employee" ||$_SESSION["PAGE"] == "TargetedClients" ||$_SESSION["PAGE"] == "StaffEvaluation" ||$_SESSION["PAGE"] == "reports_Supervisor" || $_SESSION["PAGE"] == "reports_products" || $_SESSION["PAGE"] == "reports_calls" ) ? "opened" : "" ?>"
                            aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="#"
                                                                                  class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-file-2
"></i><span
                                        class="m-menu__link-text"><?php echo get_change(11)?></span><i
                                        class="m-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="m-menu__submenu m-menu__submenu--up"><span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <?php
                                    if($_SESSION["usertype"]<3 ||$per == 1 ){?>
                                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_employee" ? "active" : "" ?> "
                                            aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employee/3"
                                                                                             class="m-menu__link "><i
                                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                        class="m-menu__link-text">الموظفين</span></a></li>

                                        <?php if($_SESSION["usertype"]==1 ||$per == 1)
                                        {?>
                                            <li class="m-menu__item  <?= $_SESSION["PAGE"] == "reports_Supervisor" ? "active" : "" ?>"
                                                aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employee/2"
                                                                                                 class="m-menu__link "><i
                                                            class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                            class="m-menu__link-text">المشرفين</span></a></li>
                                        <?php }
                                        ?>
                                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "StaffEvaluation" ? "active" : "" ?> "
                                            aria-haspopup="true" m-menu-link-redirect="1">
                                            <a href="<?= $url ?>reports/StaffEvaluation"
                                               class="m-menu__link "><i
                                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                        class="m-menu__link-text">تقييم اداء الموظفين</span></a></li>
                                    <?php }

                                    if ($_SESSION["usertype"] == 2 || $_SESSION["usertype"] == 3){?>
                                        <li class="m-menu__item <?= $_SESSION["PAGE"] == "reports_employee" ? "active" : "" ?> "
                                            aria-haspopup="true" m-menu-link-redirect="1"><a href="<?= $url ?>reports/employeeDetails"
                                                                                             class="m-menu__link "><i
                                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                                        class="m-menu__link-text">تقاريرى</span></a></li>


                                    <?php }



                                    if($_SESSION["usertype"]==1 ||  $per == 1){?>
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
                    <?php   }?>



                </ul>
            </div>

            <!-- END: Aside Menu -->
        </div>

        <!-- END: Left Aside -->

    </div>

    <!-- end:: Body -->

</div>

<!-- end:: Page -->


<!-- end::Quick Sidebar -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->






<div class="modal fade" id="load_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> اضافه ملف </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>تحميل ملف</h5>
                <input type="file" accept=".xls, .xlsx, .csv" name="fileToUpload" class="form-control fileupload"
                       id="myfileData">
            </div>
            <div class="modal-footer">
                <button type="button" id="uploadFile" class="btn btn-primary"> حفظ</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>

            </div>
        </div>
    </div>
</div>



<!--begin::Global Theme Bundle -->
<script src="vendors/jquery/dist/jquery.js" type="text/javascript"></script>
<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="vendors/popper.js/dist/popper.js" type="text/javascript"></script>
<script src="vendors/bootstrap/js/dist/dropdown.js" type="text/javascript"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/demo/demo6/base/scripts.bundle.js" type="text/javascript"></script>
<script src="assets/app/js/dashboard.js" type="text/javascript"></script>
<script src="vendors/chart.js/dist/moment.js" type="text/javascript"></script>
<script src="vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Scripts -->
<script src="vendors/summernote/dist/summernote.min.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>
<script src="vendors/toast/js/toastr.min.js" type="text/javascript"></script>
<script src="vendors/toast/js/helper.js" type="text/javascript"></script>
<script src="vendors/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="vendors/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>







<script>

    $("document").ready(function(){
        $('.selectpicker').selectpicker();
    });




    $(".showLoading").hide();
    $(".copydata").click(function () {

        debugger;
        var base = $("#base").val();
        $.ajax({
            type: "POST",
            url: base + "users/copy",
            data: ({}),
            success: function (data) {
                if (data == 1) {
                    // toastr.success("تم تحميل قاعده البيانات بنجاح");
                    Show('تم تحميل قاعده البيانات بنجاح', "قاعدة البيانات");

                }
            }
        });
    });
</script>
<!--    notification -->

<script>
    <?php
    if (isset($_SESSION['usertype']))
    {
    if ($_SESSION['usertype'] == 1){?>
    setInterval(function () {
        GetCalls();
    }, 60000);
    <?php }else{ ?>
    setInterval(function () {
        GetCalls();
    }, 10000);
    <?php   }
    }
    ?>


    function GetCalls() {
        $.ajax({
            type: "POST",
            url: "<?=$url?>CRM_Users/SendNotification",
            data: ({}),
            success: function (data) {
                var result = $.parseJSON(data);

                if (result.Delayed > 0) {
                    var audio = new Audio("<?=$url?>design/sounds/slow-spring-board.mp3");
                    audio.play();
                    var msg = "يوجد عدد ";
                    msg = msg + result.Delayed;
                    msg = msg + " مكالمة متاخرة";
                    Show(msg, "" +
                        "" +
                        "" +
                        "مكالمات متاخرة");
                }
                if (result.Upcoming > 0) {
                    var audio = new Audio("<?=$url?>design/sounds/slow-spring-board.mp3");
                    audio.play();
                    var msg = "يوجد عدد ";
                    msg = msg + result.Upcoming;
                    msg = msg + " مكالمة قادمة";
                    Show(msg, "مكالمات قادمة");
                }


            }
        });
    }
</script>
<!--    Set Last Seen Time -->
<script>
    setInterval(function () {
        $.ajax({
            type: "POST",
            url: "<?=$url?>CRM_Users/SetLastSeen",
            data: ({}),
            success: function (data) {}
        });
        $.ajax({
            type: "POST",
            url: "<?=$url?>Mission/GetUserNotifications",
            data: ({}),
            success: function (data) {
                if (data == 1) {
                    Show("تم تحويل مهام جديده", "مهام جديدة");
                }
            }
        });


    }, 60000);
</script>
<!--    Check Offline Users -->
<script>
    setInterval(function () {
        $.ajax({
            type: "POST",
            url: "<?=$url?>CRM_Users/CheckOfflineUser",
            data: ({}),
            success: function (data) {}
        });

    }, 300000);
</script>

<script type="text/javascript">
    var base = $("#base").val();
    var idleTime = 0;
    $(document).ready(function () {
        var idleInterval = setInterval(timerIncrement, 60000);
        $(this).click(function (e) {
            idleTime = 0;
        });
        $(this).keypress(function (e) {
            idleTime = 0;
        });
    });

    function timerIncrement() {
        idleTime = idleTime + 1;
        if (idleTime > 30) {
            window.location = base + 'CRM_Users/logout';
        }
    }
</script>


<script>
    $('#uploadFile').click(function () {
        $(".showLoading").show();
        var newImg = $("#myfileData");
        var data = new FormData();
        var base = $("#base").val();
        data.append('img', newImg.prop('files')[0]);
        var base = $("#base").val();
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype: "json",
            url: base + "copydata",
            data: data,
            success: function (doc) {
                if (doc > 0) {
                    $(".showLoading").hide();
                    var msg = "تم رفع عدد ";
                    msg = msg +  doc;
                    msg = msg + " بنجاح ";
                    alert(msg);
                } else {
                    $(".showLoading").hide();
                    alert("حدث خطأ أثناء عمليه رفع البيانات");
                }
            }
        });
    });
</script>





<script src="assets/demo/demo6/base/project.js" type="text/javascript"></script>
</body>
<!-- end::Body -->

</html>