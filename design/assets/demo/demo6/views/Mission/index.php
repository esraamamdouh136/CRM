<?php $this->load->view("header");?>

<div class="contains">
    <div class="row">
        <div class="escharge">
            <div class="row action-row">
                <div class="col-sm-4">
                    <img src="assets/images/calls.png" class="esrotate" />
                    <p>المكالمات</p>
                    <p><?php echo isset($total)?$total:0?></p>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/done.png" class="esrotate" />
                    <p>تمت</p>
                    <p><?= isset($Completed)?$Completed:0 ?></p>
                </div>
                <div class="col-sm-4">
                    <img src="assets/images/rest.png" class="esrotate" />
                    <p>المتبقية</p>
                    <p><?= isset($remainder)?$remainder:0?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <table id="myTable" class="table table-striped display data-table">
            <thead>
            <tr>
                <th>الاسم</th>
                <th>التليفون</th>
                <th>الايميل</th>
                <th>الشركة</th>
                <th>الوظيفة</th>
            </tr>
            </thead>
            <input type="hidden" class="cliecount" value="<?= isset($clients) ? count($clients) : "0" ?>">
            <tbody>
            <?php if(isset($clients)){ for($i=0;$i< count($clients);$i++){?>
                <tr class='clickable-row' style="cursor: pointer;" data-href= <?=$clients[$i]->customerCrmId?>>
                    <th><?php echo $clients[$i]->customerCrmName?></th>
                    <th><?php echo $clients[$i]->customerCrmPhone?></th>
                    <th><?php echo $clients[$i]->customerCrmEmail?></th>
                    <th><?php echo $clients[$i]->customerCrmCompany?></th>
                    <th><?php echo $clients[$i]->customerCrmJob?></th>
                </tr>
            <?php } }?>
            </tbody>
        </table>
    </div>




</div>


<br />






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
<script>
    var url=$("#base").val();
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            var ClientID = $(this).data("href");
            window.location=url+"Client/index/" +ClientID ;
        });
    });

</script>
</body>

</html>