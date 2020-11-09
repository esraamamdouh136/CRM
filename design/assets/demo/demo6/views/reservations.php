<?php $this->load->view("header");?>

<div class="contains">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs bordered">
                <!-- available classes "bordered", "right-aligned" -->
                <li class="active">
                    <a href="#first" data-toggle="tab">
                        <span class="visible-xs">المنتجات والخدمات</span>
                        <span class="hidden-xs"> المنتجات والخدمات</span>
                    </a>
                </li>
                <li>
                    <a href="#second" data-toggle="tab">
                        <span class="visible-xs">الشحن</span>
                        <span class="hidden-xs"> الشحن</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="first">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-green add-done-btn3">+ اضافة</button>
                            <table id="estable" class="display  myTableDaily">
                                <thead>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i>   الكود
                                    </th>
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i>   اسم المنتج
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i>   السعر
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الوصف
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الغاء الحجز خلال
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <!-- email list -->
                                <tbody>
                                <?php
                                if(isset($meto))
                                {
                                    print_r($meto);
                                }
                                if(isset($products)){ for($i=0;$i<count($products);$i++){?>
                                    <tr protype="1" class="unread" data-toggle="modal" ><!-- new email class: unread -->
                                        <td class="prodid">
                                            <?php  echo $products[$i]->ProductCrmId?>
                                        </td>
                                        <td class="col-name pname">
                                            <?php echo $products[$i]->ProductCrmName?>
                                        </td>
                                        <td class="pprice">
                                            <?php echo $products[$i]->ProductCrmPrice?>
                                        </td>
                                        <td class="col-subject pdesc">
                                            <?php echo $products[$i]->ProductCrmDesc?>
                                        </td>
                                        <td class="col-subject pcancel">
                                            <?php echo $products[$i]->ProductCrmCancelDate." ايام  "?>
                                        </td>
                                        <td class="col-subject">
                                            <button prodId="" class="btn btn-blue editproduct" mess="<?php echo $products[$i]->ProductCrmId?>">
                                                <i class="entypo-download"></i>حفظ
                                            </button>
                                            <button class="btn btn-danger delete" mess="<?php echo $products[$i]->ProductCrmId?>">
                                                <i class="entypo-trash"></i>مسح
                                            </button>
                                        </td>
                                    </tr>
                                <?php } }?>
                                </tbody>

                                <!-- mail table footer -->

                            </table>
                        </div>
                        <br>
                        <hr class="style8">
                        <br>
                        <div class="col-md-12">
                            <button class="btn btn-green add-done-btn">+ اضافة</button>
                            <table id="table_id3" class="display">
                                <thead>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <th class="col-name size">

                                        <i class="fas fa-user" style="color:blue"></i>   الكود
                                    </th>
                                    <th class="col-name size">

                                        <i class="fas fa-user" style="color:blue"></i>   اسم الخدمه
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i>   السعر
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الوصف
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الغاء الحجز خلال
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>

                                <!-- email list -->

                                <tbody>
                                <?php
                                if(isset($meto))
                                {
                                    print_r($meto);
                                }
                                if(isset($services)){ for($i=0;$i<count($services);$i++){?>
                                    <tr protype="2" class="unread" data-toggle="modal" ><!-- new email class: unread -->
                                        <td class="prodid">
                                            <?php  echo $services[$i]->ProductCrmId?>
                                        </td>

                                        <td class="col-name pname">

                                            <?php echo $services[$i]->ProductCrmName?>
                                        </td>
                                        <td class="col-subject pprice">
                                            <?php echo $services[$i]->ProductCrmPrice?>
                                        </td>
                                        <td class="col-subject pdesc">
                                            <?php echo $services[$i]->ProductCrmDesc?>

                                        </td>
                                        <td class="col-subject pcancel">
                                            <?php echo $services[$i]->ProductCrmCancelDate." ايام  "?>

                                        </td>

                                        <td class="col-subject">
                                            <button class="btn btn-blue editproduct" mess="<?php echo $services[$i]->ProductCrmId?>">
                                                <i class="entypo-download "></i>حفظ</button>
                                            <button class="btn btn-danger delete" mess="<?php echo $services[$i]->ProductCrmId?>">
                                                <i class="entypo-trash"></i>مسح
                                            </button>
                                        </td>

                                    </tr>
                                <?php } }?>







                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
                <div class="tab-pane" id="second">
                    <button class="btn btn-green add-done-btn113">+ اضافة</button>
                    <table id="table_id2" class="display ">

                        <thead>
                        <tr class="unread">
                            <!-- new email class: unread -->
                            <th class="col-name size">

                                <i class="fas fa-user" style="color:blue"></i>   الكود
                            </th>
                            <th class="col-name size">

                                <i class="fas fa-user" style="color:blue"></i>    طريقه الشحن
                            </th>
                            <th class="col-subject size">
                                <i class="fas fa-users" style="color:blue"></i>   السعر
                            </th>
                            <th class="col-subject size">
                                <i class="fas fa-envelope" style="color:blue"></i>    الوصف
                            </th>

                            <th></th>
                        </tr>
                        </thead>

                        <!-- email list -->

                        <tbody>
                        <?php
                        if(isset($meto))
                        {
                            print_r($meto);
                        }
                        if(isset($trucks)){ for($i=0;$i<count($trucks);$i++){?>
                            <tr protype="3" class="unread" data-toggle="modal" ><!-- new email class: unread -->
                                <td class="prodid">
                                    <?php  echo $trucks[$i]->ProductCrmId?>
                                </td>

                                <td class="col-name pname">

                                    <?php echo $trucks[$i]->ProductCrmName?>
                                </td>
                                <td class="col-subject pprice">
                                    <?php echo $trucks[$i]->ProductCrmPrice?>
                                </td>
                                <td class="col-subject pdesc">
                                    <?php echo $trucks[$i]->ProductCrmDesc?>

                                </td>


                                <td class="col-subject">
                                    <button class="btn btn-blue editproduct" mess="<?php echo $trucks[$i]->ProductCrmId?>">
                                        <i class="entypo-download"></i>حفظ
                                    </button>
                                    <button class="btn btn-danger delete" mess="<?php echo $trucks[$i]->ProductCrmId?>">
                                        <i class="entypo-trash"></i>مسح
                                    </button>
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

<script>
    jQuery(document).ready(function ($) {
        var idtable = $("#table_id3").DataTable({
            "paging": true,
            "pagingType": "full_numbers",
            "info": false,
            "responsive": true,

            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-sort"],

            }],
            "bInfo": true,
            'lengthChange': false,


        });



// 			                idtable.on("click", ".delete", function(){
//
//   console.log($(this).parent());
//   idtable.row($(this).parents('tr')).remove().draw(false);
// });


        $(document).on("click", ".add-done-btn", function () {
            myFunction4();
        });

        $('body').on('click', 'td:not(:has(button))', function(){
            // The cell that has been clicked will be editable
            $(this).attr('contenteditable', 'true');});

        function myFunction4() {


            var btn = "<button class='btn btn-blue addproduct'><i class='entypo-download'></i>حفظ</button><button class='btn btn-danger delete'><i class='entypo-trash'></i>مسح</button>";


            var rowNode = idtable.row.add(["cell1", "cell2", "cell3", "cell4","cell5",btn]).draw(false).node();
            $(rowNode).attr("protype", "2");
            $(rowNode).find('td').eq(0).addClass('prodid');
            $(rowNode).find('td').eq(1).addClass('pname');
            $(rowNode).find('td').eq(2).addClass('pprice');
            $(rowNode).find('td').eq(3).addClass('pdesc');
            $(rowNode).find('td').eq(4).addClass('pcancel');

        }

        var idtable2 = $("#estable").DataTable({
            "paging": true,
            "pagingType": "full_numbers",
            "info": false,
            "responsive": true,

            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-sort"],

            }],
            "bInfo": true,
            'lengthChange': false,


        });
//                    idtable2.on("click", ".delete", function(){
//
//   console.log($(this).parent());
//   idtable2.row($(this).parents('tr')).remove().draw(false);
// });

        function myFunction65() {


            var btn = "<button class='btn btn-blue addproduct'><i class='entypo-download'></i>حفظ</button><button class='btn btn-danger delete'><i class='entypo-trash'></i> مسح</button>";


            var rowNode = idtable2.row.add(["cell1", "cell2", "cell3", "cell4","cell5", btn]).draw(false).node();
            $(rowNode).attr("protype", "1");
            $(rowNode).find('td').eq(0).addClass('prodid');
            $(rowNode).find('td').eq(1).addClass('pname');
            $(rowNode).find('td').eq(2).addClass('pprice');
            $(rowNode).find('td').eq(3).addClass('pdesc');
            $(rowNode).find('td').eq(4).addClass('pcancel');

        }
        $(document).on("click", ".add-done-btn3", function () {
            myFunction65();
        });
        /*************** */

        var idtable23 = $("#table_id2").DataTable({
            "paging": true,
            "pagingType": "full_numbers",
            "info": false,
            "responsive": true,

            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-sort"],

            }],
            "bInfo": true,
            'lengthChange': false,


        });
//                                			                idtable23.on("click", ".delete", function(){
//
//   console.log($(this).parent());
//   idtable23.row($(this).parents('tr')).remove().draw(false);
// });

        function myFunction651() {


            var btn = "<button class='btn btn-blue addproduct'><i class='entypo-download'></i>حفظ</button><button class='btn btn-danger delete'><i class='entypo-trash'></i> مسح</button>";


            var rowNode = idtable23.row.add(["cell1", "cell2", "cell3","cell4", btn]).draw(false).node();
            $(rowNode).attr("protype", "3");
            $(rowNode).find('td').eq(0).addClass('prodid');
            $(rowNode).find('td').eq(1).addClass('pname');
            $(rowNode).find('td').eq(2).addClass('pprice');
            $(rowNode).find('td').eq(3).addClass('pdesc');
        }
        $(document).on("click", ".add-done-btn113", function () {
            myFunction651();
        });
    });

</script>

<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">


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
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>

<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
<script>
    $(document).on( "click",".delete" , function(){
        var y= confirm("Are you Sure");
        if(y==true)
        {
            var status=$.trim($(this).parents("tr").find(".prodid").text());
            var base=$("#base").val();
            var element=$(this);
            $.ajax({
                type: "POST",
                url: base+"users/delproduct",
                data: ({messid:status
                }),
                success: function(data) {
                    toastr.success("تم المسح  بنجاح");
                    $(element).parent().parent().remove();
                }
            });
        }
    });

    $(document).on( "click",".addproduct", function(){
        var pname=$(this).parents("tr").find(".pname").text();
        var price=$(this).parents("tr").find(".pprice").text();
        var type=$(this).parents("tr").attr("protype");
        var desc=$(this).parents("tr").find(".pdesc").text();
        var cancel=$(this).parents("tr").find(".pcancel").text();

        var prodid=$(this).parents("tr").find(".prodid");

        var base=$("#base").val();

        var elem = $(this);
        $.ajax({
            type: "POST",
            url: base+"users/add_product",
            data: ({name:pname,
                price:price,
                type:type,
                desc:desc,
                cancel:cancel
            }),
            success: function(data) {

                if(data != "0" && data != "يجب ادخال جميع البيانات المطلوبه."){
                    prodid.text(data);
                    elem.removeClass("addproduct");
                    elem.addClass("editproduct");
                    toastr.success("تم الاضافه  بنجاح");
                }else{
                    toastr.error(data);
                }

            }
        });
    });
    $(document).on( "click",".editproduct" , function(){
        var pname=$.trim($(this).parents("tr").find(".pname").text());
        var price=$.trim($(this).parents("tr").find(".pprice").text());
        var type=$.trim($(this).parents("tr").attr("protype"));
        var desc=$.trim($(this).parents("tr").find(".pdesc").text());
        var cancel=$.trim($(this).parents("tr").find(".pcancel").text());
        var prodid=$.trim($(this).parents("tr").find(".prodid").text());

        var base=$("#base").val();
        var element=$(this);
        $.ajax({
            type: "POST",
            url: base+"users/edit_product",
            data: ({name:pname,
                price:price,
                type:type,
                desc:desc,
                cancel:cancel,
                prodid:prodid
            }),
            success: function(data) {
                if(data != "0" && data != "يجب ادخال جميع البيانات المطلوبه."){
                    toastr.success("تم التعديل  بنجاح");
                }else{
                    toastr.error(data);
                }
            }
        });

    });
</script>

</body>

</html>