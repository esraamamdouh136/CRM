
<?php $this->load->view("header");?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right: 8%;margin-left: 2%">

    <div class="m-content">

        <div class="m-portlet">
            <div class="m-portlet__body">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                إعدادات التعاقد
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table m-table m-table--head-bg-info" id="html_table" width="100%">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                colspan="1" style="width: 118px;"
                                aria-label="الموظف: activate to sort column ascending"> الحاله </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                colspan="1" style="width: 120px;"
                                aria-label="المشرف: activate to sort column ascending"> الاعدادات </th>
                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                colspan="1" style="width: 120px;"
                                aria-label="التاريخ: activate to sort column ascending">عمليات</th>
                        </tr>
                        </thead>
                        <tbody>





                        <?php if(isset($parent)){
                            for($i=0;$i<count($parent);$i++){?>
                        <tr class="clickable-row task-list-row odd" style="cursor: pointer;"
                            data-priority="متابعه" data-href="16" role="row">
                            <td>
                                <i class="flaticon flaticon-edit"></i>
                            </td>
                                    <?php
                                    $HaveChiled = IsHaveChiled($parent[$i]->ID);
                                    if ($HaveChiled){?>

                                        <span class="accordion4">
                                    </span>

                                        <?php
                                    }else{?>
                                        <span style="margin-left: 20px;"></span>
                                    <?php }
                                    ?>

                                <td>
                                    <span class="update-elemnet glyphicon glyphicon-pencil" style="cursor: pointer;margin-left: 10px"></span>
                                    <span class="save-elemnet glyphicon glyphicon-saved " statusid="<?php echo $parent[$i]->ID?>" style="cursor: pointer;display: none;margin-left: 10px"></span>
                                    <span style="display: contents" class="edit-show"><?php echo $parent[$i]->Text?></span>
                                    <input style="display: none" class="Status-Name" type="text"  value="<?php echo $parent[$i]->Text?>">


                                    <div class="child " style="display: none;padding-bottom: 10px">
                                        <?php
                                        if ($HaveChiled){?>
                                            <ul>
                                                <?php
                                                $childs = GetOrderSettings($parent[$i]->ID);
                                                foreach ($childs as $item){?>
                                                    <li>
                                                        <span class="update-elemnet glyphicon glyphicon-pencil" style="cursor: pointer;margin-left: 10px"></span>
                                                        <span class="save-elemnet glyphicon glyphicon-saved " statusid="<?php echo $item->ID?>" style="cursor: pointer;display: none;margin-left: 10px"></span>
                                                        <span style="display: contents" class="edit-show"><?php echo $item->Text?></span>
                                                        <input style="display: none" class="Status-Name" type="text"  value="<?php echo $item->Text?>">

                                                        <?php if ($parent[$i]->Pro_Name !='Amount'){?>
                                                            <span style="margin-right: 37px;">

                                                    <input statusid="<?php echo $item->ID?>" type="checkbox"
                                                           class="not_active_element" <?php if($item->Is_Active==1){
                                                        echo 'checked'; } ?> class="form-contro-inline" > نشط </span>
                                                            <?php
                                                        }?>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        <?php  }
                                        ?>
                                    </div>
                                </td>

                            <td class="checkable-td sorting_1" tabindex="0">
                            <span style="margin-right: 37px;">
                                <input statusid="<?php echo $parent[$i]->ID?>" type="checkbox" class="not_active_element" <?php if($parent[$i]->Is_Active==1){
                                                        echo 'checked'; } ?> class="form-contro-inline" > نشط </span>
                            </td>


                        </tr>
                            <?php } }?>




                        <tr class="clickable-row task-list-row odd" style="cursor: pointer;"
                            data-priority="متابعه" data-href="16" role="row">
                            <td>
                                <i class="flaticon flaticon-edit"></i>
                            </td>
                            <td> النوع </td>
                            <td class="checkable-td sorting_1" tabindex="0">
                                <input type="checkbox" class="checkboxMy  chk elem0">
                                <input type="hidden" class="dataID custid0" value="16"> نشط
                            </td>
                        </tr>





<!--                        <tr class="clickable-row task-list-row even" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="94" role="row">-->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                المنتج </td>-->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem1">-->
<!--                                <input type="hidden" class="dataID custid1" value="94">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        <tr class="clickable-row task-list-row odd" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="1" role="row">-->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                الخدمه-->
<!--                            </td>-->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem2">-->
<!--                                <input type="hidden" class="dataID custid2" value="1">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        <tr class="clickable-row task-list-row even" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="12" role="row">-->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                طريقه الشحن-->
<!--                            </td>-->
<!---->
<!---->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem3">-->
<!--                                <input type="hidden" class="dataID custid3" value="12">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        <tr class="clickable-row task-list-row even" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="12" role="row">-->
<!---->
<!---->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!---->
<!---->
<!---->
<!---->
<!--                            <td>-->
<!--                                طريقه الدفع-->
<!--                            </td>-->
<!---->
<!---->
<!---->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem3">-->
<!--                                <input type="hidden" class="dataID custid3" value="12">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        <tr class="clickable-row task-list-row even" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="12" role="row">-->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                المبلغ-->
<!--                            </td>-->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem3">-->
<!--                                <input type="hidden" class="dataID custid3" value="12">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        <tr class="clickable-row task-list-row even" style="cursor: pointer;"-->
<!--                            data-priority="متابعه" data-href="12" role="row">-->
<!---->
<!---->
<!--                            <td>-->
<!--                                <i class="flaticon flaticon-edit"></i>-->
<!--                            </td>-->
<!---->
<!--                            <td>-->
<!--                                حسابات التعاقد-->
<!--                            </td>-->
<!---->
<!---->
<!--                            <td class="checkable-td sorting_1" tabindex="0"><input type="checkbox"-->
<!--                                                                                   class="checkboxMy  chk elem3">-->
<!--                                <input type="hidden" class="dataID custid3" value="12">نشط-->
<!--                            </td>-->
<!---->
<!--                        </tr>-->
<!--                        -->
<!--                        -->



                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>


</div>

<div class="contains">

    <div class="row">
        <div class="col-md-12 ">
            <section class="content-header">
                <ul style="color: black" >
                    <?php if(isset($parent)){
                        for($i=0;$i<count($parent);$i++){?>
                            <li>

                                <?php
                                $HaveChiled = IsHaveChiled($parent[$i]->ID);
                                if ($HaveChiled){?>

                                    <span class="accordion4">
                                    </span>

                                    <?php
                                }else{?>
                                    <span style="margin-left: 20px;"></span>
                                <?php }
                                ?>


                                <span class="update-elemnet glyphicon glyphicon-pencil" style="cursor: pointer;margin-left: 10px"></span>
                                <span class="save-elemnet glyphicon glyphicon-saved " statusid="<?php echo $parent[$i]->ID?>" style="cursor: pointer;display: none;margin-left: 10px"></span>
                                <span style="display: contents" class="edit-show"><?php echo $parent[$i]->Text?></span>
                                <input style="display: none" class="Status-Name" type="text"  value="<?php echo $parent[$i]->Text?>">
                                <span style="margin-right: 37px;">
                                                    <input statusid="<?php echo $parent[$i]->ID?>" type="checkbox"
                                                           class="not_active_element" <?php if($parent[$i]->Is_Active==1){
                                                        echo 'checked'; } ?> class="form-contro-inline" > نشط </span>

                                <div class="child " style="display: none;padding-bottom: 10px">
                                    <?php
                                    if ($HaveChiled){?>
                                        <ul>
                                            <?php
                                            $childs = GetOrderSettings($parent[$i]->ID);
                                            foreach ($childs as $item){?>
                                                <li>
                                                    <span class="update-elemnet glyphicon glyphicon-pencil" style="cursor: pointer;margin-left: 10px"></span>
                                                    <span class="save-elemnet glyphicon glyphicon-saved " statusid="<?php echo $item->ID?>" style="cursor: pointer;display: none;margin-left: 10px"></span>
                                                    <span style="display: contents" class="edit-show"><?php echo $item->Text?></span>
                                                    <input style="display: none" class="Status-Name" type="text"  value="<?php echo $item->Text?>">

                                                    <?php if ($parent[$i]->Pro_Name !='Amount'){?>
                                                        <span style="margin-right: 37px;">

                                                    <input statusid="<?php echo $item->ID?>" type="checkbox"
                                                           class="not_active_element" <?php if($item->Is_Active==1){
                                                        echo 'checked'; } ?> class="form-contro-inline" > نشط </span>
                                                        <?php
                                                    }?>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    <?php  }
                                    ?>



                                </div>







                            </li>
                        <?php } }?>
                </ul>
            </section>
        </div>
    </div>

</div>





<script>

    $(".update-elemnet").click(function() {
        $(this).hide();
        $(this).siblings( ".edit-show" ).hide();
        $(this).siblings( ".save-elemnet" ).show();
        $(this).siblings( ".Status-Name" ).show();
        $(this).siblings( ".Status-Name" ).focus();

    });
    $(".save-elemnet").click(function() {
        var statusID = $(this).attr("statusid");
        var Name =  $(this).siblings( ".Status-Name" ).val();
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "CRM_OrderSettings/update",
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
    $(".not_active_element").click(function () {

        var ID = $(this).attr("statusid");
        var base = $("#base").val();

        var stat = this.checked;



        $.ajax({
            type: "POST",
            url: base + "CRM_OrderSettings/ChangeStatus",
            data: ({id:ID,
                status: stat
            }),
            success: function (data) {
                if (data == 1){
                    alert("تمت العمليه بنجاح");
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
                url: base + "CRM_OrderSettings/update",
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

                        $(element).siblings( ".save-elemnet" ).hide();

                    }else{
                        alert("حدث خطأ اثناء التعديل");
                    }


                }
            });
        }
    });

    var opend1=0;
    $(".accordion4").click(function () {
        if (opend1 == 0){
            $(this).siblings( ".child" ).show();
            $(this).siblings( ".child" ).css("border-style", "solid");
            $(this).siblings( ".child" ).css("border-width", "1px");
            $(this).addClass("active4");
            opend1 = 1;
        }else{
            $(this).siblings( ".child" ).hide();
            $(this).removeClass("active4");
            opend1 = 0;
        }


    });







</script>

</body>


</html>