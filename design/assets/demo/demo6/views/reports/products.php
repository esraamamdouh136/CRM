<?php $this->load->view("header") ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:10%; margin-left:4%;">

<!-- BEGIN: Subheader -->


<!-- END: Subheader -->

<div class="m-content">

    <!--Date And Time-->
    <div class="container" style="margin-right:4%;">
        
         <?php $this->load->view("Admin/DateTimeDiv"); ?>
          

    </div>
    <!--Date And Time-->
    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
               
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table
                                class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline my_table"
                                id="example" role="grid" aria-describedby="m_table_1_info"
                                style="width: 974px;">
                                <thead>

                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 63.25px;"
                                            aria-label="Order ID: activate to sort column ascending">
                                            الاسم</th>
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 65.25px;"
                                            aria-label="Country: activate to sort column ascending">كميه
                                            المباعه</th>





                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($reportData)){  for($i=0;$i<count($reportData);$i++){?>
                            <tr>
                                <td><?php echo $reportData[$i]->PName?> </td>
                                <td><?php echo $reportData[$i]->PCount?></td>
                            </tr>
                        <?php } }?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="container">
                        <div class="col-lg-8 mx-auto mt-5">
                            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                              
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                            نسبة المبيعات
                                            </h3>
                                           
                                    </div>
                                </div>
                            </div>
                            <div class="attend-chart"  style="height: 300px;cursor:pointer;">
            <div id="chart"></div>
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



<!-- Bottom Scripts -->

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.dataTables.min (2).js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="<?= $url ?>design/assets/C3Charts/c3.js"></script>
<script src="<?= $url ?>design/assets/C3Charts/d3.v5.min.js"></script>
<script src="<?= $url ?>design/assets/C3Charts/canvas2image.js"></script>
<script src="<?= $url ?>design/assets/C3Charts/html2canvas.js"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>



<script>
    var columns =[];
    <?php
    if (isset($reportData)){
    for ($i=0;$i<count($reportData);$i++){?>
    columns[<?php echo $i ?>] = ["<?php echo $reportData[$i]->PName ?>",<?php echo $reportData[$i]->PCount ?>];
    <?php }
    }
    ?>

    c3.generate({
        bindto: '#chart',
        data: {
            columns: columns,
            type : 'pie'

        }
		
    });



    jQuery(document).ready(function ($) {
        var Topmsg = "<center>";
        Topmsg += "<h1>تقرير المنتجات</h1>";
        Topmsg += "من تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date1)); ?>";
        Topmsg += " إلى تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date2)); ?>";
        Topmsg += "<center>";
        Topmsg += "<br>";
        var chartDiv = $("#chart").html();
      
        $('.my_table').DataTable( {
            "paging": true,
            "pagingType": "full_numbers",
            "info": false,
            "responsive": true,
            dom: 'Bfrtip',
            stripHtml: true,
            buttons: [{
                className: 'buttons-print',
                extend: 'print',
                text: 'طباعة',
                footer: 'true',
                header :"true",
                orientation: 'portrait',
                title: "",
                messageTop:Topmsg,
                messageBottom:chartDiv
            }]
        } );
     
});

  


    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

    }
    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/products/" + DateRange;
    });

</script>

</body>

</html>