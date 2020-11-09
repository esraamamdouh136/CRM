<?php  $this->load->view("header");?>


<div class="contains">



    <br />

    <!--mail-body       -->

    <div class="row">
        <div class="row">


            <div class="col-md-8">

            </div>
            <div class="row action-row">
                <div class="col-sm-2 col-sm-offset-10">
                    <div class="mail-sidebar-row">
                        <?php
                    $per=get_pre($_SESSION["userid"],8);
                    if($_SESSION["usertype"]==1 || $per==1 ||$_SESSION["usertype"]==2 ){?>

                        <a id="opener2" class="btn btn-success btn-icon btn-block btn-lg">
                            تعليمات جديدة
                            <i class="entypo-mail"></i>
                        </a>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-md-3" style=" margin-right: 4%;">

                <div id="dialog2" title="ارسال تعليمات " style="display:none">

                    <div class="mail-body">


                        <br>

                        <div class="mail-compose">

                            <form method="post" action="<?php echo $url.'users/sendMessage'?>">

                                <div class="form-group">
                                    <label class=" control-label" for="select1">الى:</label>
                                    <div class="" style="display: flex">
                                    </div>
                                    <input type="hidden" name="mtype" value="3">
                                    <input type="hidden" name="type" value="2" id="messto">
                                    <input type="hidden" name="mfrom" value=<?php echo $_SESSION['userid']?>"">
                                    <select name="mto[]" id="select1" class="select2 form-control sclient" multiple
                                        required>
                                        <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                                        <option value="<?php echo $users[$i]->ID?>">
                                            <?php echo $users[$i]->Name?>
                                        </option>
                                        <?php } }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subject">العنوان:</label>
                                    <input type="text" required name="title" class="form-control " tabindex="1" />
                                </div>
                                <div class="form-group">
                                    <label for="subject">الموضوع:</label>
                                    <input type="text" required name="content" class="form-control etextar2" id="subject"
                                        tabindex="1" />
                                </div>
                                <input type="submit" value="ارسال">
                            </form>

                        </div>

                    </div>

                </div>

            </div>


        </div>
    </div>

    <div class="col-md-12">
        <ul class="nav nav-tabs bordered">
            <!-- available classes "right-aligned" -->
            <li class="active"><a href="#v2-home" data-toggle="tab">المرسله</a></li>
            <li><a href="#v2-profile" data-toggle="tab">المستقبله</a></li>
            <!-- <li><a href="#v2-messages" data-toggle="tab">المسودات</a></li> -->
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="v2-home">
                <div class="mail-body">
                    <!-- mail table -->
                    <div class="tab-content">
                        <table class="table mail-table" id="myTable">
                            <!-- mail table header -->
                            <thead>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i> الكود
                                    </th>
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i> من
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i> الي:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i> العنوان:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i> الموضوع:
                                    </th>
                                </tr>
                            </thead>
                            <!-- email list -->
                            <tbody>
                                <?php
                                if(isset($meto))
                                {
                                    print_r($meto);
                                }
                                if(isset($sent)) {for($i=0;$i<count($sent);$i++){?>
                                <tr class="unread" data-toggle="modal">
                                    <!-- new email class: unread -->
                                    <td>
                                        <a href=<?php echo $url."users/message_details/3/".$sent[$i]->ID?>> <?php echo
                                            $sent[$i]->ID?></a>
                                    </td>
                                    <td class="col-name">
                                        <a class="col-name">
                                            <?php echo get_Emp_name($sent[$i]->From_User)?></a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php
                                                if($sent[$i]->To_User==0){

                                                    echo get_name($sent[$i]->Client_ID,2);
                                                }
                                                else
                                                {
                                                    echo get_Emp_name($sent[$i]->To_User);
                                                }
                                                ?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php echo $sent[$i]->Titel?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php echo $sent[$i]->Message?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm" mess="<?php echo $sent[$i]->ID?>">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <?php } }?>

                            </tbody>
                            <!-- mail table footer -->
                        </table>

                    </div>

                </div>
            </div>
            <div class="tab-pane" id="v2-profile">
                <div class="mail-body">
                    <!-- mail table -->
                    <div class="tab-content">
                        <table class="table mail-table" id="table_id2">
                            <!-- mail table header -->
                            <thead>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i> الكود
                                    </th>
                                    <th class="col-name size">
                                        <i class="fas fa-user" style="color:blue"></i> من
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i> الي:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i> العنوان:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i> الموضوع:
                                    </th>
                                </tr>
                            </thead>
                            <!-- email list -->
                            <tbody>
                                <?php if(isset($recieved)) { for($i=0;$i<count($recieved);$i++){?>
                                <tr class="unread" data-toggle="modal">
                                    <!-- new email class: unread -->
                                    <td>
                                        <a href=<?php echo $url."users/message_details/3/".$recieved[$i]->ID?>> <?php
                                            echo $recieved[$i]->ID?></a>
                                    </td>
                                    <td class="col-name">
                                        <a class="col-name">
                                            <?php echo get_Emp_name($recieved[$i]->From_User)?></a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php
                                                if($recieved[$i]->To_User==0){

                                                    echo get_name($recieved[$i]->Client_ID,2);
                                                }
                                                else
                                                {
                                                    echo get_Emp_name($recieved[$i]->To_User);
                                                }
                                                ?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php echo $recieved[$i]->Titel?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a>
                                            <?php echo $recieved[$i]->Message?>
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm" mess="<?php echo $recieved[$i]->ID?>">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                            <!-- mail table footer -->
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="v2-messages">
                <div class="mail-body">
                    <!-- mail table -->
                    <div class="tab-content">
                        <table class="table mail-table">
                            <!-- mail table header -->
                            <thead>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <th>
                                        <div>
                                        </div>
                                    </th>
                                    <th class="col-name size">
                                        <a href="%D8%AA%D9%81%D8%A7%D8%B5%D9%8A%D9%84_%D8%A7%D9%84%D8%A7%D9%8A%D9%85%D9%8A%D9%84.html"
                                            class="col-name" style="text-decoration: underline; color: #191fec"><i
                                                class="fas fa-user"></i> من:</a>
                                    </th>
                                    <th class="col-subject size">
                                        <a href="%D8%AA%D9%81%D8%A7%D8%B5%D9%8A%D9%84_%D8%A7%D9%84%D8%A7%D9%8A%D9%85%D9%8A%D9%84.html"
                                            style="text-decoration: underline; color: #191fec">
                                            <i class="fas fa-users"></i> الي:
                                        </a>
                                    </th>
                                    <th class="col-subject size">
                                        <a href="%D8%AA%D9%81%D8%A7%D8%B5%D9%8A%D9%84_%D8%A7%D9%84%D8%A7%D9%8A%D9%85%D9%8A%D9%84.html"
                                            style="text-decoration: underline; color: #191fec">
                                            <i class="fas fa-envelope"></i> العنوان:
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <!-- email list -->
                            <tbody>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">
                                        <a href="#" class="col-name">hosam</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            hosam
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            hosam
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>

                                </tr>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">
                                        <a href="#" class="col-name">ahmed</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            hussen
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">

                                        <a href="#" class="col-name">ahmed</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">
                                        <a href="#" class="col-name">ahmed</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">
                                        <a href="#" class="col-name">ahmed</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                                <tr class="unread">
                                    <!-- new email class: unread -->
                                    <td>
                                        <div class="checkbox checkbox-replace">
                                            <input type="checkbox" />
                                        </div>
                                    </td>
                                    <td class="col-name">
                                        <a href="#" class="col-name">ahmed</a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <a href="#">
                                            ahmed
                                        </a>
                                    </td>
                                    <td class="col-subject">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="entypo-trash"></i>مسح
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- mail table footer -->
                        </table>
                        <a href="%D8%A7%D9%84%D8%A7%D9%8A%D9%85%D9%8A%D9%84.html">
                            <div class="back">اعاده ارسال</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
</div>
</div>


<link rel="stylesheet" href="<?= $url ?>design/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">

<link rel="stylesheet" href="<?= $url ?>design/assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?= $url ?>design/assets/js/select2/select2.css">
<link rel="stylesheet" href="<?= $url ?>design/assets/js/selectboxit/jquery.selectBoxIt.css">

<!-- Bottom Scripts -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="<?= $url ?>design/assets/js/gsap/main-gsap.js"></script>
<script src="<?= $url ?>design/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?= $url ?>design/assets/js/bootstrap.js"></script>

<script src="<?= $url ?>design/assets/js/joinable.js"></script>
<script src="<?= $url ?>design/assets/js/resizeable.js"></script>
<script src="<?= $url ?>design/assets/js/neon-api.js"></script>
<script src="<?= $url ?>design/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= $url ?>design/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?= $url ?>design/assets/js/bootstrap-datepicker.js"></script>
<script src="<?= $url ?>design/assets/js/raphael-min.js"></script>
<script src="<?= $url ?>design/assets/js/morris.min.js"></script>
<script src="<?= $url ?>design/assets/js/select2/select2.min.js"></script>
<script src="<?= $url ?>design/assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.multi-select.js"></script>
<script src="<?= $url ?>design/assets/js/toastr.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.dataTables.min (2).js"></script>
<script src="<?= $url ?>design/assets/js/neon-custom.js"></script>
<script src="<?= $url ?>design/assets/js/neon-demo.js"></script>
<script src="<?= $url ?>design/assets/js/esScript.js"></script>
<script>
    $(".btn-sm").click(function () {
        debugger;
        var y = confirm("Are you Sure");
        if (y == true) {
            var status = $(this).attr("mess");
            var base = $("#base").val();
            var element = $(this);
            $.ajax({
                type: "POST",
                url: base + "users/delmess",
                data: ({
                    messid: status
                }),
                success: function (data) {

                    toastr.success("تم المسح  بنجاح");
                    $(element).parent().parent().remove();

                }
            });
        }
    });
</script>

</body>

</html>