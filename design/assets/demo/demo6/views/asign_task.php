<?php $this->load->view("header"); ?>

<div class="contains" xmlns="">
    <br />

    <div class="row">
        <div class="col-sm-12">


            <div class="es-radio">
                <p>تعيين الى:</p>
                <?php if(isset($admin)){?>
                    <input type="radio" name="optradio" class="radio-inline" id="radio1">
                    <select id="sel1" class="esradio" name="newsuper">
                        <option value="" selected disabled>المشرفين</option>
                        <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                            <option value="<?php echo $supers[$i]->userCrmId?>"><?php echo $supers[$i]->userCrmName?></option>
                        <?php } }?>

                    </select>
                <?php }?>

                <input type="radio" name="optradio" class="radio-inline" id="radio2" >
                <select id="sel2" name="newemp">
                    <option value="" selected disabled>الموظفين</option>

                    <?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){?>
                        <option value="<?php echo $emps[$i]->userCrmId?>"><?php echo $emps[$i]->userCrmName?></option>
                    <?php } }?>
                </select>
                <INPUT type="button" value="تعين" class="btn btn-black btn-lg" id="button11" />

                <INPUT type="button" value="حذف  عميل" class="btn btn-black btn-lg" id="deleteData" />
            </div>

            <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($reset)?>">


            <table id="myTable" class="table table-striped display data-table">
                <thead>
                <div align="left">
                    <input type="number" min="1" max="<?php echo count($reset)?>"" value="10" class="placeholder" id="Data-Length" >
                    <INPUT type="button" value="عرض" class="btn btn-black btn-lg page-size" id="button11" />

                </div>


                <tr>
                    <th><input type="checkbox" value="" id="flowcheckall" class="chk"></th>

                    <th>الاسم</th>
                    <th>التليفون</th>
                    <th>الشركة</th>
                    <th>الوظيفة</th>
                    <th> تاريخ رفع البيانات  </th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i=0; $i < count($reset); $i++) {
                    ?>
                    <tr>
                        <td><input type="checkbox"   class="checkboxMy  <?php echo 'chk elem'.$i?>">
                            <input type="hidden" class="dataID <?php echo 'custid'.$i?>" value="<?php echo $reset[$i]->customerCrmId?>">
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo $reset[$i]->customerCrmName?>"><?php echo $reset[$i]->customerCrmName?></td>
                        <td><?php echo $reset[$i]->customerCrmPhone?></td>
                        <td><?php echo $reset[$i]->customerCrmCompany?></td>
                        <td><?php echo $reset[$i]->customerCrmJob?></td>
                        <td><?php echo date("Y-m-d",strtotime($reset[$i]->customerCrmCreateDate))?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        </div>
        <div class="col-sm-8" hidden>

            <div class="panel panel-primary" id="charts_env">

                <div class="panel-heading">
                    <div class="panel-title">Site Stats</div>

                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li class=""><a href="#area-chart" data-toggle="tab">Area Chart</a></li>
                            <li class="active"><a href="#line-chart" data-toggle="tab">Line Charts</a></li>
                            <li class=""><a href="#pie-chart" data-toggle="tab">Pie Chart</a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="tab-content">

                        <div class="tab-pane" id="area-chart">
                            <div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
                        </div>

                        <div class="tab-pane active" id="line-chart">
                            <div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
                        </div>

                        <div class="tab-pane" id="pie-chart">
                            <div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
                        </div>

                    </div>

                </div>

                <table class="table table-bordered table-responsive">

                    <thead>
                    <tr>
                        <th width="50%" class="col-padding-1">
                            <div class="pull-left">
                                <div class="h4 no-margin">Pageviews</div>
                                <small>54,127</small>
                            </div>
                            <span class="pull-right pageviews">4,3,5,4,5,6,5</span>

                        </th>
                        <th width="50%" class="col-padding-1">
                            <div class="pull-left">
                                <div class="h4 no-margin">Unique Visitors</div>
                                <small>25,127</small>
                            </div>
                            <span class="pull-right uniquevisitors">2,3,5,4,3,4,5</span>
                        </th>
                    </tr>
                    </thead>

                </table>

            </div>

        </div>

        <div class="col-sm-4" hidden>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4>
                            Real Time Stats
                            <br />
                            <small>current server uptime</small>
                        </h4>
                    </div>

                    <div class="panel-options">
                        <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                    </div>
                </div>

                <div class="panel-body no-padding">
                    <div id="rickshaw-chart-demo">
                        <div id="rickshaw-legend"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <br />



    <script type="text/javascript">
        // Code used to add Todo Tasks
        jQuery(document).ready(function($)
        {

            $("#flowcheckall").click(function () {
                $('.table tbody input[type="checkbox"]').prop('checked', this.checked);

            });
            var $todo_tasks = $("#todo_tasks");

            $todo_tasks.find('input[type="text"]').on('keydown', function(ev)
            {
                if(ev.keyCode == 13)
                {
                    ev.preventDefault();

                    if($.trim($(this).val()).length)
                    {
                        var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
                        $(this).val('');

                        $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                        $todo_entry.hide().slideDown('fast');
                        replaceCheckboxes();
                    }
                }
            });

            $('#myTable').DataTable(
                {
                    responsive:true,
                    ordering:false,
                    "paging": true,
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]]
                }
            );
            $(".page-size").click(function () {
                var size = document.getElementById('Data-Length').value;
                $('#myTable').DataTable().page.len(size).draw();


            });




        });
    </script>


    <!-- Footer -->
</div>


<div id="chat" class="fixed" data-current-user="Art Ramadani" data-order-by-status="1" data-max-chat-history="25">

    <div class="chat-inner">


        <h2 class="chat-header">
            <a href="#" class="chat-close" data-animate="1"><i class="entypo-cancel"></i></a>

            <i class="entypo-users"></i>
            Chat
            <span class="badge badge-success is-hidden">0</span>
        </h2>


        <div class="chat-group" id="group-1">
            <strong>Favorites</strong>

            <a href="#" id="sample-user-123" data-conversation-history="#sample_history"><span class="user-status is-online"></span> <em>Catherine J. Watkins</em></a>
            <a href="#"><span class="user-status is-online"></span> <em>Nicholas R. Walker</em></a>
            <a href="#"><span class="user-status is-busy"></span> <em>Susan J. Best</em></a>
            <a href="#"><span class="user-status is-offline"></span> <em>Brandon S. Young</em></a>
            <a href="#"><span class="user-status is-idle"></span> <em>Fernando G. Olson</em></a>
        </div>


        <div class="chat-group" id="group-2">
            <strong>Work</strong>

            <a href="#"><span class="user-status is-offline"></span> <em>Robert J. Garcia</em></a>
            <a href="#" data-conversation-history="#sample_history_2"><span class="user-status is-offline"></span> <em>Daniel A. Pena</em></a>
            <a href="#"><span class="user-status is-busy"></span> <em>Rodrigo E. Lozano</em></a>
        </div>


        <div class="chat-group" id="group-3">
            <strong>Social</strong>

            <a href="#"><span class="user-status is-busy"></span> <em>Velma G. Pearson</em></a>
            <a href="#"><span class="user-status is-offline"></span> <em>Margaret R. Dedmon</em></a>
            <a href="#"><span class="user-status is-online"></span> <em>Kathleen M. Canales</em></a>
            <a href="#"><span class="user-status is-offline"></span> <em>Tracy J. Rodriguez</em></a>
        </div>

    </div>

    <!-- conversation template -->
    <div class="chat-conversation">

        <div class="conversation-header">
            <a href="#" class="conversation-close"><i class="entypo-cancel"></i></a>

            <span class="user-status"></span>
            <span class="display-name"></span>
            <small></small>
        </div>

        <ul class="conversation-body">
        </ul>

        <div class="chat-textarea">
            <textarea class="form-control autogrow" placeholder="Type your message"></textarea>
        </div>

    </div>

</div>


<!-- Chat Histories -->
<ul class="chat-history" id="sample_history">
    <li>
        <span class="user">Art Ramadani</span>
        <p>Are you here?</p>
        <span class="time">09:00</span>
    </li>

    <li class="opponent">
        <span class="user">Catherine J. Watkins</span>
        <p>This message is pre-queued.</p>
        <span class="time">09:25</span>
    </li>

    <li class="opponent">
        <span class="user">Catherine J. Watkins</span>
        <p>Whohoo!</p>
        <span class="time">09:26</span>
    </li>

    <li class="opponent unread">
        <span class="user">Catherine J. Watkins</span>
        <p>Do you like it?</p>
        <span class="time">09:27</span>
    </li>
</ul>




<!-- Chat Histories -->
<ul class="chat-history" id="sample_history_2">
    <li class="opponent unread">
        <span class="user">Daniel A. Pena</span>
        <p>I am going out.</p>
        <span class="time">08:21</span>
    </li>

    <li class="opponent unread">
        <span class="user">Daniel A. Pena</span>
        <p>Call me when you see this message.</p>
        <span class="time">08:27</span>
    </li>
</ul>
</div>



<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

<!-- Bottom Scripts -->
<script src="assets/js/gsap/main-gsap.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="assets/js/rickshaw/rickshaw.min.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>

<script>
    $(document).ready(function(){
        $( "#sel1" ).prop( "disabled", true );
        $( "#sel2" ).prop( "disabled", true );
        $("#radio1").click(function () {
            $('#sel2').prop('selectedIndex',0);
            $( "#sel2" ).prop( "disabled", true );
            $( "#sel1" ).prop( "disabled", false );

        });
        $("#radio2").click(function () {
            $('#sel1').prop('selectedIndex',0);

            $( "#sel1" ).prop( "disabled", true );
            $( "#sel2" ).prop( "disabled", false );

        });
    });

    $("#button11").click(function(){

        var base=$("#base").val();
        var resetcount=$("#resestcount").val();
        var supervisor,emp;
        if($("#sel1").val()!=null || $("#sel2").val()!=null)
        {
            if($("#sel1").val()!=null)
            {
                supervisor=$("#sel1").val();
                emp=$("#sel1").val();
            }
            else if($("#sel2").val()!=null)
            {
                emp=$("#sel2").val();
                supervisor=0;
            }
            var result = false;
            var customerid='';
            for(var i=0;i<resetcount;i++)
            {
                var check=true;
                if($('.elem'+i).is(":checked")){
                    // send customers IDs As Array
                    customerid +=$('.custid'+i).val() + ',';
                }
            }
            $.ajax({
                type: "GET",
                url: base + "users/asgin_user",
                data: ({
                    customerid:customerid,
                    super:supervisor,
                    emp:emp
                }),
                success: function (data) {
                    if(check==true)
                    {
                        window.location.href = base + "users/task_view"
                        alert("تم تعين المهام بنجاح");
                        check=false;
                    }
                }
            });

        }
    });

    $("#deleteData").click(function(){
        let conf = confirm("هل انت متاكد من عملية الحذف");
        if (conf){
        var base=$("#base").val();
        var resetcount=$("#resestcount").val();
        var supervisor,emp;

        var data = [];

        $('input:checkbox.checkboxMy:checked').each(function () {
            data.push( $(this).parents("tr").find(".dataID").val() );
        });

        $.ajax({
            type: "POST",
            url: base + "users/deleteData",
            data:({customer:data}) ,
            success: function (data) {
                if(data=="1"){
                    window.location.href = base + "users/task_view"
                    alert("تم حذف جميع البيانات ");
                }else{
                    alert("حدث خطا اثناء الحذف , حاول مره اخري.");
                }
            }
        });
        }
    });


</script>

</body>
</html>