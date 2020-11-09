<?php $this->load->view("header");?>



<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%;margin-left: 2%">
    <div class="m-content">

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__body tabs_border">
                            <ul class="nav nav-tabs"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                                       role="tab">تغير المحتوي</a>
                                </li>

                                <li class="nav-item m-tabs__item ">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4"
                                       role="tab">المكالمات</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table m-table m-table--head-bg-info" id="example">
                                                    <thead>
                                                    <tr>
                                                        <th>المحتوي</th>
                                                        <th class="text-center">العمليات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if(isset($changes)){ for($i=0;$i<count($changes);$i++){?>
                                                        <tr>
                                                            <td class="text">
                                                                <span text="<?php echo $changes[$i]->Content?>">
                                                                    <?php echo $changes[$i]->Content?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a id="td-id" changetype="<?php echo $changes[$i]->type?>" changeid="<?php echo $changes[$i]->changecrmID?>"
                                                                   class="mr-1" style="text-center"><span class="text">تعديل</span>
                                                                    <i class="fa fa-edit text-info activeuser "></i> </a>
                                                            </td>
                                                        </tr>
                                                    <?php } } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>



                                </div>

                                <div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
                                    <div class="m-accordion m-accordion--bordered" id="m_accordion_2"
                                         role="tablist">

                                        <!--begin::Item-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_1_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_1_body" aria-expanded="false">
                                                    <span class="m-accordion__item-icon"><i
                                                                class="fa fa-phone-slash text-danger"></i></span>
                                                <span class="m-accordion__item-title">لم يتم الرد
                                                    </span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse"
                                                 id="m_accordion_2_item_1_body" role="tabpanel"
                                                 aria-labelledby="m_accordion_2_item_1_head"
                                                 data-parent="#m_accordion_2" style="">
                                                <div class="m-accordion__item-content">
                                                    <ul class="list-item" data-item-num="${$this.itemNum}">
                                                        <li class="list-form">
                                                            <?php if(isset($noanswer)){
                                                                for($i=0;$i<count($noanswer);$i++){?>

                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">

                                                                                <span style="display: contents" class="edit-show"><?php echo $noanswer[$i]->title?></span>
                                                                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $noanswer[$i]->title?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="show_inHome_element" type="checkbox" statusid="<?php echo $noanswer[$i]->id?>" <?php echo($noanswer[$i]->at_home!=0)?
                                                                                        'checked':"" ?> >
                                                                                    يعرض فى الصفحة الرئيسية
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="not_active_element" type="checkbox" statusid="<?php echo $noanswer[$i]->id?>" <?php echo($noanswer[$i]->is_active ==0)?
                                                                                        'checked':"" ?> >
                                                                                    غير نشط
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">

                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="client-Follow" statusid="<?php echo $noanswer[$i]->id?>" <?php echo($noanswer[$i]->follow!=0)?
                                                                                        'checked':"" ?> type="checkbox" >
                                                                                    تتبع العميل
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <i class="fa fa-times-circle float-right text-danger pt-3 delete-elemnet" statusid="<?php echo $noanswer[$i]->id?>" style="margin-right: 15px"></i>
                                                                        </div>


                                                                    </div>





                                                                <?php }} ?>
                                                            <div class="row my-5">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <input class="form-control"
                                                                               placeholder="اسم جديد" id="addsub" name="name" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="at_home1" >
                                                                            يعرض فى الصفحة الرئيسية
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">

                                                                    <div class="form-group">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="follow1">
                                                                            تتبع العميل
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1">
                                                                    <button id="add-s" class="btn btn-info px-5">أضافه</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end::Item-->

                                        <!--begin::Item-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_2_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_2_body" aria-expanded="    false">
                                                    <span class="m-accordion__item-icon text-success"><i
                                                                class="fa  	fa-phone-volume"></i></span>
                                                <span class="m-accordion__item-title">تم الرد</span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse"
                                                 id="m_accordion_2_item_2_body" role="tabpanel"
                                                 aria-labelledby="m_accordion_2_item_2_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <ul class="list-item" data-item-num="${$this.itemNum}">
                                                        <li class="list-form">
                                                            <?php if(isset($answer)){
                                                                for($i=0;$i<count($answer);$i++){?>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">

                                                                                <span style="display: contents" class="edit-show"><?php echo $answer[$i]->title?></span>
                                                                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $answer[$i]->title?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="show_inHome_element" type="checkbox" statusid="<?php echo $answer[$i]->id?>" <?php echo($answer[$i]->at_home!=0)?
                                                                                        'checked':"" ?> >
                                                                                    يعرض فى الصفحة الرئيسية
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="not_active_element" type="checkbox" statusid="<?php echo $answer[$i]->id?>" <?php echo($answer[$i]->is_active ==0)?
                                                                                        'checked':"" ?> >
                                                                                    غير نشط
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="client-Follow" statusid="<?php echo $answer[$i]->id?>" <?php echo($answer[$i]->follow!=0)?
                                                                                        'checked':"" ?> type="checkbox" >
                                                                                    تتبع العميل
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <i class="fa fa-times-circle float-right text-danger pt-3 delete-elemnet" statusid="<?php echo $answer[$i]->id?>" style="margin-right: 15px"></i>
                                                                        </div>
                                                                    </div>
                                                                <?php }} ?>
                                                            <div class="row my-5">
                                                                <div class="col-md-2">
                                                                    <div class="form-group ">
                                                                        <input class="form-control"
                                                                               placeholder="اسم جديد" id="addsub1" name="name" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="answer">
                                                                            <option value="1">عادى</option>
                                                                            <option value="2">قيد التعاقد</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="at_home2" >
                                                                            يعرض فى الصفحة الرئيسية
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">

                                                                    <div class="form-group">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="follow2">
                                                                            تتبع العميل
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1">
                                                                    <button id="add-s1" class="btn btn-info px-5">أضافه</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_3_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_3_body" aria-expanded="    false">
                                                    <span class="m-accordion__item-icon"><i
                                                                class="flaticon-notes"></i></span>
                                                <span class="m-accordion__item-title">  قيد الحجز </span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse"
                                                 id="m_accordion_2_item_3_body" role="tabpanel"
                                                 aria-labelledby="m_accordion_2_item_3_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <ul class="list-item" data-item-num="${$this.itemNum}">
                                                        <li class="list-form">
                                                            <?php if(isset($reserve)){
                                                                for($i=0;$i<count($reserve);$i++){?>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">

                                                                                <span style="display: contents" class="edit-show"><?php echo $reserve[$i]->title?></span>
                                                                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $reserve[$i]->title?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="show_inHome_element" type="checkbox" statusid="<?php echo $reserve[$i]->id?>" <?php echo($reserve[$i]->at_home!=0)?
                                                                                        'checked':"" ?> >
                                                                                    يعرض فى الصفحة الرئيسية
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="not_active_element" type="checkbox" statusid="<?php echo $reserve[$i]->id?>" <?php echo($reserve[$i]->is_active ==0)?
                                                                                        'checked':"" ?> >
                                                                                    غير نشط
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="client-Follow" statusid="<?php echo $reserve[$i]->id?>" <?php echo($reserve[$i]->follow!=0)?
                                                                                        'checked':"" ?> type="checkbox" >
                                                                                    تتبع العميل
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <i class="fa fa-times-circle float-right text-danger pt-3 delete-elemnet" statusid="<?php echo $reserve[$i]->id?>" style="margin-right: 15px"></i>
                                                                        </div>
                                                                    </div>
                                                                <?php }} ?>
                                                            <div class="row my-5">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <input class="form-control"
                                                                               placeholder="اسم جديد" id="addsub1" name="name" />
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="at_home2" >
                                                                            يعرض فى الصفحة الرئيسية
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">

                                                                    <div class="form-group">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="follow2">
                                                                            تتبع العميل
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1">
                                                                    <button id="add-s1" class="btn btn-info px-5">أضافه</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!--                                        ارقام خاطئه-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_4_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_4_body" aria-expanded="    false">
                                                        <span class="m-accordion__item-icon"><i
                                                                    class="fa fa-signature text-success"></i></span>
                                                <span class="m-accordion__item-title"> ارقام خاطئه</span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse"
                                                 id="m_accordion_2_item_4_body" role="tabpanel"
                                                 aria-labelledby="m_accordion_2_item_4_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <p>
                                                    <ul class="list-item" data-item-num="${$this.itemNum}">
                                                        <li class="list-form">
                                                            <?php if(isset($wrongData)){
                                                                for($i=0;$i<count($wrongData);$i++){?>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">

                                                                                <span style="display: contents" class="edit-show"><?php echo $wrongData[$i]->title?></span>
                                                                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $wrongData[$i]->title?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="show_inHome_element" type="checkbox" statusid="<?php echo $wrongData[$i]->id?>" <?php echo($wrongData[$i]->at_home!=0)?
                                                                                        'checked':"" ?> >
                                                                                    يعرض فى الصفحة الرئيسية
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="not_active_element" type="checkbox" statusid="<?php echo $wrongData[$i]->id?>" <?php echo($wrongData[$i]->is_active ==0)?
                                                                                        'checked':"" ?> >
                                                                                    غير نشط
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="client-Follow" statusid="<?php echo $wrongData[$i]->id?>" <?php echo($wrongData[$i]->follow!=0)?
                                                                                        'checked':"" ?> type="checkbox" >
                                                                                    تتبع العميل
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <i class="fa fa-times-circle float-right text-danger pt-3 delete-elemnet" statusid="<?php echo $wrongData[$i]->id?>" style="margin-right: 15px"></i>
                                                                        </div>
                                                                    </div>
                                                                <?php }} ?>
                                                            <div class="row my-5">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <input class="form-control"
                                                                               placeholder="اسم جديد" id="addsub3" name="name" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="at_home3" >
                                                                            يعرض فى الصفحة الرئيسية
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">

                                                                    <div class="form-group">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="follow3">
                                                                            تتبع العميل
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1">
                                                                    <button id="add-s3" class="btn btn-info px-5">أضافه</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end::Item-->

                                        <!--قيد الحجز-->


                                        <!--end::Item-->

                                        <!--begin::Item-->


                                        <!--end::Item-->

                                        <!--تم التعاقد-->
                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" role="tab"
                                                 id="m_accordion_2_item_4_head" data-toggle="collapse"
                                                 href="#m_accordion_2_item_6_body" aria-expanded="    false">
                                                    <span class="m-accordion__item-icon"><i
                                                                class="flaticon flaticon-interface-10 text-success"></i></span>
                                                <span class="m-accordion__item-title"> تم التعاقد </span>
                                                <span class="m-accordion__item-mode"></span>
                                            </div>
                                            <div class="m-accordion__item-body collapse"
                                                 id="m_accordion_2_item_6_body" role="tabpanel"
                                                 aria-labelledby="m_accordion_2_item_4_head"
                                                 data-parent="#m_accordion_2">
                                                <div class="m-accordion__item-content">
                                                    <p>
                                                    <ul class="list-item" data-item-num="${$this.itemNum}">
                                                        <li class="list-form">
                                                            <?php if(isset($showContracted)){
                                                                for($i=0;$i<count($showContracted);$i++){?>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">

                                                                                <span style="display: contents" class="edit-show"><?php echo $showContracted[$i]->title?></span>
                                                                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $showContracted[$i]->title?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="show_inHome_element" type="checkbox" statusid="<?php echo $showContracted[$i]->id?>" <?php echo($showContracted[$i]->at_home!=0)?
                                                                                        'checked':"" ?> >
                                                                                    يعرض فى الصفحة الرئيسية
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="not_active_element" type="checkbox" statusid="<?php echo $showContracted[$i]->id?>" <?php echo($showContracted[$i]->is_active ==0)?
                                                                                        'checked':"" ?> >
                                                                                    غير نشط
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group ">
                                                                                <label class="m-checkbox mt-2">
                                                                                    <input class="client-Follow" statusid="<?php echo $showContracted[$i]->id?>" <?php echo($showContracted[$i]->follow!=0)?
                                                                                        'checked':"" ?> type="checkbox" >
                                                                                    تتبع العميل
                                                                                    <span></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <i class="fa fa-times-circle float-right text-danger pt-3 delete-elemnet" statusid="<?php echo $showContracted[$i]->id?>" style="margin-right: 15px"></i>
                                                                        </div>
                                                                    </div>
                                                                <?php }} ?>
                                                            <div class="row my-5">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <input class="form-control"
                                                                               placeholder="اسم جديد" id="addsub4" name="name" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="at_home4" >
                                                                            يعرض فى الصفحة الرئيسية
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-2">

                                                                    <div class="form-group">
                                                                        <label class="m-checkbox mt-2">
                                                                            <input type="checkbox" id="follow4">
                                                                            تتبع العميل
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1">
                                                                    <button id="add-s4" class="btn btn-info px-5">أضافه</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <!--                                        <div class="m-accordion__item">-->
                                        <!--                                            <div class="m-accordion__item-head collapsed" role="tab"-->
                                        <!--                                                 id="m_accordion_2_item_5_head" data-toggle="collapse"-->
                                        <!--                                                 href="#m_accordion_2_item_5_body" aria-expanded="    false">-->
                                        <!--                                                    <span class="m-accordion__item-icon"><i-->
                                        <!--                                                                class="fa fa-times-circle text-danger"></i></span>-->
                                        <!--                                                <span class="m-accordion__item-title"> الغاء التعاقد </span>-->
                                        <!--                                                <span class="m-accordion__item-mode"></span>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="m-accordion__item-body collapse"-->
                                        <!--                                                 id="m_accordion_2_item_5_body" role="tabpanel"-->
                                        <!--                                                 aria-labelledby="m_accordion_2_item_5_head"-->
                                        <!--                                                 data-parent="#m_accordion_2">-->
                                        <!--                                                <div class="m-accordion__item-content">-->
                                        <!--                                                    <ul class="list-item" data-item-num="${$this.itemNum}">-->
                                        <!--                                                        <li class="list-form">-->
                                        <!--                                                            <div class="row">-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <input class="form-control" name="title"-->
                                        <!--                                                                               value="متابعه ">-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            يعرض فى الصفحة-->
                                        <!--                                                                            الرئيسية-->
                                        <!---->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            غير نشط-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            تتبع العميل-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-1">-->
                                        <!--                                                                    <i-->
                                        <!--                                                                            class="fa fa-times-circle float-right text-danger pt-3  "></i>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                            <div class="row">-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <input class="form-control" name="title"-->
                                        <!--                                                                               value="  سيتواصل    ">-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            يعرض فى الصفحة-->
                                        <!--                                                                            الرئيسية-->
                                        <!---->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            غير نشط-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            تتبع العميل-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-1">-->
                                        <!--                                                                    <i-->
                                        <!--                                                                            class="fa fa-times-circle float-right text-danger pt-3  "></i>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                            <div class="row">-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <input class="form-control" name="title"-->
                                        <!--                                                                               value="  فى انتظار مراجعه الادراه   ">-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            يعرض فى الصفحة-->
                                        <!--                                                                            الرئيسية-->
                                        <!---->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            غير نشط-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            تتبع العميل-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-1">-->
                                        <!--                                                                    <i-->
                                        <!--                                                                            class="fa fa-times-circle float-right text-danger pt-3  "></i>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                            <div class="row">-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <input class="form-control" name="title"-->
                                        <!--                                                                               value="لم يتم الرد مره واحده">-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            يعرض فى الصفحة-->
                                        <!--                                                                            الرئيسية-->
                                        <!---->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            غير نشط-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            تتبع العميل-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-1">-->
                                        <!--                                                                    <i-->
                                        <!--                                                                            class="fa fa-times-circle float-right text-danger pt-3  "></i>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                            <div class="row my-5">-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <input class="form-control" name="title"-->
                                        <!--                                                                               value="اسم جديد"/>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group">-->
                                        <!--                                                                        <select class="form-control" id="answer">-->
                                        <!--                                                                            <option value="1">عادى</option>-->
                                        <!--                                                                            <option value="2">قيد التعاقد</option>-->
                                        <!--                                                                        </select>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!--                                                                <div class="col-md-3">-->
                                        <!--                                                                    <div class="form-group ">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            يعرض فى الصفحة-->
                                        <!--                                                                            الرئيسية-->
                                        <!---->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-2">-->
                                        <!---->
                                        <!--                                                                    <div class="form-group">-->
                                        <!--                                                                        <label class="m-checkbox mt-2">-->
                                        <!--                                                                            <input type="checkbox" id="asNewClient">-->
                                        <!--                                                                            تتبع العميل-->
                                        <!--                                                                            <span></span>-->
                                        <!--                                                                        </label>-->
                                        <!--                                                                    </div>-->
                                        <!--                                                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                                                <div class="col-md-1">-->
                                        <!--                                                                    <button-->
                                        <!--                                                                            class="btn btn-info px-5">أضافه</button>-->
                                        <!--                                                                </div>-->
                                        <!--                                                            </div>-->
                                        <!--                                                        </li>-->
                                        <!--                                                    </ul>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->

                                        <!--end::Item-->
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





<script type="text/javascript">


    $(document).ready(function () {
        $('#example').DataTable( {
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
        })
    })




    // Code used to add Todo Tasks
    jQuery(document).ready(function ($) {
        var $todo_tasks = $("#todo_tasks");

        $todo_tasks.find('input[type="text"]').on('keydown', function (ev) {
            if (ev.keyCode == 13) {
                ev.preventDefault();

                if ($.trim($(this).val()).length) {
                    var $todo_entry = $(
                        '<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>' +
                        $(this).val() +
                        '</label></div></li>');
                    $(this).val('');

                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                    $todo_entry.hide().slideDown('fast');
                    replaceCheckboxes();
                }
            }
        });




    });

    /* deleteFunction */


    $(document).on("click", "#td-id", function () {


        // var OriginalContent = $(this).parent("td").find("span").text();
        var OriginalContent = $(this).parent("td").siblings().find("span").attr("text");
        var inputNewText = prompt("Enter new content for:", OriginalContent);
        var changeid = $(this).attr("changeid");
        var changetype = $(this).attr("changetype");
        var base = $("#base").val();
        var element = $(this);
        if (inputNewText != null) {
            $.ajax({
                type: "POST",
                url: base + "users/change",
                data: ({
                    changeid: changeid,
                    content: inputNewText

                }),
                success: function (data) {
                    if (data == 1) {

                        toastr.success("تم التعديل بنجاح");
                        $(element).parent("td").siblings().find("span").attr("text",inputNewText);
                        $(element).parent("td").siblings().find("span").text(inputNewText);
                        $(".change" + changetype).text(inputNewText);
                    } else {
                        toastr.error("يجب ادخال محتوي");
                    }
                }
            });
        }


    });
</script>


<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active4");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "200px";
            }
        });
    }
    var acc = document.getElementsByClassName("accordion4");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active4");

            $(".sub").css({
                "border-color": "black",
                "border-width": "0px",
                "border-style": "solid"
            });


            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "200px";
                $(".sub").css({
                    "border-color": "black",
                    "border-width": "1px",
                    "border-style": "solid"
                });

            }
        });
    }
    $(document).on("click", "#add-s2 ", function () {
        //    var subname = document.getElementById("addsub");

        var subname = $("#addsub2").val();
        var base = $("#base").val();

        if ($("#addsub2").val().length != 0) {
            var filter = 3;
            if (document.getElementById("at_home3").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow1").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }
            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 3,
                    type: 1,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {

                    toastr.success("تم الاضافه بنجاح  بنجاح");

                    location.reload();
                }
            });


        }


    });
    $(document).on("click", "#add-s1 ", function () {
        //    var subname = document.getElementById("addsub");


        var subname = $("#addsub1").val();
        var base = $("#base").val();

        if ($("#addsub1").val().length != 0) {
            // var filter = $("#answer").val();
            if (document.getElementById("at_home2").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow2").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }
            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 1,
                    type: 1,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {

                    toastr.success("تم الاضافه بنجاح  بنجاح");

                    location.reload();
                }
            });


        }


    });
    $(document).on("click", "#add-s", function () {
        //    var subname = document.getElementById("addsub");
        var subname = $("#addsub").val();
        var base = $("#base").val();

        if ($("#addsub").val().length != 0) {
            //  var filter=$("#noanswer").val();
            if (document.getElementById("at_home1").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow1").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }

            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 2,
                    type: 2,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {

                    toastr.success("تم الاضافه بنجاح  بنجاح");

                    location.reload();
                }
            });


        }




    });
    $(document).on("click", "#add-s3", function () {
        var subname = $("#addsub3").val();
        var base = $("#base").val();
        if (subname.length != 0) {
            if (document.getElementById("at_home3").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow3").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }
            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 4,
                    type: 3,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {

                    toastr.success("تم الاضافه بنجاح  بنجاح");

                    location.reload();
                }
            });
        }
    });
    $(document).on("click", "#add-s4", function () {
        var subname = $("#addsub4").val();
        var base = $("#base").val();
        if (subname.length != 0) {
            if (document.getElementById("at_home4").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow4").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }
            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 5,
                    type: 4,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {

                    toastr.success("تم الاضافه بنجاح  بنجاح");

                    location.reload();
                }
            });
        }
    });
    $(document).on("click", "#add-s5", function () {
        var subname = $("#addsub5").val();
        var base = $("#base").val();
        if (subname.length != 0) {
            if (document.getElementById("at_home5").checked) {
                var at_home = '1';
            } else {
                var at_home = '0';
            }
            if (document.getElementById("follow5").checked) {
                var follow = '1';
            } else {
                var follow = '0';
            }
            $.ajax({
                type: "POST",
                url: base + "users/addstatus",
                data: ({
                    title: subname,
                    status: 6,
                    type: 5,
                    athome: at_home,
                    follow: follow
                }),
                success: function (data) {
                    toastr.success("تم الاضافه بنجاح  بنجاح");
                    location.reload();
                }
            });
        }
    });
    $(document).on("click", ".delete-elemnet ", function () {
        var result = confirm("هل تريد المسح");
        if (result) {
            var status = $(this).attr("statusid");
            var base = $("#base").val();
            var element = $(this);
            $.ajax({
                type: "POST",
                url: base + "users/delstatus",
                data: ({
                    messid: status
                }),
                success: function (data) {
                    if (data == 1) {
                        toastr.success("تم المسح  بنجاح");
                        $($(element).parent()).parent().remove();
                    }else{
                        toastr.error("لا يمكن حذف حالة المكالمة لانها قيد الاستخدام");
                    }


                }
            });
        }


    });
    $( ".update-elemnet" ).click(function() {
        $(this).hide();
        $(this).siblings( ".edit-show" ).hide();

        $(this).siblings( ".save-elemnet" ).show();
        $(this).siblings( ".Status-Name" ).show();
        $(this).siblings( ".Status-Name" ).focus();

    });
    $( ".save-elemnet" ).click(function() {


        var statusID = $(this).attr("statusid");
        var Name =  $(this).siblings( ".Status-Name" ).val();

        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/updatestatus",
            data: ({id: statusID,
                StatusName:Name
            }),
            success: function (data) {
                if (data == 1) {
                    alert("تم التعديل  بنجاح");

                    $(element).hide();
                    $(element).siblings( ".edit-show" ).text(Name);
                    $(element).siblings( ".edit-show" ).show();

                    $(element).siblings( ".update-elemnet" ).show();

                    $(element).siblings( ".Status-Name" ).hide();

                }else{
                    alert("حدث خطأ اثناء التعديل");
                }


            }
        });




    });
    $(".Status-Name").bind("keypress", {},  function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {

            var statusID =$(this).siblings( ".save-elemnet" ).attr("statusid");
            var Name =  $(this).val();
            var element = $(this);
            $.ajax({
                type: "POST",
                url: base + "users/updatestatus",
                data: ({id: statusID,
                    StatusName:Name
                }),
                success: function (data) {
                    if (data == 1) {
                        toastr.success("تم التعديل  بنجاح");
                        $(element).hide();
                        $(element).siblings( ".edit-show" ).text(Name);
                        $(element).siblings( ".edit-show" ).show();

                        $(element).siblings( ".update-elemnet" ).show();

                        $(element).siblings( ".save-elemnet" ).hide();

                    }else{
                        toastr.error("حدث خطأ اثناء التعديل");

                    }


                }
            });
        }
    });
    $(document).on("click", ".not_active_element", function () {
        var status = $(this).attr("statusid");
        var base = $("#base").val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/active_status",
            data: ({
                messid: status
            }),
            success: function (data) {
                toastr.success("تمت العمليه بنجاح");
            }
        });
    });
    // Update call status
    $(document).on("click", ".client-Follow", function () {
        var status = $(this).attr("statusid");
        var base = $("#base").val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/setFollowStatus",
            data: ({
                messid: status
            }),
            success: function (data) {
                toastr.success("تمت العمليه بنجاح");
            }
        });
    });
    $(document).on("click", ".show_inHome_element", function () {
        var status = $(this).attr("statusid");
        var base = $("#base").val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/SetAtHome",
            data: ({
                messid: status
            }),
            success: function (data) {
                toastr.success("تمت العمليه بنجاح");
            }
        });
    });
    $(document).on("click", ".follow_btn", function () {
        var value = $(".follow").val();
        var base = $("#base").val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "users/update_time",
            data: ({
                time: value
            }),
            success: function (data) {
                if (data == 1) {
                    toastr.success("تم  التعديل بنجاح");
                } else {
                    toastr.error("يجب ادخال محتوي");
                }
            }
        });



    });
</script>

</body>


</html>