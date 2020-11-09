<?php $this->load->view("header");?>

<div class="contains">



    <br />

    <!--mail-body       -->

    <div class="row">
        <div class="row">

            <div class="col-md-8">
                <div class="mail-header">

                </div>
            </div>

            <div class="col-md-3" style=" margin-right: 4%;">
                <div class="mail-sidebar-row">
                    <a id="opener2" class="btn btn-success btn-icon btn-block ">
                        ارسال رساله جديد
                        <i class="entypo-mail"></i>
                    </a>
                    <div id="dialog2" title="ارسال رساله " style="display:none;">

                        <div class="mail-body">


                            <br>

                            <div class="mail-compose">
                                <form method="post"action="<?php echo $url.'users/sendMessage'?>">

                                    <div class="form-group" >
                                        <label class=" control-label" for="select1">الى:</label>
                                        <div class="" style="display: flex">
                                        </div>
                                        <input type="hidden" name="mtype" value="1">
                                        <input type="hidden" name="type" value="1" id="messto">
                                        <input type="hidden" name="mfrom" value=<?php echo $_SESSION['userid']?>"">
                                        <select name="mto[]" id="select1" class="select2 form-control sclient" multiple  required>
                                            <?php if(isset($users)) { for($i=0;$i<count($users);$i++){?>
                                                <option  value="<?php echo $users[$i]->userCrmId?>" ><?php echo $users[$i]->userCrmName?></option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">العنوان:</label>
                                        <input type="text" required name="title" class="form-control "  tabindex="1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">الموضوع:</label>
                                        <input type="text" required name="content" class="form-control etextar2" id="subject" tabindex="1" />
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

                                        <i class="fas fa-user" style="color:blue"></i>   الكود
                                    </th>
                                    <th class="col-name size">

                                        <i class="fas fa-user" style="color:blue"></i>   من
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i>   الي:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    العنوان:
                                    </th>

                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الموضوع:
                                    </th>
                                    <th class="col-subject size">
                                        تاريخ الارسال
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
                                if(isset($sent)){for($i=0;$i<count($sent);$i++){?>
                                    <tr class="unread" data-toggle="modal" ><!-- new email class: unread -->
                                        <td>
                                            <a href=<?php echo $url."users/message_details/1/".$sent[$i]->ID?>><?php  echo $sent[$i]->ID?></a>
                                        </td>
                                        <td class="col-name">
                                            <a  class="col-name"><?php echo get_name($sent[$i]->From_User,1)?></a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php
                                                if($sent[$i]->To_User==0){

                                                    echo get_name($sent[$i]->To_User,2);
                                                }
                                                else
                                                {
                                                    echo get_name($sent[$i]->To_User,1);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php echo $sent[$i]->Titel?>
                                            </a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php echo $sent[$i]->Message?>
                                            </a>
                                        </td>

                                        <td class="col-subject">
                                            <a >
                                                <?php echo $sent[$i]->Send_Date	?>
                                            </a>
                                        </td>

                                        <td class="col-subject">
                                            <button class="btn btn-danger btn-sm" mess="<?php echo $sent[$i]->ID?>">
                                                <i class="entypo-trash"></i>مسح</button>
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

                                        <i class="fas fa-user" style="color:blue"></i>   الكود
                                    </th>
                                    <th class="col-name size">

                                        <i class="fas fa-user" style="color:blue"></i>   من
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-users" style="color:blue"></i>   الي:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    العنوان:
                                    </th>
                                    <th class="col-subject size">
                                        <i class="fas fa-envelope" style="color:blue"></i>    الموضوع:
                                    </th>

                                    <th class="col-subject size">
                                        تاريخ الارسال
                                    </th>
                                </tr>
                                </thead>

                                <!-- email list -->

                                <tbody>
                                <?php if(isset($recieved)){ for($i=0;$i<count($recieved);$i++){?>
                                    <tr class="unread" data-toggle="modal"><!-- new email class: unread -->
                                        <td>
                                            <a href=<?php echo $url."users/message_details/1/".$recieved[$i]->ID?>><?php  echo $recieved[$i]->ID?></a>

                                        </td>

                                        <td class="col-name">

                                            <a  class="col-name"><?php echo get_name($recieved[$i]->From_User,1)?></a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php
                                                if($recieved[$i]->To_User==0){

                                                    echo get_name($recieved[$i]->To_User,2);
                                                }
                                                else
                                                {
                                                    echo get_name($recieved[$i]->To_User,1);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php echo $recieved[$i]->Titel?>
                                            </a>
                                        </td>
                                        <td class="col-subject">
                                            <a >
                                                <?php echo $recieved[$i]->Message?>
                                            </a>
                                        </td>

                                        <td class="col-subject">
                                            <a >
                                                <?php echo $recieved[$i]->Send_Date	?>
                                            </a>
                                        </td>

                                        <td class="col-subject">
                                            <button class="btn btn-danger btn-sm" mess="<?php echo $recieved[$i]->ID?>"><i class="entypo-trash"></i>مسح </button>
                                        </td>

                                    </tr>
                                <?php } }?>





                                </tbody>
                                <!-- mail table footer -->

                            </table>
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
<script src="<?= $url ?>/design/assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.multi-select.js"></script>
<script src="<?= $url ?>design/assets/js/toastr.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.dataTables.min (2).js"></script>
<script src="<?= $url ?>design/assets/js/neon-custom.js"></script>
<script src="<?= $url ?>design/assets/js/neon-demo.js"></script>
<script>
    $(".btn-sm").click(function(){
        // debugger;
        var y= confirm("Are you Sure");
        if(y==true)
        {
            var status=$(this).attr("mess");
            var base=$("#base").val();
            var element=$(this);
            $.ajax({
                type: "POST",
                url: base+"users/delmess",
                data: ({messid:status
                }),
                success: function(data) {

                    toastr.success("تم المسح  بنجاح");
                    $(element).parent().parent().remove();

                }
            });
        }
    });
    $('input[type=radio][name=optionsRadios]').change(function() {
        var type=2;
        if (this.value == 'option2') {
            var type=2;
        }
        else if (this.value == 'option3') {
            var type=3;
        }
        var base=$("#base").val();
        var element=$(this);
        $.ajax({
            type: "POST",
            url: base+"users/get_empsuper",
            data: ({type:type
            }),
            success: function(data) {
                $('#select1').find('option').remove();

                var products =  $.parseJSON(data);
                for (var index = 0; index < products.length; index++) {
                    if(type==1)
                    {
                        $("#messto").val(1);
                        $('#select1').append($('<option>', {
                            value: products[index].customerCrmId,
                            text : products[index].customerCrmName
                        }));
                    }
                    else
                    {
                        $("#messto").val(2);

                        $('#select1').append($('<option>', {
                            value: products[index].userCrmId,
                            text : products[index].userCrmName
                        }));
                    }
                }

            }
        });
    });





    $(document).on("click", "#send-message", function () {
        var uName=$("#user-mail").val();
        var uPass=$("#user-password").val();
        var portNo=$("#port-number").val();
        var mailServer=$("#mail-server").val();

        var data = new FormData();
        data.append('uName', uName);
        data.append('uPass', uPass);
        data.append('portNo', portNo);
        data.append('mailServer', mailServer);
        $.ajax({
            type: 'post',
            processData: false, // important
            contentType: false, // important
            datatype:"json",
            url: "<?=$url?>users/update_mail_settings",
            data: data,
            success: function(doc) {
                var Dataarray = $.parseJSON(doc);
                if (Dataarray['error'] == false) {
                    toastr.success(Dataarray['msg']);
                }else{
                    toastr.error(Dataarray['msg']);
                }
            }
        });
    });

</script>


</body>

</html>