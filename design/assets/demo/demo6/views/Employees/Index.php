<?php $this->load->view("header");?>
<?php $userPermissions = get_premissions($_SESSION["userid"],"08") ?>




<br><br>
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%;margin-left:4%">

    <!-- BEGIN: Subheader -->


    <!-- END: Subheader -->
    <div class="m-content">



        <?php
        if ($userPermissions == 1 || $_SESSION["usertype"]==1){ ?>
            <div class="row">
                <div class="col-lg-2 ml-auto">
                    <a class="btn btn-info page-size px-5" href="<?php echo $url.'Employees/Add'?>">  مستخدم جديد

                        <i class="flaticon flaticon-users ml-2"></i>
                    </a>
                </div>
            </div>

            <?php
        }

        ?>

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Aside Menu -->
            <!-- END: Aside Menu -->
            <div class="row ml-0 mr-0 mt-4 p-0">
                <div class="col-12">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        الموارد البشرية
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body tabs_border">
                            <ul class="nav nav-tabs" role="tablist">

                                <?php
                                $per=get_pre($_SESSION["userid"],'08');
                                if($_SESSION["usertype"]==1 || $userPermissions == 1)
                                {?>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                           href="#m_tabs_6_1" role="tab"> <i class="flaticon-users"></i>موظفين</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3"
                                           role="tab"><i class="flaticon-users"></i>مشرفين</a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#Administrative"
                                           role="tab"><i class="flaticon-users"></i>الإداريين</a>
                                    </li>
                                <?php } ?>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                    <table class="table m-table " id="example_1">
                                        <thead>
                                        <tr>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 150px;"
                                                aria-label="الاسم: activate to sort column ascending">
                                                <i class="flaticon-user"></i> الاسم</th>
                                            <th style="width: 150px;"><i class="flaticon-users"></i>المشرف </th>
                                            <th style="width: 150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){?>
                                            <tr>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p>
                                                                <?php echo $emps[$i]->Name?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <?php echo get_Emp_name($emps[$i]->Super,1)?>
                                                </td>

                                                <td>



                                                    <?php
                                                    if ($_SESSION['usertype'] == 1 || $userPermissions==1){?>

                                                        <a href="<?php echo $url.'Employees/Update/'.$emps[$i]->ID?>" class="mr-1"
                                                           id="t3del">
                                                            <i class="fa fa-user-edit text-info" data-toggle="tooltip" data-placement="top" title="تعديل"></i>
                                                        </a>
                                                    <?php   }
                                                    ?>
                                                    <a href="<?php echo isset($_SESSION['date1']) ? $url.'Client/Clients/'.$emps[$i]->ID.'/'.$_SESSION['date1'].'@'.$_SESSION['date2'] :$url.'Client/Clients/'.$emps[$i]->ID?>" class="mr-1"
                                                       id="t3del">
                                                        <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="مهام"></i>
                                                    </a>
                                                    <a style="cursor: pointer" class="mr-1 activeuser" status="<?php echo $emps[$i]->active?>"
                                                       userid="<?php echo $emps[$i]->ID?>">

                                                        <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } }?>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                    <table class="table m-table" id="example_2">
                                        <thead>
                                        <tr>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width:150px;"
                                                aria-label="الاسم: activate to sort column ascending">
                                                <i class="flaticon-user"></i> الاسم</th>
                                            <th style="width:150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>



                                        <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                                            <tr>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <?php echo $supers[$i]->Name?>
                                                        </div>
                                                    </div>


                                                </td>

                                                <td>
                                                    <?php
                                                    if ($_SESSION['usertype'] == 1 || $userPermissions == 1){?>
                                                        <a style="cursor: pointer;" class="mr-1 activeuser" status="<?php echo $supers[$i]->active?>"
                                                           userid="<?php echo $supers[$i]->ID?>">
                                                            <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
                                                        </a>
                                                        <a href="<?php echo $url.'Employees/Update/'.$supers[$i]->ID?>" class="btn btn-blue btn-sm icon-left"
                                                           id="t3del">
                                                            <i class="fa fa-user-edit text-info" data-toggle="tooltip" data-placement="top" title="تعديل"></i>
                                                        </a>

                                                    <?php }
                                                    ?>
                                                    <a href="<?php echo isset($_SESSION['date1']) ? $url.'Client/Clients/'.$supers[$i]->ID.'/'.$_SESSION['date1'].'@'.$_SESSION['date2'] :$url.'Client/Clients/'.$supers[$i]->ID?>" class="btn btn-blue btn-sm icon-left"
                                                       id="t3del">
                                                        <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="مهام"></i></a>
                                                </td>
                                            </tr>
                                        <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="Administrative" role="tabpanel">
                                    <table class="table m-table" id="example_2">
                                        <thead>
                                        <tr>
                                            <th class="sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width:150px;"
                                                aria-label="الاسم: activate to sort column ascending">
                                                <i class="flaticon-user"></i> الاسم</th>
                                            <th style="width:150px;">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>



                                        <?php if(isset($Administrative)){ for($i=0;$i<count($Administrative);$i++){?>
                                            <tr>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <?php echo $Administrative[$i]->Name?>
                                                        </div>
                                                    </div>


                                                </td>

                                                <td>
                                                    <?php
                                                    if ($_SESSION['usertype'] == 1 || $userPermissions == 1){?>
                                                        <a style="cursor: pointer;" class="mr-1 activeuser" status="<?php echo $Administrative[$i]->active?>"
                                                           userid="<?php echo $Administrative[$i]->ID?>">
                                                            <i class="fa fa-user-times text-danger" data-toggle="tooltip" data-placement="top" title="حذف"></i>
                                                        </a>
                                                        <a href="<?php echo $url.'Employees/Update/'.$Administrative[$i]->ID?>" class="btn btn-blue btn-sm icon-left"
                                                           id="t3del">
                                                            <i class="fa fa-user-edit text-info" data-toggle="tooltip" data-placement="top" title="تعديل"></i>
                                                        </a>

                                                    <?php }
                                                    ?>
                                                    <a href="<?php echo isset($_SESSION['date1']) ? $url.'Client/Clients/'.$Administrative[$i]->ID.'/'.$_SESSION['date1'].'@'.$_SESSION['date2'] :$url.'Client/Clients/'.$Administrative[$i]->ID?>" class="btn btn-blue btn-sm icon-left"
                                                       id="t3del">
                                                        <i class="fa fa-user-cog text-info" data-toggle="tooltip" data-placement="top" title="مهام"></i></a>
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

            </div>

        </div>

    </div>
</div>









<script type="text/javascript">
    $(document).ready(function () {
        $("table[id^='example']").DataTable( {
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
            },

            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    if (column.index() == 4) {
                        var select = $("#filter")
                            .on('change', function () {
                                var val;
                                if (this.selectedIndex == 0) {
                                    val = '';
                                } else {
                                    val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                }
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
                    }


                });
            },
        });
    });


    $("#selectall").change(function () {
        if (this.checked) {
            var selectAll = $(".checkboxMy").toArray();
            for (var x = 0; x < selectAll.length; x++) {
                $(selectAll[x]).attr("checked", "checked");
            }
        } else {
            var selectAll = $(".checkboxMy").toArray();
            for (var x = 0; x < selectAll.length; x++) {
                $(selectAll[x]).removeAttr("checked", "checked");
            }
        }
    })





    $(".activeuser").click(function () {
        var userid = $(this).attr("userid");
        var status = $(this).attr("status");
        var base = $("#base").val();
        // alert(status);
        if (status == 1) {
            status = 0;
        } else {
            status = 1;
        }
        var element = $(this);
        $.ajax({
            type: "POST",
            url: base + "Employees/DeActive",
            data: ({
                userid: userid,
                status: status
            }),
            success: function (data) {
                if (status == 0) {
                    // element.attr("status",1);
                    // element.text("تفعيل");
                    // toastr.success("تم تعطيل المستخدم بنجاح");
                    alert("تم تعطيل المستخدم بنجاح");
                    location.reload();
                } else {
                    //     element.attr("status",0);
                    //     element.text("تعطيل");
                    alert("تم تفعيل المستخدم بنجاح");
                    location.reload();
                }
            }
        });

    });
</script>
</body>

</html>