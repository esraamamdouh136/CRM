<?php $this->load->view("header");?>
<link href="vendors/jquery-paginate-master/src/jquery.paginate.css" rel="stylesheet">


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:10%; margin-left:3%; margin-top:1%;margin-bottom: 20%">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text" >
                            العملاء
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body tabs_border">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab"><i
                                    class="flaticon-list"></i> البيانات </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                            <i class="flaticon-support"></i>الاتصال </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab">
                            <i class="flaticon-layers"></i>شكوى &البريد الالكترونى & رساله نصيه </a>
                    </li>

                    <?php if ($_SESSION['usertype'] < 3){ ?>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4" role="tab"><i
                                        class="flaticon-refresh"></i>تحويل </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                        <div class="m-section m-section--last">
                            <div class="m-section__content font_span">
                                <input type="hidden" id="custid" class="custid" value="<?php echo $customer[0]->customerCrmId ?>">

                                <!--begin::Preview-->
                                <div class="m-demo__preview">
                                    <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                        <div class="m-stack__item m-stack__item--left">
                                            <span class="m-nav__link-text">
                                                <i class="m-nav__link-icon flaticon-user"></i>
                                                <b class="mr-2">الاسم
                                                    :</b> <?php echo $customer[0]->customerCrmName ?></span>
                                        </div>
                                        <div class="m-stack__item m-stack__item--left icon_sppourt">

                                            <i class="flaticon-support"></i></span>
                                            <span class="m-nav__link-text"><b class="mr-2">الهاتف :</b>
                                                <?php echo $customer[0]->customerCrmPhone ?>
                                            </span>
                                        </div>
                                        <div class="m-stack__item m-stack__item--left">
                                            <span class="m-nav__link-text">
                                                <i class="m-nav__link-icon flaticon-email"></i>
                                                <b class="mr-2">البريد الالكترونى :</b>
                                                <?php echo $customer[0]->customerCrmEmail ?> </span></div>
                                    </div>
                                    <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                        <div class="m-stack__item m-stack__item--left">
                                            <i class="m-nav__link-icon la la-transgender-alt"></i>
                                            <span class="m-nav__link-text"><b class="mr-2">النوع :</b> <?php
                                                if  ($customer[0]->customerCrmGender != 0 ){
                                                    echo "انثي";
                                                }else{
                                                    echo "ذكر";
                                                }
                                                ?>
                                            </span>

                                        </div>
                                        <div class="m-stack__item m-stack__item--left">
                                            <i class="m-nav__link-icon flaticon-calendar-with-a-clock-time-tools"></i>
                                            <span class="m-nav__link-text"><b class="mr-2">السن
                                                    :</b> <?php echo $customer[0]->customerCrmAge ?> </span></div>

                                        <div class="m-stack__item m-stack__item--left">
                                            <i class="m-nav__link-icon flaticon-network"></i>
                                            <span class="m-nav__link-text">
                                                <b class="mr-2"> الوظيفه :</b>
                                                <?php echo $customer[0]->customerCrmJob ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                        <div class="m-stack__item m-stack__item--left">
                                            <i class="m-nav__link-icon flaticon-home-2"></i>
                                            <span class="m-nav__link-text"><b class="mr-2">المحافظه :</b>
                                                <?php echo $customer[0]->customerCrmGov ?>
                                            </span> </div>
                                        <div class="m-stack__item m-stack__item--left"> <span
                                                    class="m-nav__link-text"><b class="mr-2"><i
                                                            class="m-nav__link-icon flaticon-home"></i>
                                                    العنوان :</b>  <?php echo $customer[0]->customerCrmAddress ?> </span></div>
                                        <div class="m-stack__item m-stack__item--left">
                                            <i class="m-nav__link-icon la la-building-o"></i>
                                            <span class="m-nav__link-text"><b class="mr-2">الشركه :</b>
                                                <?php echo $customer[0]->customerCrmCompany ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                        <div class="m-stack__item <?= ((isset($callStatus) && $callStatus == 3)||(isset($Orders) && count($Orders) > 0))? 'm-stack__item--center':'m-stack__item--right'?>">

                                            <span class="m-nav__link-text">
                                                <a href="<?php echo base_url() ?>Client/edit/<?php echo $customer_id ?>"
                                                   name="" id="" class="btn btn-info w-25 mt-2" role="button"> تعديل & المزيد</a>
                                            </span>
                                        </div>
                                        <?php if ((isset($callStatus) && $callStatus == 3)||(isset($Orders) && count($Orders) > 0)){?>
                                            <div class="m-stack__item m-stack__item--center" style="color:white;">
                                                <a name="" id="showDialog" class="btn btn-success w-25 mt-2" role="button">إضافة طلب شراء</a>

                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if (isset($callStatus) && $callStatus == 3 ||(isset($Orders) && count($Orders) > 0)) {?>
                                    <!--طلب الشراء-->
                                    <div class="Purchase_Order m-portlet__body w-100" style="display:none" id="new-order">

                                        <!--begin::Section-->
                                        <div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">

                                            <!--begin::Item-->
                                            <div class="m-accordion__item w-100">
                                                <div class="m-accordion__item-head collapsed" role="tab"
                                                     id="m_accordion_2_item_1_head" data-toggle="collapse"
                                                     href="#m_accordion_2_item_1_body" aria-expanded="false">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-cart"></i></span>
                                                    <span class="m-accordion__item-title"> الكميه </span>
                                                    <span class="m-accordion__item-mode"></span>
                                                </div>
                                                <div class="m-accordion__item-body collapse" id="m_accordion_2_item_1_body"
                                                     role="tabpanel" aria-labelledby="m_accordion_2_item_1_head"
                                                     data-parent="#m_accordion_2">
                                                    <div class="m-accordion__item-content">
                                                        <div class="row">
                                                            <div class="col-lg-12">


                                                                <?php
                                                                if(isset($Ordersettings) && !is_null($Ordersettings)){
                                                                    $chiledSettings = null;
                                                                    foreach ($Ordersettings as $Setting){?>

                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <label class="m-checkbox col-lg-4"><?php
                                                                                    if  ($Setting->Pro_Name !='Amount' && $Setting->Pro_Name !='Contracted'){
                                                                                        echo $Setting->Text;
                                                                                    }
                                                                                    ?>
                                                                                </label>
                                                                                <?php

                                                                                if($Setting->Pro_Name == 'Type'){?>
                                                                                    <div class="col-lg-4 d-flex">
                                                                                        <?php
                                                                                        $chiledSettings = GetOrderSettings($Setting->ID);
                                                                                        $value = 0;
                                                                                        foreach ($chiledSettings as $chiled){
                                                                                            if ($chiled->Pro_Name == 'product'){
                                                                                                $value = 1;
                                                                                            }else{
                                                                                                $value = 2;
                                                                                            }

                                                                                            ?>

                                                                                            <div>
                                                                                                <label class="m-checkbox mr-2">
                                                                                                    <input type="radio" name="type"
                                                                                                           value="<?php echo $value ?>"
                                                                                                           onclick="Neworderchangetype(<?php echo $value ?>)"><?php echo $chiled->Text ?>
                                                                                                    <span></span>
                                                                                                </label>

                                                                                                <span></span>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>


                                                                                    </div>
                                                                                    <?php
                                                                                }else if ($Setting->Pro_Name =='Products'){?>
                                                                                    <div class="col-lg-6">
                                                                                        <select name="product"
                                                                                                id="newOrderselectServiceandProudct"
                                                                                                class="select2 form-control ">
                                                                                        </select>
                                                                                    </div>
                                                                                <?php }else if ($Setting->Pro_Name =='Quantity'){ ?>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="number" min="0" value="0"
                                                                                               name="qyt" class="form-control"
                                                                                               id="newquantity">
                                                                                    </div>
                                                                                <?php }else if ($Setting->Pro_Name =='Transfer'){ ?>
                                                                                    <div class="col-lg-6 d-flex">
                                                                                        <select name="truck" id="newtransferType"
                                                                                                class="select2 form-control col-sm-6">
                                                                                            <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                                                                                <option
                                                                                                        value="<?php echo $trucks[$i]->transfer_ID?>"
                                                                                                        cost="<?php echo $trucks[$i]->Price?>">
                                                                                                    <?php echo $trucks[$i]->transfer_Name?>
                                                                                                </option>
                                                                                            <?php }  }?>
                                                                                        </select>
                                                                                        <input id="newtruckCost" value="0" type="number"
                                                                                               class="form-control col-sm-6">
                                                                                    </div>
                                                                                <?php }else if ($Setting->Pro_Name =='Payment'){ ?>
                                                                                    <div class="col-lg-6">
                                                                                        <select name="truck" id="newpaymentType"
                                                                                                class="select2 form-control">
                                                                                            <?php  if(isset($PaymentTypes)){ for($i=0;$i<count($PaymentTypes);$i++){?>
                                                                                                <option
                                                                                                        value="<?php echo $PaymentTypes[$i]->ID?>">
                                                                                                    <?php echo $PaymentTypes[$i]->Name?>
                                                                                                </option>
                                                                                            <?php }  }?>
                                                                                        </select>
                                                                                    </div>
                                                                                <?php }else if ($Setting->Pro_Name =='Amount'){?>
                                                                                    <div class="col-lg-6">
                                                                                        <?php
                                                                                        $chiledSettings2 = GetOrderSettings($Setting->ID);
                                                                                        $value = 0;
                                                                                        foreach ($chiledSettings2 as $chiled){?>
                                                                                            <div>
                                                                                                <label>
                                                                                                    <?php echo $chiled->Text ?>
                                                                                                </label>
                                                                                                <input type="number" value="0"
                                                                                                       name="<?php echo $chiled->Pro_Name ?>">
                                                                                            </div>
                                                                                            <?php
                                                                                        }?>
                                                                                        <input type="text" name="date"
                                                                                               style="margin-top: 10px"
                                                                                               class="form-control datepicker datepickerDetailsPage"
                                                                                               value="<?php echo date("Y-m-d")?>"
                                                                                               id="date22" data-format="yyyy-mm-dd">
                                                                                        <?php

                                                                                        ?>


                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                <div class="form-row">
                                                                    <div class="control-label col-lg-4">
                                                                        <label>الخصم</label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="number" value="0" id="newdiscount"
                                                                               class="form-control">
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <select id="newdiscountType" class="form-control">
                                                                            <option value="0">نسبة%</option>
                                                                            <option value="1">مبلغ</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <button type="button" class="btn btn-info btn-md w-25 ml-auto mt-4"
                                                                            id="newAddOrder">إضافة</button>
                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--end::Item-->
                                            <form method="post" action="<?php echo $url."ClientOrders/addNewOrder"?>">
                                                <!--begin::Item-->
                                                <div class="m-accordion__item">
                                                    <div class="m-accordion__item-head collapsed" role="tab"
                                                         id="m_accordion_2_item_2_head" data-toggle="collapse"
                                                         href="#m_accordion_2_item_2_body" aria-expanded="    false">
                                                        <span class="m-accordion__item-icon"><i class="flaticon-bag"></i></span>
                                                        <span class="m-accordion__item-title"> اضافه </span>
                                                        <span class="m-accordion__item-mode"></span>
                                                    </div>
                                                    <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_2_body"
                                                         role="tabpanel" aria-labelledby="m_accordion_2_item_2_head"
                                                         data-parent="#m_accordion_2">
                                                        <div class="m-accordion__item-content">
                                                            <div class="m-portlet__body">

                                                                <!--begin: Datatable -->

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                    class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline example"
                                                                                    id="updateOrderItems" role="grid"
                                                                                    aria-describedby="m_table_1_info"
                                                                                    style="width: 974px;">
                                                                                <thead>

                                                                                <tr role="row">
                                                                                    <th class="sorting" tabindex="0"
                                                                                        aria-controls="m_table_1"
                                                                                        rowspan="1" colspan="1"
                                                                                        style="width: 63.25px;"
                                                                                        aria-label="Order ID: activate to sort column ascending">
                                                                                        الاسم</th>
                                                                                    <th class="sorting" tabindex="0"
                                                                                        aria-controls="m_table_1"
                                                                                        rowspan="1" colspan="1"
                                                                                        style="width: 65.25px;"
                                                                                        aria-label="Country: activate to sort column ascending">
                                                                                        الكميه</th>
                                                                                    <th class="sorting" tabindex="0"
                                                                                        aria-controls="m_table_1"
                                                                                        rowspan="1" colspan="1"
                                                                                        style="width: 100.25px;"
                                                                                        aria-label="Ship Address: activate to sort column ascending">
                                                                                        طريقه الشحن</th>
                                                                                    <th class="sorting" tabindex="0"
                                                                                        aria-controls="m_table_1"
                                                                                        rowspan="1" colspan="1"
                                                                                        style="width: 82.25px;"
                                                                                        aria-label="Company Agent: activate to sort column ascending">
                                                                                        طريقه الدفع</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                </thead>

                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--end::Item-->

                                                <!--begin::Item-->
                                                <div class="m-accordion__item">
                                                    <div class="m-accordion__item-head collapsed" role="tab"
                                                         id="m_accordion_2_item_3_head" data-toggle="collapse"
                                                         href="#m_accordion_2_item_3_body" aria-expanded="    false">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-coins"></i></span>
                                                        <span class="m-accordion__item-title">التكلفه</span>
                                                        <span class="m-accordion__item-mode"></span>
                                                    </div>
                                                    <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_3_body"
                                                         role="tabpanel" aria-labelledby="m_accordion_2_item_3_head"
                                                         data-parent="#m_accordion_2">
                                                        <div class="m-accordion__item-content">

                                                            <table class="table">
                                                                <tbody>
                                                                <tr>
                                                                    <td> <label>التكلفة :</label>
                                                                        <label id="newproductCost">0</label>
                                                                        <input type="hidden" value=""
                                                                               id="newproductCost_hidden" name="productCost">
                                                                    </td>
                                                                    <td> <label>تكلفة الشحن :</label>
                                                                        <label id="newTransferCost">0</label>
                                                                        <input type="hidden" value=""
                                                                               id="newTransferCost_hidden" name="TransferCost">
                                                                    </td>
                                                                    <td> <label>الخصم :</label>
                                                                        <label id="newDiscountValue">0</label>
                                                                        <input type="hidden" value=""
                                                                               id="newDiscountValue_hidden" name="DiscountValue">
                                                                    </td>
                                                                    <td> <label>الاجمالى :</label>
                                                                        <label id="newTotal">0</label>
                                                                        <input type="hidden" value="" id="newTotal_hidden"
                                                                               name="Total">
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-form-label col-lg-3 col-sm-12">
                                                                    تاريخ</label>
                                                                <div class="col-lg-8 col-md-4 col-sm-12">
                                                                    <div class="input-group date">
                                                                        <input type="text" name="date"
                                                                               class="form-control datepickerDetailsPage"
                                                                               id="m_datetimepicker_6"
                                                                               value="<?php echo date("Y-m-d")?>" id="date"
                                                                               data-format="yyyy-mm-dd">

                                                                        <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-calendar glyphicon-th"></i>
                                                                    </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-group m-form__group row">
                                                                <label class="col-form-label col-lg-3 col-sm-12">الوقت</label>
                                                                <div class="col-lg-8 col-md-9 col-sm-12">
                                                                    <div class="input-group date">

                                                                        <input type="text" name="time"
                                                                               class="form-control m-input timebakerInput1" id="dates"

                                                                               data-template="dropdown" data-show-seconds="true"
                                                                               data-show-meridian="false" data-minute-step="5"
                                                                               data-second-step="5" >

                                                                        <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-time glyphicon-th"></i>
                                                                    </span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class=row>
                                                                    <label class="control-label col-lg-3">تعليق :</label>
                                                                    <div class="col-lg-8">
                                                                <textarea class="form-control estext w-100 ckeditor"  rows="7"
                                                                          id="comment" name="comment "></textarea>
                                                                        <input type="hidden"
                                                                               value="<?php echo $customer[0]->customerCrmId?>"
                                                                               name="clientid">
                                                                        <input type="hidden" name="callStatus" id="callStatus"
                                                                               value="0">
                                                                        <input type="hidden" class="CallID" name="callID"
                                                                               value="0">
                                                                        <input type="hidden" class="IsCall" name="IsCall"
                                                                               value="0">
                                                                        <input class="btn btn-info btn-md mb-3 w-25 mt-4 float-right"
                                                                               type="submit" value="تسسسم">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--end::Item-->
                                        </div>

                                        <!--end::Section-->
                                    </div>
                                    <!--طلب الشراء-->
                                <?php } ?>




                                <?php if(isset($Orders) && count($Orders) > 0){?>

                                    <!--جدول المشتريات-->
                                    <div class="Proc_table
											m-portlet__body ">

                                        <!--begin: Datatable -->
                                        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer mt-5">
                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table
                                                                class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                                                id="example_1" role="grid" aria-describedby="m_table_1_info"
                                                        >
                                                            <thead>
                                                            <tr>

                                                                <th style="width:100px;">التاريخ</th>
                                                                <th style="width:100px;">التكلفة</th>
                                                                <th style="width:100px;">العميل</th>
                                                                <th style="width:100px;">الموظف</th>
                                                                <th style="width:100px;"> التعليمات</th>
                                                            </tr>
                                                            </thead>
                                                            <input type="hidden" class="cliecount" value="<?= isset($Orders) ? count($Orders) : "0" ?>">
                                                            <tbody>
                                                            <?php if(isset($Orders)){ for($i=0;$i< count($Orders);$i++){

                                                                ?>
                                                                <tr class="table-row" >

                                                                    <td>
                                                                        <?php echo date('Y-m-d', strtotime($Orders[$i]->Date))?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $Orders[$i]->Net_Cost  ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php echo $Orders[$i]->customerCrmName  ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php echo $Orders[$i]->Name  ?>
                                                                    </td>

                                                                    <td class="op">
                                                                        <a class="btn btn-outline-info" href="<?php echo base_url()."ClientOrders/OrderDetails/".$Orders[$i]->ID ?>"> <span class="entypo-window" style="cursor: pointer"></span> تفاصيل </a>
                                                                        <button class="btn btn-outline-danger btn-md deleteCustomerOrder" orderID = "<?php echo $Orders[$i]->ID ?>" > <span class="entypo-cancel" style="cursor: pointer"></span>  حذف </button>
                                                                    </td>
                                                                </tr>
                                                            <?php } }?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php }


                                ?>

                                <!--جدول المشتريات-->



                                <!-- تعليق-->

                                <div class="comment container ml-3">
                                    <h4 class="mt-5"> تعليقات </h4>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-8 col-md-9 col-sm-12">
                                        <textarea type="text" id="new-comment" class="form-control " name="editor1" placeholder="أكتب تعليقك"
                                                  rows="10" cols="33"></textarea>

                                        </div>
                                    </div>
                                    <button type="button" class="sendComment btn btn-info my-5 w-25">
                                        اضافه تعليق
                                    </button>
                                    <?php if(isset($Comments) && count($Comments) > 0){?>
                                        <ul id="paginate">
                                            <?php
                                            if (isset($Comments)){
                                                if (count($Comments) > 0){
                                                    for ($i=0;$i<count($Comments);$i++){?>

                                                        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                            <div class="row border mb-3">
                                                                <div class="col-sm-12">
                                                                    <li>
                                                                        <div class="m-widget3">
                                                                            <div class="m-widget3__item">
                                                                                <div class="m-widget3__header">
                                                                                    <div class="m-widget3__user-img border p-2 mt-2">
                                                                                        <?php $Image = get_Emp_ProfileImage($Comments[$i]->UserID); ?>

                                                                                        <img src="<?=(isset($Image) && !is_null($Image))? $url."ProfielsImages/".$Image: "assets/demo/demo6/media/img/profile/profile.jpg"?>" class="m-widget3__img">


                                                                                    </div>
                                                                                    <div class="m-widget3__info text-break" style="overflow-wrap: break-word;word-break: break-word;" >
																						<span class="m-widget3__username">
																							 <?php echo get_Emp_name($Comments[$i]->UserID)?>
																						</span><br>
                                                                                        <span class="m-widget3__time text-break" style="overflow-wrap: break-word;word-break: break-word;">
																						</span>
                                                                                        <?php echo htmlspecialchars_decode($Comments[$i]->Comment_Text) ?>

                                                                                        </span>
                                                                                        <?php
                                                                                        if(isset($Comments[$i]->Duration) && !is_null($Comments[$i]->Duration)){?>

                                                                                            <footer>
                                                                                                مدة المكالمة
                                                                                                <time class="comment-date" datetime="<?php echo $Comments[$i]->Duration ?>"><i
                                                                                                            class="fa fa-clock-o"></i>
                                                                                                    <?php echo ' '.$Comments[$i]->Duration ?></time>
                                                                                            </footer>


                                                                                        <?php  }
                                                                                        ?>

                                                                                    </div>

                                                                                </div>
                                                                                <div class="m-widget3__body">
                                                                                    <p class="m-widget3__text">
                                                                                        <time class="comment-date" datetime="<?php echo $Comments[$i]->date ?>"><i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                            <?php echo ' '.$Comments[$i]->date ?></time>  /    <time class="comment-date" datetime="<?php echo date("h:i:s A",strtotime($Comments[$i]->time)) ?>"><i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                            <?php echo ' '.date("h:i:s A",strtotime($Comments[$i]->time)) ?></time>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </li>
                                                    <?php                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    <?php }
                                    ?>
                                </div>
                                <!-- تعليق-->
                                <!--begin::Dropdown-->

                                <!--end::Dropdown-->
                            </div>
                        </div>
                    </div>




                    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                        <!--buttons top-->
                        <div class="buttons">
                            <div class="row new-call">

                                <div class="buttons" id="divchangestatus"  style="display:none">
                                    <button type="button" onclick="renewStatus()" class="btn btn-focus mr-2"  > طلب
                                        تجديد الحاله</button>
                                    <button type="button" onclick="showStatus()"  class="btn btn-info mr-2" > طلب
                                        تغير الحاله</button>
                                    <?php if ($callStatus == 5){ ?>
                                        <button type="button" onclick="showDeContracted()"  class="btn btn-warning mr-2" > طلب
                                            إلغاء التعاقد </button>
                                    <?php } else { ?>
                                        <button type="button" onclick="showContracted()"  class="btn btn-warning mr-2" > طلب
                                            تم التعاقد </button>
                                    <?php }
                                    ?>

                                </div>







                                <div class="m-stack__item m-stack__item--right ml-auto bg_badge d-flex">
                                    <input type="hidden" id="custmer_id" value="<?php echo $customer_id ?>">
                                    <input type="hidden" class="CallID" value="0">
                                    <span class="m-badge m-badge--wide m-badge--rounded mt-2" id="date_time">

                                    <label id="seconds"  class="text-danger">00</label>:<label id="minutes" class="text-danger">00</label>
                                    </span>
                                    <span class="m-badge m-badge--wide m-badge--rounded mt-2" onclick="endcall()" disabled id="buttonCallEnded" style="display:none;">
													<i class="flaticon-cancel  mt-2"></i></span>
                                    <span  onclick="startcall()" class="m-badge m-badge--danger m-badge--wide m-badge--rounded mt-2 start-call" id="buttonCallStart">
                                                            <i class="flaticon-support"></i></span>

                                </div>
                            </div>
                        </div>
                        <?php $startTime = date("H:i:s");
                        $plus='+'.$time[0]['settingcrmTimeMinute'].' minutes';
                        $cenvertedTime = date('H:i:s',strtotime($plus,strtotime($startTime)));
                        ?>
                        <!--تجديد الحاله-->
                        <div class="new-case m-portlet__body w-100 d-none" id="renewStatusDiv">

                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1 col-sm-12"> تاريخ</label>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input datepickerDetailsPage" id="m_datetimepicker_1">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="flaticon-calendar glyphicon-th"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1 col-sm-12">الوقت</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control m-input datepickerDetailsPage" id="m_datetimepicker_2">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="flaticon-time glyphicon-th"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-1 col-sm-12">تعليق</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">

                                    <textarea class="form-control ckeditor" rows="7" cols="50"></textarea>

                                </div>
                            </div>

                        </div>
                        <!--تجديد الحاله-->
                        <!--حاله جديده-->




                        <div class="change-case m-portlet__body border mt-3 " id="DivCallStatus" style="display:none">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group m-form__group row">
                                        <label for="example-password-input" class="col-lg-5 col-sm-12 col-form-label">
                                            حاله الاتصال بالعميل :
                                        </label>
                                        <div class="col-lg-7 col-sm-12">
                                            <select class="form-control select2-static" id="callStatusChange">
                                                <option value="0" selected>إختر حالة المكالمة</option>
                                                <option value="1">تم الرد</option>
                                                <option value="2"> لم يتم الرد</option>
                                                <option value="3">  أرقام خاطئة </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 " id="ans" style="display:none;">
                                    <div class="form-group m-form__group row">
                                        <label for="example-password-input" class="col-4 col-form-label">
                                            نتيجه المكالمه :
                                        </label>
                                        <div class="col-lg-8 col-sm-12">
                                            <select class="form-control select2-static" id="ansSelect">
                                                <option value="0" selected>إختر نتيجة المكالمة</option>
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
                                                    <option statusid="<?php echo $answer[$i]->id?>" name="optradioes" value="<?php echo $val?>"><?php echo $answer[$i]->title?></option>
                                                <?php }?>
                                                <option  name="optradioes" value="3">قيد الحجز</option>
                                            </select>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <!--                                قيد الحجز-->
                                <div class="col-md-4 col-sm-12 " id="reserve" style="display:none;">
                                    <div class="form-group m-form__group row">
                                        <label for="example-password-input" class="col-4 col-form-label">
                                            قيد الحجز :
                                        </label>
                                        <div class="col-lg-8 col-sm-12">
                                            <select class="form-control select2-static" id="reserveSelect">
                                                <option value="0" selected>إختر نتيجة المكالمة</option>
                                                <?php if(isset($reserve))
                                                {
                                                for($i=0;$i<count($reserve);$i++)
                                                {
                                                    if($reserve[$i]->status  == 4)
                                                    {
                                                        $val=2;
                                                    }
                                                    else
                                                    {
                                                        $val=1;
                                                    }
                                                    ?>
                                                    <option statusid="<?php echo $reserve[$i]->id?>" name="optradioes" value="<?php echo $val?>"><?php echo $reserve[$i]->title?></option>
                                                <?php }?>

                                            </select>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>

                                <!--لم يتم الرد-->
                                <div class="col-md-4 col-sm-12 " id="not-ans" style="display:none;">
                                    <div class="form-group m-form__group row">
                                        <label for="example-password-input" class="col-4 col-form-label">
                                            نتيجه المكالمه :
                                        </label>
                                        <div class="col-lg-8 col-sm-12">
                                            <select class="form-control select2-static" id="noansSelect">
                                                <option value="0" selected>إختر نتيجة المكالمة</option>
                                                <?php if(isset($noanswer))
                                                {
                                                for($i=0;$i<count($noanswer);$i++)
                                                {
                                                    if($noanswer[$i]->status  == 3)
                                                    {
                                                        $val=0;
                                                    }
                                                    else
                                                    {
                                                        $val=1;
                                                    }
                                                    ?>
                                                    <option statusid="<?php echo $noanswer[$i]->id?>" name="optradioes" value="<?php echo $val?>"><?php echo $noanswer[$i]->title?></option>
                                                <?php }?>

                                            </select>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>


                                <!--أرقام خطأ-->
                                <div class="col-md-4 col-sm-12 " id="wrong" style="display:none;">
                                    <div class="form-group m-form__group row">
                                        <label for="example-password-input" class="col-4 col-form-label">
                                            نتيجه المكالمه :
                                        </label>
                                        <div class="col-lg-8 col-sm-12">
                                            <select class="form-control select2-static" id="wrongSelect">
                                                <option value="0" selected>إختر نتيجة المكالمة</option>
                                                <?php if(isset($wrong))
                                                {
                                                for($i=0;$i<count($wrong);$i++)
                                                {
                                                    if($wrong[$i]->status  == 4)
                                                    {
                                                        $val=2;
                                                    }
                                                    else
                                                    {
                                                        $val=1;
                                                    }
                                                    ?>
                                                    <option statusid="<?php echo $wrong[$i]->id?>" name="optradioes" value="<?php echo $val?>"><?php echo $wrong[$i]->title?></option>
                                                <?php }?>

                                            </select>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                            comment & date time-->
                            <div class="new-case m-portlet__body w-100 " style="display: none;" id="noanswer">
                                <form method="post" onSubmit = "return checkForm(event,this)" action="<?php echo $url."users/update_status"?>">
                                    <input type="hidden" class="statusid" id="flag_num" name="flag">
                                    <input type="hidden" class="CallID" name="CallID" value="0">
                                    <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                                    <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">

                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">تاريخ معاودة الاتصال</label>
                                        <div class="col-lg-8 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text" class="form-control m-input datepickerDetailsPage callDate"
                                                       name="date">
                                                <div class="input-group-append">
														<span class="input-group-text">
															<i class="flaticon-calendar glyphicon-th"></i>
														</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="form-group m-form__group row" >
                                        <label class="col-form-label col-lg-2 col-sm-12">وقت معاودة الاتصال</label>
                                        <div class="col-lg-8 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text" name="time" class="form-control m-input timebakerInput1"
                                                       id="callTime">
                                                <div class="input-group-append">
														<span class="input-group-text">
															<i class="flaticon-time glyphicon-th"></i>
														</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">تعليق</label>
                                        <div class="col-lg-8 col-md-9 col-sm-12">

                                         <textarea type="text" id="comment" name="comment" class="form-control ckeditor" placeholder="أكتب تعليقك"
                                                   rows="10" cols="33"></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <input class="btn btn-info ml-auto px-5" id="tesclick" type="submit"  value="تم">
                                    </div>
                                </form>
                            </div>
                            <!--                            comment-->
                            <div class="new-case m-portlet__body w-100 " style="display: none;" id="wrongDiv">
                                <form method="post"  action="<?php echo $url."users/update_status"?>">
                                    <input type="hidden" class="statusid" id="flag_num" name="flag">
                                    <input type="hidden" class="CallID" name="CallID" value="0">
                                    <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                                    <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">

                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-1 col-sm-12">تعليق</label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">

                                         <textarea type="text" id="comment" name="comment" class="form-control ckeditor" placeholder="أكتب تعليقك"
                                                   rows="10" cols="33"></textarea>

                                        </div>
                                    </div>
                                    <input class="btn btn-info ml-auto float-right px-5" id="tesclick" style="margin: 20px;" type="submit"  value="تم">

                                </form>
                            </div>
                            <!--طلب الشراء-->
                            <div class="Purchase_Order m-portlet__body w-100" style="display:none" id="add-order">
                                <!--begin::Section-->
                                <div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">
                                    <!--begin::Item-->


                                    <div class="m-accordion__item w-100">
                                        <div class="m-accordion__item-head " role="tab"
                                             id="m_accordion_2_item_1_head" data-toggle="collapse"
                                             href="#m_accordion_2_item_1_body" aria-expanded="true">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-cart"></i></span>
                                            <span class="m-accordion__item-title"> الكميه </span>
                                            <span class="m-accordion__item-mode"></span>
                                        </div>
                                        <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_1_body"
                                             role="tabpanel" aria-labelledby="m_accordion_2_item_1_head"
                                             data-parent="#m_accordion_2">
                                            <div class="m-accordion__item-content">
                                                <div class="row">
                                                    <div class="col-lg-12">


                                                        <?php
                                                        if(isset($Ordersettings) && !is_null($Ordersettings)){
                                                            $chiledSettings = null;
                                                            foreach ($Ordersettings as $Setting){?>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label class="m-checkbox col-lg-4"><?php
                                                                            if  ($Setting->Pro_Name !='Amount' && $Setting->Pro_Name !='Contracted'){
                                                                                echo $Setting->Text;
                                                                            }
                                                                            ?>
                                                                        </label>
                                                                        <?php

                                                                        if($Setting->Pro_Name == 'Type'){?>
                                                                            <div class="col-lg-4 d-flex">
                                                                                <?php
                                                                                $chiledSettings = GetOrderSettings($Setting->ID);
                                                                                $value = 0;
                                                                                foreach ($chiledSettings as $chiled){
                                                                                    if ($chiled->Pro_Name == 'product'){
                                                                                        $value = 1;
                                                                                    }else{
                                                                                        $value = 2;
                                                                                    }

                                                                                    ?>

                                                                                    <div>
                                                                                        <label class="m-checkbox mr-2">
                                                                                            <input type="checkbox" name="type"
                                                                                                   value="<?php echo $value ?>"
                                                                                                   onclick="changetype(<?php echo $value ?>)"><?php echo $chiled->Text ?>
                                                                                            <span></span>
                                                                                        </label>

                                                                                        <span></span>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>


                                                                            </div>
                                                                            <?php
                                                                        }else if ($Setting->Pro_Name =='Products'){?>
                                                                            <div class="col-lg-6">
                                                                                <select name="product"
                                                                                        id="selectServiceandProudct"
                                                                                        class="select2 form-control ">
                                                                                </select>
                                                                            </div>
                                                                        <?php }else if ($Setting->Pro_Name =='Quantity'){ ?>
                                                                            <div class="col-lg-6">
                                                                                <input type="number" min="0" value="0" name="qyt" class="form-control" id="quantity">
                                                                            </div>
                                                                        <?php }else if ($Setting->Pro_Name =='Transfer'){ ?>
                                                                            <div class="col-lg-6 d-flex">
                                                                                <select name="truck" id="transferType"
                                                                                        class="select2 form-control col-sm-6">
                                                                                    <?php  if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                                                                                        <option
                                                                                                value="<?php echo $trucks[$i]->transfer_ID?>"
                                                                                                cost="<?php echo $trucks[$i]->Price?>">
                                                                                            <?php echo $trucks[$i]->transfer_Name?>
                                                                                        </option>
                                                                                    <?php }  }?>
                                                                                </select>
                                                                                <input id="truckCost" value="0" type="number"
                                                                                       class="form-control col-sm-6">
                                                                            </div>
                                                                        <?php }else if ($Setting->Pro_Name =='Payment'){ ?>
                                                                            <div class="col-lg-6">
                                                                                <select name="truck" id="paymentType"
                                                                                        class="select2 form-control">
                                                                                    <?php  if(isset($PaymentTypes)){ for($i=0;$i<count($PaymentTypes);$i++){?>
                                                                                        <option
                                                                                                value="<?php echo $PaymentTypes[$i]->ID?>">
                                                                                            <?php echo $PaymentTypes[$i]->Name?>
                                                                                        </option>
                                                                                    <?php }  }?>
                                                                                </select>
                                                                            </div>
                                                                        <?php }else if ($Setting->Pro_Name =='Amount'){?>
                                                                            <div class="col-lg-6">
                                                                                <?php
                                                                                $chiledSettings2 = GetOrderSettings($Setting->ID);
                                                                                $value = 0;
                                                                                foreach ($chiledSettings2 as $chiled){?>
                                                                                    <div>
                                                                                        <label>
                                                                                            <?php echo $chiled->Text ?>
                                                                                        </label>
                                                                                        <input type="number" value="0"
                                                                                               name="<?php echo $chiled->Pro_Name ?>">
                                                                                    </div>
                                                                                    <?php
                                                                                }?>
                                                                                <input type="text" name="date"
                                                                                       style="margin-top: 10px"
                                                                                       class="form-control datepicker datepickerDetailsPage"
                                                                                       value="<?php echo date("Y-m-d")?>"
                                                                                       id="date22" data-format="yyyy-mm-dd">
                                                                                <?php

                                                                                ?>


                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <div class="form-row">
                                                            <div class="control-label col-lg-4">
                                                                <label>الخصم</label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <input type="number" value="0" id="discount"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <select id="discountType" class="form-control">
                                                                    <option value="0">نسبة%</option>
                                                                    <option value="1">مبلغ</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <button type="button" class="btn btn-info btn-md w-25 ml-auto mt-4"
                                                                    id="AddOrder">إضافة</button>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Item-->
                                    <form method="post" action="<?php echo $url."ClientOrders/addNewOrder"?>">
                                        <!--begin::Item-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_2_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_2_body" aria-expanded="false">
                                                <span class="m-accordion__item-icon"><i class="flaticon-bag"></i></span>
                                                <span class="m-accordion__item-title"> اضافه </span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_2_body"
                                                 role="tabpanel" aria-labelledby="m_accordion_2_item_2_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <div class="m-portlet__body">

                                                        <!--begin: Datatable -->


                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table
                                                                            class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline example"
                                                                            id="OrderItems" role="grid"
                                                                            aria-describedby="m_table_1_info"
                                                                            style="width: 974px;">
                                                                        <thead>

                                                                        <tr role="row">
                                                                            <th class="sorting" tabindex="0"
                                                                                aria-controls="m_table_1"
                                                                                rowspan="1" colspan="1"
                                                                                style="width: 63.25px;"
                                                                                aria-label="Order ID: activate to sort column ascending">
                                                                                الاسم</th>
                                                                            <th class="sorting" tabindex="0"
                                                                                aria-controls="m_table_1"
                                                                                rowspan="1" colspan="1"
                                                                                style="width: 65.25px;"
                                                                                aria-label="Country: activate to sort column ascending">
                                                                                الكميه</th>
                                                                            <th class="sorting" tabindex="0"
                                                                                aria-controls="m_table_1"
                                                                                rowspan="1" colspan="1"
                                                                                style="width: 100.25px;"
                                                                                aria-label="Ship Address: activate to sort column ascending">
                                                                                طريقه الشحن</th>
                                                                            <th class="sorting" tabindex="0"
                                                                                aria-controls="m_table_1"
                                                                                rowspan="1" colspan="1"
                                                                                style="width: 82.25px;"
                                                                                aria-label="Company Agent: activate to sort column ascending">
                                                                                طريقه الدفع</th>
                                                                            <th></th>
                                                                        </tr>
                                                                        </thead>

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_3_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_3_body" aria-expanded="false">
                                                <span class="m-accordion__item-icon"><i
                                                            class="flaticon-coins"></i></span>
                                                <span class="m-accordion__item-title">التكلفه</span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_3_body"
                                                 role="tabpanel" aria-labelledby="m_accordion_2_item_3_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td> <label>التكلفة :</label>
                                                                <label id="productCost">0</label>
                                                                <input type="hidden" value="" id="productCost_hidden" name="productCost">
                                                            </td>
                                                            <td> <label>تكلفة الشحن :</label>
                                                                <label id="TransferCost">0</label>
                                                                <input type="hidden" value="" id="TransferCost_hidden" name="TransferCost">
                                                            </td>
                                                            <td> <label>الخصم :</label>
                                                                <label id="DiscountValue">0</label>
                                                                <input type="hidden" value="" id="DiscountValue_hidden" name="DiscountValue">
                                                            </td>
                                                            <td> <label>الاجمالى :</label>
                                                                <label id="Total">0</label>
                                                                <input type="hidden" value="" id="Total_hidden" name="Total">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-form-label col-lg-3 col-sm-12">
                                                            تاريخ</label>
                                                        <div class="col-lg-8 col-md-4 col-sm-12">
                                                            <div class="input-group date">
                                                                <input type="text" name="date"
                                                                       class="form-control datepickerDetailsPage"
                                                                       id="m_datetimepicker_6"
                                                                       value="<?php echo date("Y-m-d")?>" id="date"
                                                                       data-format="yyyy-mm-dd">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-calendar glyphicon-th"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label class="col-form-label col-lg-3 col-sm-12">الوقت</label>
                                                        <div class="col-lg-8 col-md-9 col-sm-12">
                                                            <div class="input-group date">
                                                                <input type="text" name="time"
                                                                       class="form-control m-input timebakerInput1" id="dates"
                                                                       data-template="dropdown" data-show-seconds="true"
                                                                       data-show-meridian="false" data-minute-step="5"
                                                                       data-second-step="5" >

                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="flaticon-time glyphicon-th"></i>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class=row>
                                                            <label class="control-label col-lg-3">تعليق :</label>
                                                            <div class="col-lg-8">
                                                                <textarea class="form-control  ckeditor estext w-100" rows="7"
                                                                          id="comment" name="comment"></textarea>
                                                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">
                                                                <input type="hidden" name="callStatus" id="callStatus" value="0">
                                                                <input type="hidden" class="CallID" name="callID" value="0">
                                                                <input type="hidden" class="IsCall" name="IsCall" value="1">
                                                                <input class="btn btn-info btn-md mb-3 w-25 mt-4 float-right"
                                                                       type="submit" value="تم">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end::Item-->
                                </div>

                                <!--end::Section-->
                            </div>
                            <!--طلب الشراء-->

                        </div>

                        <div class="new-case m-portlet__body w-100 " style="display: none;" id="showRenewStatusForm">
                            <form method="post" onSubmit = "return checkForm(event,this)" action="<?php echo $url."users/update_status"?>">
                                <input type="hidden" class="statusid" id="flag_num" name="flag">
                                <input type="hidden" class="CallID" name="CallID" value="0">
                                <input type="hidden" name="call_status_id" value="<?= (isset($clientcallStatus))? $clientcallStatus:"" ?>">
                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>" name="clientid">
                                <div class="border p-5">
                                    <div class="form-group m-form__group row mt-2">
                                        <label class="col-form-label col-lg-2 col-sm-12">تاريخ معاودة الاتصال</label>
                                        <div class="col-lg-9 col-md-4 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text" class="form-control m-input datepickerDetailsPage callDate"
                                                       name="date">
                                                <div class="input-group-append">
														<span class="input-group-text">
															<i class="flaticon-calendar glyphicon-th"></i>
														</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="form-group m-form__group row" >
                                        <label class="col-form-label col-lg-2 col-sm-12">وقت معاودة الاتصال</label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">
                                            <div class="input-group date">
                                                <input type="text" name="time" class="form-control m-input timebakerInput1"
                                                       id="callTime">
                                                <div class="input-group-append">
														<span class="input-group-text">
															<i class="flaticon-time glyphicon-th"></i>
														</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-lg-2 col-sm-12">تعليق</label>
                                        <div class="col-lg-9 col-md-9 col-sm-12">

                                         <textarea type="text" id="comment" name="comment" class="form-control ckeditor" placeholder="أكتب تعليقك"
                                                   rows="10" cols="33"></textarea>

                                        </div>

                                        <div class="pb-1 ml-auto">
                                            <input class="btn btn-info px-5" id="tesclick" style="margin: 20px;" type="submit"  value="تم">
                                        </div>
                                    </div></div>
                            </form>
                        </div>



                        <!-- showContracted-->

                        <div class="row">
                            <div class="col-md-12 border col-sm-12 pt-3 " id="showContracted" style="display:none;margin-top: 10px;">
                                <div class="form-group m-form__group row mx-3">
                                    <label for="example-password-input" class="col-lg-2 col-form-label">
                                        نتيجة التعاقد :
                                    </label>
                                    <div class="col-lg-7 col-sm-12">
                                        <select class="form-control select2-static" id="ContractedStatus">
                                            <option value="0" selected>إختر نتيجة التعاقد</option>
                                            <?php if(isset($ContractedStatus))
                                            {
                                                for($i=0;$i<count($ContractedStatus);$i++)
                                                {
                                                    if($ContractedStatus[$i]->status  == 3)
                                                    {
                                                        $val=0;
                                                    }
                                                    else
                                                    {
                                                        $val=1;
                                                    }
                                                    ?>
                                                    <option statusid="<?php echo $ContractedStatus[$i]->id?>" name="optradioes" value="<?php echo $val?>"><?php echo $ContractedStatus[$i]->title?></option>
                                                <?php } }?>
                                        </select>

                                    </div>
                                </div>
                                <!-- ContractedDiv-->
                                <div class="new-case m-portlet__body w-100 " style="display: none;" id="ContractedDiv">
                                    <form method="post" action="<?php echo $url."ClientOrders/SetPaymentAmount"?>">
                                        <input type="hidden"
                                               class="statusid" id="flag_num" name="flag">
                                        <input type="hidden" class="CallID" name="CallID" value="0">
                                        <input type="hidden" name="Contracted_status_id" id="Contracted_status_id">

                                        <?php
                                        $ContractedAcc = false;

                                        foreach ($Ordersettings as $order){
                                            if  ($Setting->Pro_Name =='Contracted'){
                                                $ContractedAcc = $Setting->Is_Active;
                                            }
                                        }


                                        if ($ContractedAcc){ ?>

                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-2 col-sm-12"> المبلغ المستحق</label>
                                                </label>
                                                <div class="col-lg-7 col-md-4 col-sm-12">
                                                    <input id="tAmount" readonly class="form-control" type="number" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-2 col-sm-12">المبلغ المدفوع:</label>
                                                </label>
                                                <div class="col-lg-7 col-md-4 col-sm-12">
                                                    <input id="pAmount" readonly class="form-control" type="number" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-2 col-sm-12">المبلغ المتبقى:</label>
                                                </label>
                                                <div class="col-lg-7 col-md-4 col-sm-12">
                                                    <input id="rAmount" readonly class="form-control" type="number" min="0" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-2 col-sm-12">المبلغ:</label>
                                                </label>
                                                <div class="col-lg-7 col-md-4 col-sm-12">
                                                    <input required id="Amount" oninput="check(this)" name="Amount" class="form-control" type="number" min="100" value="0">
                                                </div>
                                            </div>
                                        <?php }?>

                                        <div class="form-group m-form__group row">
                                            <label class="col-form-label col-lg-2 col-sm-12">تعليق</label>
                                            <div class="col-lg-7 col-md-9 col-sm-12">
                                                <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>"
                                                       name="clientid">
                                                <textarea type="text" id="comment" name="comment" class="form-control ckeditor" placeholder="أكتب تعليقك"
                                                          rows="10" cols="33"></textarea>

                                            </div>
                                        </div>
                                        <input class="btn btn-info px-5 btn-md float-right mb-2" id="tesclick"  type="submit"  value="تم">

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 border col-sm-12 pt-3" id="showDeContracted" style="display: none">
                                <div class="col-sm-8"  style=margin-top:20px;>
                                    <div class="col-sm-12">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class=row>
                                                    <label for="example-password-input" class="col-lg-2 col-form-label">
                                                        سبب إلغاء التعاقد :
                                                    </label>
                                                    <div class="col-lg-7 col-sm-12">
                                                        <select class="form-control select2-static" id="DeContractedStatus">
                                                            <option value="0" selected>إختر سبب إلغاء التعاقد</option>

                                                            <?php if(isset($DeContractedStatus))
                                                            {
                                                                for($i=0;$i<count($DeContractedStatus);$i++)
                                                                {
                                                                    if($DeContractedStatus[$i]->status  == 3)
                                                                    {
                                                                        $val=0;
                                                                    }
                                                                    else
                                                                    {
                                                                        $val=1;
                                                                    }
                                                                    ?>
                                                                    <option statusid="<?php echo $DeContractedStatus[$i]->id?>" name="optradioes" value="<?php echo $DeContractedStatus[$i]->id?>"><?php echo $DeContractedStatus[$i]->title?></option>
                                                                <?php } }?>
                                                        </select>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 load-res "  id="DeContractedDiv" style="margin-top:20px;display: none">
                                    <form method="post"  action="<?php echo $url."Client/DeContracted"?>">
                                        <input type="hidden" class="CallID" name="CallID" value="0">
                                        <div class="form-body">
                                            <input type="hidden" name="call_status_id" class="call_status_id_hidden">
                                            <div class="form-group">
                                                <div class=row>
                                                    <label class="control-label col-lg-1">تعليق :</label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control ckeditor estext" rows="5" id="comment" name="comment"></textarea>
                                                        <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>"
                                                               name="clientid">
                                                        <input class="btn btn-info my-5 w-25" style="margin: 20px;" type="submit"  value="تم">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="col-sm-6 load-res " id="ContractedDiv" style="margin-top:20px;display: none">
                                    <form method="post" action="<?php echo $url."ClientOrders/SetPaymentAmount"?>">
                                        <input type="hidden"
                                               class="statusid" id="flag_num" name="flag">
                                        <input type="hidden" class="CallID" name="CallID" value="0">
                                        <div class="form-body">
                                            <input type="hidden" name="Contracted_status_id" id="Contracted_status_id">
                                            <div class="form-group">

                                                <?php
                                                $ContractedAcc = false;

                                                foreach ($Ordersettings as $order){
                                                    if  ($Setting->Pro_Name =='Contracted'){
                                                        $ContractedAcc = $Setting->Is_Active;
                                                    }
                                                }


                                                if ($ContractedAcc){
                                                    ?>


                                                    <div class="row" style="margin-bottom: 10px">
                                                        <label class="control-label col-sm-6">المبلغ المستحق:</label>
                                                        <input id="tAmount" readonly class="form-control col-sm-6" type="number" min="0" value="0">
                                                    </div>
                                                    <div class="row"  style="margin-bottom: 10px">
                                                        <label class="control-label col-sm-6">المبلغ المدفوع:</label>
                                                        <input id="pAmount" readonly class="form-control col-sm-6" type="number" min="0" value="0">
                                                    </div>
                                                    <div class="row"  style="margin-bottom: 10px">
                                                        <label class="control-label col-sm-6">المبلغ المتبقى:</label>
                                                        <input id="rAmount" readonly class="form-control col-sm-6" type="number" min="0" value="0">
                                                    </div>
                                                    <div class="row"  style="margin-bottom: 10px">
                                                        <label class="control-label col-sm-6">المبلغ:</label>
                                                        <input required id="Amount" oninput="check(this)" name="Amount" class="form-control col-sm-6" type="number" min="100" value="0">
                                                    </div>

                                                <?php }?>

                                                <div class=row>
                                                    <label class="control-label col-sm-3">تعليق:</label>
                                                    <div class="col-sm-7">
                                                        <textarea class="form-control ckeditor estext" rows="5" id="comment" name="comment"></textarea>
                                                        <input type="hidden" value="<?php echo $customer[0]->customerCrmId?>"
                                                               name="clientid">
                                                        <input class="btn btn-blue btn-lg btn-block" style="margin: 20px;" type="submit" value="تم">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--buttons top-->
                    <!--شكوى / بريد /رساله نصيه-->
                    <div class="tab-pane sent-email" id="m_tabs_6_3" role="tabpanel">

                        <div class="container">
                            <!--ارسال ايميل-->
                            <div class="m-portlet m-portlet--tab">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="m-portlet__head-text">
                                                ارسال رساله الالكترونيه
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <!--begin::Form-->
                                <form method="post" action="<?= base_url().'CRM_Mails/sendMailWithAttach'?>" enctype="multipart/form-data">
                                    <div class="m-portlet__body">
                                        <div class="container">
                                            <div class="form-group">
                                                <input type="hidden" name="CustomerID" value="<?=$customer[0]->customerCrmId ?>">
                                                <label class="control-label col-lg-2" for="email">الإيميل:</label>
                                                <div class="col-lg-9">
                                                    <input type="email" class="form-control" id="mailaddress" name="To" placeholder="ادخل الإيميل"
                                                           value="<?php echo $customer[0]->customerCrmEmail;?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-2" for="email">العنوان:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="title" id="Mailsubject" placeholder="ادخل عنوان الرسالة">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-2" for="mess"> رسالة:</label>
                                                <div class="col-lg-9">
                                                    <textarea type="text" id="Mailcontent" name="Mailcontent" class="form-control ckeditor" placeholder="ادخل رسالتك" rows="10" cols="33"></textarea>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                إرفاق الملف : <input type="file" id="file[]" accept="application/pdf,image/*" name="file[]" multiple>
                                            </div>
                                            <div class="form-group mt-4">
                                                <div class="col-lg-2">
                                                    <button type="submit" class="btn btn-info btn-md btn-block mr-auto" id="sendMail">إرسال</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--end::Form-->
                            </div>
                            <!--ارسال ايميل-->

                            <!--ارسال رساله نصيه-->
                            <div class="m-portlet m-portlet--tab sent-message">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="m-portlet__head-text">
                                                ارسال رساله نصيه
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <!--begin::Form-->
                                <form class="m-form m-form--fit m-form--label-align-right">
                                    <div class="m-portlet__body">
                                        <div class="container">
                                            <div class="form-group">
                                                <div class="col-lg-8">
                                                    <label for="field-1" class="control-label">نص الرسالة</label>
                                                    <textarea rows="10" id="smsContent" class="etextar2 form-control " placeholder="نص الرسالة"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-2 col-sm-offset-4">
                                                    <button id="sendsms" type="button" class="btn btn-info btn-md btn-block">ارسال</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--ارسال رساله نصيه-->
                            <!--ارسال  شكوى-->
                            <div class="m-portlet m-portlet--tab sent-notes">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                            <h3 class="m-portlet__head-text">
                                                ارسال شكوى / ملاحظات
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form-->
                                <form class="m-form m-form--fit m-form--label-align-right">
                                    <div class="m-portlet__body">
                                        <div class="container">
                                            <?php
                                            if ($_SESSION['usertype'] == 3){?>
                                                <label class="control-label col-lg-4">
                                                    الى المدير:
                                                    <input type="checkbox" name="ToAdmin" checked disabled>
                                                </label>

                                                <label class="control-label col-lg-4">
                                                    الى المشرف:
                                                    <input type="checkbox" name="ToSuper" id="To-super">
                                                </label>
                                                <br>
                                                <br>
                                            <?php }
                                            ?>

                                            <div class="form-group row all-labels ml-4">
                                                <div class="col-lg-4 d-flex">
                                                    <label class="control-label text-center">النوع</label>


                                                    <label>
                                                        <input type="radio" name="note-type" value="0" checked> شكوي
                                                    </label>
                                                </div>
                                                <div class="col-lg-4 d-flex">
                                                    <label>
                                                        <input type="radio" name="note-type" value="1"> ملاحظات</label>

                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-8">
                                                    <label for="sel4" class=" control-label col-lg-3">العنوان</label>

                                                    <input type="text" id="subject" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="field-1" class="control-label col-lg-3">المحتوي</label>
                                                <div class="col-lg-8">
                                        <textarea rows="10" class=".etextar2 form-control complaincontent " name="complaincontent" id="field-1"
                                                  placeholder="الشكوى"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-2 col-sm-offset-4">
                                                    <input type="button" class="sendcomplain btn btn-info btn-md btn-block"
                                                           value="ارسال">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--ارسال  شكوى-->
                        </div>
                    </div>
                    <!--شكوى / بريد /رساله نصيه-->
                    <div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
                        <div id="other">
                            <?php
                            if ($_SESSION["usertype"] !=3){
                                ?>
                                <div class="container">
                                    <div class="m-portlet m-portlet--tab sent-notes">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption">
                                                <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon m--hide">
                                                <i class="la la-gear"></i>
                                            </span>
                                                    <h3 class="m-portlet__head-text">
                                                        تحويل الى
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Form-->
                                        <div class="m-portlet__body">
                                            <div class="container">
                                                <div class="form-row">
                                                    <div class="col-lg-2">
                                                        <div class="form-group col-sm-offset-5">
                                                            <input type="checkbox" id="asNewClient" style="margin-left: 10px"><label>كحالة جديدة</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <select name="mto" id="select-employee" class="form-control" required>
                                                            <?php if(isset($users)) { for($i=0;$i<count($users);$i++){
                                                                $roll = '';
                                                                if($users[$i]->Type==2){
                                                                    $roll='مشرف';
                                                                }else if ($users[$i]->Type==3){
                                                                    $roll='موظف';
                                                                }
                                                                ?>
                                                                <option value="<?php echo $users[$i]->ID?>">
                                                                    <?php echo $users[$i]->Name.' ('.$roll.')'?>
                                                                </option>
                                                            <?php } }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                            <div class="m-form__actions">
                                                <button type="submit" id="reassign" class="btn btn-info btn-md mt-2 float-right esbutton " style="alignment: center">تحويل</button>
                                                <?php
                                                if ($_SESSION["usertype"] == 2){ ?>
                                                    <INPUT type="button" value="تحويل لمهامى" class="btn btn-info btn-md mr-3 mt-2" id="reAssignToMe" style="    margin-right: 17px;" />
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                        <!--end::Form-->
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
    </div>
</div>






<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>



<!--<script src="assets/js/ckeditor.js"></script>-->

<!---->
<script src="vendors/ckeditor/ckeditor.js" type="text/javascript"></script>

<script>

    $("#callStatusChange").change(function () {
        var statusValue = $(this).val();

        $("#ContractedDiv").hide();
        $("#showContracted").hide();
        $("#showRenewStatusForm").hide();
        $("#renewStatusDiv").hide();
        $("#noanswer").hide();
        $("#wrongDiv").hide();
        $("#add-order").hide();
        $("#reserve").hide();
        if (statusValue == 1){
            // Answer
            $("#ans").show();
            $("#not-ans").hide();
            $("#wrong").hide();
            $("#ansSelect").prop('selectedIndex', 0);
            $("#ContractedDiv").hide();



        }else if (statusValue == 2) {
            // Not Answer
            $("#ans").hide();
            $("#not-ans").show();
            $("#wrong").hide();
            $("#noansSelect").prop('selectedIndex', 0);
            $("#ContractedDiv").hide();
        }else if (statusValue == 3) {
            // wrong
            $("#ans").hide();
            $("#not-ans").hide();
            $("#wrong").show();
            $("#wrongSelect").prop('selectedIndex', 0);
            $("#ContractedDiv").hide();
        }else {
            $("#ans").hide();
            $("#not-ans").hide();
            $("#wrong").hide();
            $("#ContractedDiv").hide();

        }
    });


    $("#ansSelect").change(function () {
        var statusValue = $(this).val();
        if (statusValue==3){
            // قيد لحجز
            $("#reserve").show();
            $("#ContractedDiv").hide();
            $("#showContracted").hide();
            $("#showRenewStatusForm").hide();
            $("#renewStatusDiv").hide();
            $("#noanswer").hide();
            $("#wrongDiv").hide();
            $("#add-order").hide();


        }else if (statusValue!=3 && statusValue!=0){
            var statusValue = $(this).val();
            if (statusValue > 0){
                var option = $('option:selected', this).attr('statusid');
                $("#reserve").hide();
                $("#ContractedDiv").hide();
                $("#showContracted").hide();
                $("#showRenewStatusForm").hide();
                $("#renewStatusDiv").hide();
                $("#noanswer").hide();
                $("#wrongDiv").hide();
                $("#add-order").hide();
                $(".call_status_id_hidden").val(option);
                $("#noanswer").show();
                $("#wrongDiv").hide();
            }
        }
    });

    $("#ContractedStatus").change(function () {
        var statusValue = $(this).val();
        if (statusValue >0){
            var statusid = $('option:selected', this).attr('statusid');
            $("#Contracted_status_id").val(statusid);
            //Get Client payment values
            var clientid = $(".custid").val();
            $.ajax({
                type: "POST",
                url: base + "ClientOrders/GetPaymentData",
                data: ({
                    clientid: clientid

                }),
                success: function (data) {
                    var result =  jQuery.parseJSON(data);
                    $("#tAmount").val(parseInt(result[0].Amount,0));
                    $("#pAmount").val(parseInt(result[0].paid,0));
                    $("#rAmount").val(parseInt(result[0].Amount,0) - parseInt(result[0].paid,0));
                    $("#Amount").attr('max',parseInt(result[0].Amount,0) - parseInt(result[0].paid,0));

                    $("#ContractedDiv").show();
                    $("#ans").hide();
                    $("#not-ans").hide();
                    $("#wrong").hide();

                }
            });
        }else{
            $("#ContractedDiv").hide();
        }




    });
    $("#DeContractedStatus").change(function () {
        document.getElementById('DeContractedDiv').style.display = 'block';




        var statusid = $(this).val();
        $(".call_status_id_hidden").val(statusid);
        // alert(statusid);


    });


    $("#reserveSelect").change(function () {
        var statusValue = $(this).val();
        var option = $('option:selected', this).attr('statusid');
        $("#callStatus").val(option);
        //alert(option);
        $("#add-order").show();
    });


    $("#noansSelect").change(function () {
        var statusValue = $(this).val();
        if (statusValue > 0){
            var option = $('option:selected', this).attr('statusid');
            $(".call_status_id_hidden").val(option);
            $("#noanswer").show();
            $("#wrongDiv").hide();
        }
    });
    $("#wrongSelect").change(function () {
        var statusValue = $(this).val();
        if (statusValue > 0){
            var option = $('option:selected', this).attr('statusid');
            $(".call_status_id_hidden").val(option);
            $("#wrongDiv").show();
            $("#noanswer").hide();

        }
    });

    $("#ContractedStatus").change(function () {
        var statusValue = $(this).val();
        if (statusValue >0){
            var statusid = $('option:selected', this).attr('statusid');
            $("#Contracted_status_id").val(statusid);
            //Get Client payment values
            var clientid = $(".custid").val();
            $.ajax({
                type: "POST",
                url: base + "ClientOrders/GetPaymentData",
                data: ({
                    clientid: clientid

                }),
                success: function (data) {
                    var result =  jQuery.parseJSON(data);
                    $("#tAmount").val(parseInt(result[0].Amount,0));
                    $("#pAmount").val(parseInt(result[0].paid,0));
                    $("#rAmount").val(parseInt(result[0].Amount,0) - parseInt(result[0].paid,0));
                    $("#Amount").attr('max',parseInt(result[0].Amount,0) - parseInt(result[0].paid,0));

                    $("#ContractedDiv").show();
                    $("#ans").hide();
                    $("#not-ans").hide();
                    $("#wrong").hide();

                }
            });
        }else{
            $("#ContractedDiv").hide();
        }




    });








    var changetype = function (type) {
        document.getElementById("selectServiceandProudct").innerHTML = "";
        document.getElementById("selectServiceandProudct").textContent = "";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("selectServiceandProudct").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type=" + type, true);
        xhttp.send();
    }

    var Neworderchangetype = function (type) {

        document.getElementById("newOrderselectServiceandProudct").innerHTML = "";
        document.getElementById("newOrderselectServiceandProudct").textContent = "";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                document.getElementById("newOrderselectServiceandProudct").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type=" + type, true);
        xhttp.send();
    }

    $('#showDialog').click(function () {
        $('#new-order').show();
        $("#m_accordion_2_item_1_head").removeClass("collapsed");
        $("#m_accordion_2_item_1_body").addClass("show");
    });
    var Gettype = function (type) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("OrderContent").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/get_proudct_service?type=" + type, true);
        xhttp.send();
    };




    $('.delete-elemnet').click(function () {

        var result = confirm("هل تريد المسح");
        if (result) {
            var id = $(this).attr('orderid');
            var parent = $(this).parent();
            $(parent).parent().remove();
            $.ajax({
                type: "POST",
                url: base + "Client/deleteOrder",
                data: ({
                    OrderID: id
                }),
                success: function (data) {
                    if (data == 1) {
                        $(parent).parent().remove();
                        alert("تم الحذف  بنجاح");
                    } else {
                        alert("حدث خطأ اثناء الحذف");
                    }
                }
            });
        }
    });


    $(".update-elemnet").click(function () {
        $(this).hide();
        var parent = $(this).parent();
        var parenttr = $(parent).siblings(".quantity");
        $(parenttr).children(".save-elemnet").show();
        $(parenttr).children(".edit-show").hide();
        $(this).siblings(".save-elemnet").show();
        $(parenttr).children(".orders-quantity").show();
        $(parenttr).children(".orders-quantity").focus();
    });

    $(".save-elemnet").click(function () {
        $(this).hide();
        var parent = $(this).parent();
        var parenttr = $(parent).siblings(".quantity");
        var id = $(this).attr("orderid");
        var quantity = $(parenttr).children(".orders-quantity").val();
        var element = $(this);

        $.ajax({
            type: "POST",
            url: base + "Client/updateOrder",
            data: ({
                OrderID: id,
                newquantity: quantity
            }),
            success: function (data) {
                if (data == 1) {

                    $(element).hide();
                    $(parenttr).children(".edit-show").text(quantity);
                    $(parenttr).children(".edit-show").show();
                    $(element).siblings(".update-elemnet").show();
                    $(parenttr).children(".orders-quantity").hide();
                    alert("تم التعديل  بنجاح");
                } else {
                    alert("حدث خطأ اثناء التعديل");
                }
            }
        });
    });

    $(".orders-quantity").bind("keypress", {}, function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {

            var parent = $(this).parent();
            var parenttr = $(parent).siblings(".op");
            var id = $(parenttr).children(".save-elemnet").attr("orderid");
            var quantity = $(this).val();
            var element = $(this);


            $.ajax({
                type: "POST",
                url: base + "Client/updateOrder",
                data: ({
                    OrderID: id,
                    newquantity: quantity
                }),
                success: function (data) {
                    if (data == 1) {
                        $(element).hide();
                        $(element).siblings(".edit-show").text(quantity);
                        $(element).siblings(".edit-show").show();
                        $(parenttr).children(".update-elemnet").show();
                        $(parenttr).children(".save-elemnet").hide();
                        alert("تم التعديل  بنجاح");

                    } else {
                        alert("حدث خطأ اثناء التعديل");
                    }


                }
            });
        }
    });

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

    var url = $("#base").val();

    function customer_details() {
        var clientid = $(".custid").val();

        window.location = url + "users/customer_details/" + clientid;
    }

    var editor ;
    var complaincontent ;
    $(document).ready(function () {
        editor = CKEDITOR.replace( 'editor1' );
        complaincontent = CKEDITOR.replace( 'complaincontent' );
    });

    $(".sendmess").click(function () {

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




    var ToSuper = 0;
    $('#To-super').change(function () {
        if ($(this).is(":checked")) {
            ToSuper = 1;
        } else {
            ToSuper = 0;
        }

    });


    $(".sendcomplain").click(function () {

        var base = $("#base").val();
        var clientid = $(".custid").val();
        var subject = document.getElementById("subject").value;
        var content = complaincontent.getData();
        var type = $("input[name='note-type']:checked").val();


        if ( content != "") {
            $.ajax({
                type: "POST",
                url: base + "CRM_Complain/ClientComplain",
                data: ({
                    clientid: clientid,
                    subject: subject,
                    content: content,
                    complain: type,
                    toSuepr: ToSuper
                }),
                success: function (data) {
                    if (data == 1) {
                        if (type == 0)
                            alert("تم  ارسال الشكوي بنجاح");
                        else
                            alert("تم  ارسال الملاحظة بنجاح");
                        window.location.reload();
                    } else {
                        if (type == 0)
                            alert("لم يتم ارسال الشكوي بنجاح");
                        else
                            alert("لم تم ارسال الملاحظة بنجاح");
                    }

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
        // var Comment = $("#new-comment").val();


        var Comment = editor.getData();
        var clientid = $(".custid").val();
        // $(Container).append("<p>test</p>");
        // alert(data);
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
        $(".call_status_id_hidden").val(statusid);
        $("#callStatus").val(statusid);

    });
    $(".status2").click(function () {

        var statusid = $(this).attr("statusid");
        $("#Contracted_status_id").val(statusid);
        //Get Client payment values
        var clientid = $(".custid").val();
        $.ajax({
            type: "POST",
            url: base + "ClientOrders/GetPaymentData",
            data: ({
                clientid: clientid

            }),
            success: function (data) {
                var result = jQuery.parseJSON(data);
                $("#tAmount").val(parseInt(result[0].Amount, 0));
                $("#pAmount").val(parseInt(result[0].paid, 0));
                $("#rAmount").val(parseInt(result[0].Amount, 0) - parseInt(result[0].paid, 0));
                $("#Amount").attr('max', parseInt(result[0].Amount, 0) - parseInt(result[0].paid,
                    0));

            }
        });

    });

    $(".status3").click(function () {
        document.getElementById('DeContractedDiv').style.display = 'block';
        var statusid = $(this).attr("statusid");
        $(".call_status_id_hidden").val(statusid);


    });


    $("#reAssignToMe").click(function () {
        var base = $("#base").val();
        var employee = "<?php echo $_SESSION["userid"] ?>";
        var clientid = $(".custid").val();
        var asNewData = 0;
        if ($("#asNewClient").is(":checked")) {
            asNewData = 1;
        } else {
            asNewData = 0;
        }
        $.ajax({
            type: "POST",
            url: base + "users/ReAssign",
            data: ({
                clientid: clientid,
                EmpID: employee,
                status: asNewData

            }),
            success: function (data) {
                if (data == 0) {
                    alert("حدث خطأ");
                } else {
                    alert("تم تحويل العميل بنجاح");
                    location.reload();
                }


            }
        });
    });


    $("#reassign").click(function () {

        var base = $("#base").val();
        var employee = document.getElementById("select-employee").options[document.getElementById(
            "select-employee").selectedIndex].value;
        var clientid = $(".custid").val();
        var asNewData = 0;
        if ($("#asNewClient").is(":checked")) {
            asNewData = 1;
        } else {
            asNewData = 0;
        }
        $.ajax({
            type: "POST",
            url: base + "users/ReAssign",
            data: ({
                clientid: clientid,
                EmpID: employee,
                status: asNewData

            }),
            success: function (data) {
                if (data == 0) {
                    alert("حدث خطأ");
                } else {
                    alert("تم تحويل العميل بنجاح");
                    //location.reload();
                }


            }
        });


    });


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
                if ($(this).val() == 0) {
                    $(".prod-table").attr("hidden", false);
                } else {
                    $(".prod-table").attr("hidden", true);
                }
            }
        });



        $(".status2").change(function () {
            if ($(this).is(':checked')) {

                $("#" + $(this).val()).attr("hidden", false);
            }
        });

        $("#sendsms").click(function () {
            var element = this;
            $(element).enable(false);
            var ID = $("#custid").val();
            var msg = $("#smsContent").val();

            $.ajax({
                type: "POST",
                url: base + "Client/SendSMS",
                data: ({
                    clientID: ID,
                    message: msg
                }),
                success: function (data) {
                    var result = jQuery.parseJSON(data);
                    if (result.errorCode == 0) {
                        alert("تم إرسال الرسالة بنجاح");
                        document.location.reload();
                    } else
                        alert(result.message);

                }
            });
            $(element).enable(true);
        });


        $('input[name="optradioes12"]').click(function () {
            if ($(this).is(':checked')) {
                $("#" + $(this).val()).attr("hidden", false);
                $(".prod-table").attr("hidden", false);
            }
        });


    });



    $(".deleteCustomerOrder").click(function () {

        var result = confirm("هل تريد المسح");
        if (result) {
            var base = $("#base").val();
            var id = $(this).attr("orderID");
            $.ajax({
                type: "POST",
                url: base + "ClientOrders/DeleteOrder",
                data: ({
                    ID: id
                }),
                success: function (data) {
                    if (data == 1) {
                        alert("تم الحذف بنجاح");
                        document.location.reload();
                    } else
                        alert("حدث خطأ اثناء الحذف");
                }
            });
        }
    });
    function check(input) {
        if (input.value == 0) {
            input.setCustomValidity('The number must not be zero.');
        } else {
            // input is fine -- reset the error message
            input.setCustomValidity('');
        }
    }
    $('#input').datetimepicker({
        footer: true,
        modal: true
    });
    $('#time').datetimepicker({
        footer: true,
        modal: true
    });
    $('#time2').datetimepicker({
        footer: true,
        modal: true
    });

    var client_id = document.getElementById('custmer_id').value;
    var totalSeconds = 0;
    var interval;
    var status = <?php echo $callStatus ?>;

    var startcall = function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if  (status ==2 || status == 0 || status ==6){
                    document.getElementById('DivCallStatus').style.display = 'block';
                }else{
                    document.getElementById('divchangestatus').style.display = 'block';
                }


                document.getElementById('buttonCallEnded').removeAttribute("disabled");
                $(".CallID").val(xhttp.response);
                $(".IsCall").val(1);
            }
        };
        xhttp.open("GET", "<?php echo base_url() ?>Client/start_call?client_id=" + client_id, true);
        xhttp.send();
        interval = setInterval(setTime, 1000);
    };
    var endcall = function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                clearInterval(interval);
                window.location.href = "<?php echo isset($_SESSION['date1']) ? base_url().'/Client/Distributors/'.$_SESSION['date1'].'@'.$_SESSION['date2'] : base_url().'/Client/Distributors/'?>";
            }
        };
        var callID =  $(".CallID").val();
        xhttp.open("GET", "<?php echo base_url() ?>Client/end_call?CallID=" + callID , true);
        xhttp.send();

        // interval=setInterval(setTime, 1000);
    };

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



    $("#buttonCallStart").click(function(){
        $(this).css("display","none");
        $("#buttonCallEnded").css("display", "block");
    });

    var showStatus = function () {
        document.getElementById('DivCallStatus').style.display = 'block';
        document.getElementById('showRenewStatusForm').style.display = 'none';
        document.getElementById('showContracted').style.display = 'none';
        $("#ContractedDiv").hide();
        //ContractedStatus
        $("#ContractedStatus").prop('selectedIndex', 0);
        document.getElementById('showDeContracted').style.display = 'none';
        //document.getElementById('showDeContracted').style.display = 'none';
    };
    var renewStatus = function () {
        document.getElementById('DivCallStatus').style.display = 'none';
        document.getElementById('showRenewStatusForm').style.display = 'block';
        document.getElementById('showContracted').style.display = 'none';
        $("#ContractedDiv").hide();
        $("#noanswer").hide();
        $("#ContractedStatus").prop('selectedIndex', 0);
        document.getElementById('showDeContracted').style.display = 'none';
        // document.getElementById('showDeContracted').style.display = 'none';
    };
    var showContracted = function () {
        document.getElementById('DivCallStatus').style.display = 'none';
        document.getElementById('showRenewStatusForm').style.display = 'none';
        document.getElementById('showContracted').style.display = 'block';
        $("#ContractedStatus").prop('selectedIndex', 0);
        $("#noanswer").hide();
        document.getElementById('showDeContracted').style.display = 'none';
        //  document.getElementById('showDeContracted').style.display = 'none';
    };
    var showDeContracted = function () {
        document.getElementById('DivCallStatus').style.display = 'none';
        document.getElementById('showRenewStatusForm').style.display = 'none';
        document.getElementById('showContracted').style.display = 'none';
        $("#noanswer").hide();
        document.getElementById('showDeContracted').style.display = 'block';

    };






    $("table[id^='example']").DataTable({
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "ابحث:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            }
        }
    });
    let neworderTable = $("#updateOrderItems").DataTable({
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "ابحث:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            }
        }
    });
    let OrderItems = $("#OrderItems").DataTable({
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "ابحث:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            }
        }

    });

    $("#newAddOrder").click(function () {

        $("#addOrder").addClass("show");
        var name = $("#newOrderselectServiceandProudct option:selected").text();
        var quantity = $("#newquantity").val();
        var transferType = $("#newtransferType option:selected").text();
        var paymentType = $("#newpaymentType option:selected").text();
        var oldtransferCost = parseInt($("#newTransferCost").text(), 0);
        var oldproductCost = parseInt($("#newproductCost").text(), 0);
        var olddiscount = parseInt($("#newDiscountValue").text(), 0);
        var transferCost = $("#newtransferType option:selected").attr("cost");
        var productCost = $("#newOrderselectServiceandProudct option:selected").attr("cost");
        var transfer = $("#newtransferType option:selected").val();
        var payment = $("#newpaymentType option:selected").val();
        var nameIndex = $("#newOrderselectServiceandProudct option:selected").val();

        var truckCost = parseInt($("#newtruckCost").val(), 0);
        var tcost = 0;
        if (truckCost == 0) {
            tcost = transferCost * 1;
        } else {
            tcost = truckCost;
        }

        var pcost = productCost * quantity;
        var newProductCost = oldproductCost + pcost;
        var newtransferCost = oldtransferCost + tcost;
        var discount = 0;
        var discountValue = parseInt($("#newdiscount").val(), 0);
        var discountType = $("#newdiscountType option:selected").val();
        if (discountValue > 0) {
            if (discountType == 0) {
                discount = (discountValue / 100) * pcost;
            } else {
                discount = discountValue;
            }

        }
        if (quantity <= 0) {
            alert("الكمية لا يمكن ان تكون " + quantity);
        } else {
            $("#newproductCost").html(newProductCost);
            $("#newTransferCost").html(newtransferCost);
            $("#newTotal").html((newProductCost - (discount + olddiscount)) + newtransferCost);
            $("#newDiscountValue").html(discount + olddiscount);

            $("#newproductCost_hidden").val(newProductCost);
            $("#newTransferCost_hidden").val(newtransferCost);
            $("#newTotal_hidden").val((newProductCost - (discount + olddiscount)) + newtransferCost);
            $("#newDiscountValue_hidden").val(discount + olddiscount);
            var row = new Array(
                "<input type='text' name='names[]' hidden value= '" + nameIndex + "'><label>" + name
                    .trim() + "</label> ",
                "<input type='text' name='quantity[]' hidden value= '" + quantity.trim() + "'><label>" +
                quantity.trim() + "</label>",
                "<input type='text' name='transferType[]' hidden value= '" + transfer + "'><label>" +
                transferType.trim() + "</label>",
                "<input type='text' name='paymentType[]' hidden value= '" + payment + "'><label>" +
                paymentType.trim() + "</label>",
                "<button type='button' class='btn btn-danger btn-sm' style='font-weight: bold' discount = '" + discount +
                "' TransferCost = '" + tcost + "' productCost = '" + pcost + "' >حذف</button>"
            );
            neworderTable.row.add(row).draw(false);
        }
    });


    $("#AddOrder").click(function () {

        var name = $("#selectServiceandProudct option:selected").text();
        var quantity = $("#quantity").val();
        var transferType = $("#transferType option:selected").text();
        var paymentType = $("#paymentType option:selected").text();
        var oldtransferCost = parseInt($("#TransferCost").text(), 0);
        var oldproductCost = parseInt($("#productCost").text(), 0);
        var olddiscount = parseInt($("#DiscountValue").text(), 0);
        var transferCost = $("#transferType option:selected").attr("cost");
        var productCost = $("#selectServiceandProudct option:selected").attr("cost");
        var transfer = $("#transferType option:selected").val();
        var payment = $("#paymentType option:selected").val();
        var nameIndex = $("#selectServiceandProudct option:selected").val();

        var truckCost = parseInt($("#truckCost").val(), 0);
        var tcost = 0;
        if (truckCost == 0) {
            tcost = transferCost * 1;
        } else {
            tcost = truckCost;
        }
        var pcost = productCost * quantity;
        var newProductCost = oldproductCost + pcost;
        var newtransferCost = oldtransferCost + tcost;
        var discount = 0;
        var discountValue = parseInt($("#discount").val(), 0);
        var discountType = $("#discountType option:selected").val();
        if (discountValue > 0) {
            if (discountType == 0) {
                discount = (discountValue / 100) * pcost;
            } else {
                discount = discountValue;
            }

        }
        if (quantity <= 0) {
            alert("الكمية لا يمكن ان تكون " + quantity);
        } else {
            $("#productCost").html(newProductCost);
            $("#TransferCost").html(newtransferCost);
            $("#Total").html((newProductCost - (discount + olddiscount)) + newtransferCost);
            $("#DiscountValue").html(discount + olddiscount);

            $("#productCost_hidden").val(newProductCost);
            $("#TransferCost_hidden").val(newtransferCost);
            $("#Total_hidden").val((newProductCost - (discount + olddiscount)) + newtransferCost);
            $("#DiscountValue_hidden").val(discount + olddiscount);
            var row = new Array(
                "<input type='text' name='names[]' hidden value= '" + nameIndex + "'><label>" + name
                    .trim() + "</label> ",
                "<input type='text' name='quantity[]' hidden value= '" + quantity.trim() + "'><label>" +
                quantity.trim() + "</label>",
                "<input type='text' name='transferType[]' hidden value= '" + transfer + "'><label>" +
                transferType.trim() + "</label>",
                "<input type='text' name='paymentType[]' hidden value= '" + payment + "'><label>" +
                paymentType.trim() + "</label>",
                "<button type='button' class='btn btn-danger btn-sm' style='font-weight: bold' discount = '" + discount +
                "' TransferCost = '" + tcost + "' productCost = '" + pcost + "'>حذف</button>"
            );
            OrderItems.row.add(row).draw(false);
        }
    });



    $('#updateOrderItems tbody').on( 'click', 'button', function () {
       // debugger;
        var result = confirm("هل انت متاكد ؟");
        if (result) {
            var row = neworderTable.row($(this).parents('tr'));
            row.remove();
            neworderTable.draw();
            // Get Old Values
            var productCost =  parseInt($("#newproductCost").text(),0);
            var TransferCost = parseInt($("#newTransferCost").text(),0);
            var DiscountValue  = parseInt($("#newDiscountValue").text(),0);
            // Set New Valuse
            productCost = productCost - parseInt($(this).attr('productCost'),0)
            TransferCost = TransferCost - parseInt($(this).attr('TransferCost'),0)
            DiscountValue = DiscountValue - parseInt($(this).attr('discount'),0)
            var total = productCost + TransferCost - DiscountValue;

            $("#newproductCost_hidden").val(productCost);
            $("#newTransferCost_hidden").val(TransferCost);
            $("#newTotal_hidden").val(total);
            $("#newDiscountValue_hidden").val(DiscountValue);


            $("#newproductCost").html(productCost);
            $("#newTransferCost").html(TransferCost);
            $("#newTotal").html(total);
            $("#newDiscountValue").html(DiscountValue);
        }
    } );


    $('#OrderItems tbody').on( 'click', 'button', function () {
        //debugger;
        var result = confirm("هل انت متاكد ؟");
        if (result) {
            var row = OrderItems.row($(this).parents('tr'));
            row.remove();
            OrderItems.draw();
            // Get Old Values
            var productCost =  parseInt($("#productCost").text(),0);
            var TransferCost = parseInt($("#TransferCost").text(),0);
            var DiscountValue  = parseInt($("#DiscountValue").text(),0);
            // Set New Valuse
            productCost = productCost - parseInt($(this).attr('productCost'),0);
            TransferCost = TransferCost - parseInt($(this).attr('TransferCost'),0);
            DiscountValue = DiscountValue - parseInt($(this).attr('discount'),0);
            var total = productCost + TransferCost - DiscountValue;
            $("#productCost_hidden").val(productCost);
            $("#TransferCost_hidden").val(TransferCost);
            $("#Total_hidden").val(total);
            $("#DiscountValue_hidden").val(DiscountValue);

            $("#productCost").html(productCost);
            $("#TransferCost").html(TransferCost);
            $("#Total").html(total);
            $("#DiscountValue").html(DiscountValue);
        }
    } );
</script>
</body>

</html>