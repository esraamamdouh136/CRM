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
                            <div class="chartParent m-portlet m-portlet--mobile m-portlet--body-progress- border">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text col-lg-12">
                                                نسبة المبيعات
                                                (<?=isset($totalCount)?$totalCount:0?>)
                                            </h3>



                                <div class="btn-group dropDown col-lg-12 ml-5">
                                                <button type="button " class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    تغير الرسم البيانى
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item Change_Chart1 bg"><i class="flaticon-pie-chart"></i> رسم بيانى (1) </button>
                                                    <button class="dropdown-item Change_Chart2"><i class="flaticon flaticon-graph"></i>رسم بيانى (2)</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chartDiv c3" id="myPieChart" width="200" height="150" style="max-height: 320px; position: relative;"><svg width="538" height="320" style="overflow: hidden;"><defs><clipPath id="c3-1569854885590-clip"><rect width="538" height="296"></rect></clipPath><clipPath id="c3-1569854885590-clip-xaxis"><rect x="-31" y="-20" width="600" height="40"></rect></clipPath><clipPath id="c3-1569854885590-clip-yaxis"><rect x="-29" y="-4" width="20" height="320"></rect></clipPath><clipPath id="c3-1569854885590-clip-grid"><rect width="538" height="296"></rect></clipPath><clipPath id="c3-1569854885590-clip-subchart"><rect width="538"></rect></clipPath></defs><g transform="translate(0.5,4.5)"><text class="c3-text c3-empty" text-anchor="middle" dominant-baseline="middle" x="269" y="148" style="opacity: 0;"></text><rect class="c3-zoom-rect" width="538" height="296" style="opacity: 0;"></rect><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip)" class="c3-regions" style="visibility: hidden;"></g><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-grid)" class="c3-grid" style="visibility: hidden;"><g class="c3-xgrid-focus"><line class="c3-xgrid-focus" x1="-10" x2="-10" y1="0" y2="296" style="visibility: hidden;"></line></g></g><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip)" class="c3-chart"><g class="c3-event-rects c3-event-rects-single" style="fill-opacity: 0;"><rect class=" c3-event-rect c3-event-rect-0" x="0" y="0" width="538" height="296"></rect></g><g class="c3-chart-bars"><g class="c3-chart-bar c3-target c3-target-المتركمة" style="pointer-events: none;"><g class=" c3-shapes c3-shapes-المتركمة c3-bars c3-bars-المتركمة" style="cursor: pointer;"></g></g><g class="c3-chart-bar c3-target c3-target-الجديدة" style="pointer-events: none;"><g class=" c3-shapes c3-shapes-الجديدة c3-bars c3-bars-الجديدة" style="cursor: pointer;"></g></g></g><g class="c3-chart-lines"><g class="c3-chart-line c3-target c3-target-المتركمة" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-المتركمة c3-lines c3-lines-المتركمة"></g><g class=" c3-shapes c3-shapes-المتركمة c3-areas c3-areas-المتركمة"></g><g class=" c3-selected-circles c3-selected-circles-المتركمة"></g><g class=" c3-shapes c3-shapes-المتركمة c3-circles c3-circles-المتركمة" style="cursor: pointer;"></g></g><g class="c3-chart-line c3-target c3-target-الجديدة" style="opacity: 1; pointer-events: none;"><g class=" c3-shapes c3-shapes-الجديدة c3-lines c3-lines-الجديدة"></g><g class=" c3-shapes c3-shapes-الجديدة c3-areas c3-areas-الجديدة"></g><g class=" c3-selected-circles c3-selected-circles-الجديدة"></g><g class=" c3-shapes c3-shapes-الجديدة c3-circles c3-circles-الجديدة" style="cursor: pointer;"></g></g></g><g class="c3-chart-arcs" transform="translate(269,143)"><text class="c3-chart-arcs-title" style="text-anchor: middle; opacity: 0;"></text><g class="c3-chart-arc c3-target c3-target-المتركمة"><g class=" c3-shapes c3-shapes-المتركمة c3-arcs c3-arcs-المتركمة"><path class=" c3-shape c3-shape c3-arc c3-arc-المتركمة" transform="" style="fill: rgb(31, 119, 180); cursor: pointer;" d="M0,135.85A135.85,135.85 0 1,1 0,-135.85A135.85,135.85 0 1,1 0,135.85Z"></path></g><text dy=".35em" style="opacity: 1; text-anchor: middle; pointer-events: none;" class="" transform="translate(6.654730706566717e-15,108.68)">100.0%</text></g><g class="c3-chart-arc c3-target c3-target-الجديدة"><g class=" c3-shapes c3-shapes-الجديدة c3-arcs c3-arcs-الجديدة"><path class=" c3-shape c3-shape c3-arc c3-arc-الجديدة" transform="" style="fill: rgb(255, 127, 14); cursor: pointer;" d="M-2.4955240149625186e-14,-135.85A135.85,135.85 0 0,1 -2.4955240149625186e-14,-135.85L0,0Z"></path></g><text dy=".35em" style="opacity: 1; text-anchor: middle; pointer-events: none;" class="" transform="translate(-1.996419211970015e-14,-108.68)"></text></g></g><g class="c3-chart-texts"><g class="c3-chart-text c3-target c3-target-المتركمة" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-المتركمة"></g></g><g class="c3-chart-text c3-target c3-target-الجديدة" style="opacity: 1; pointer-events: none;"><g class=" c3-texts c3-texts-الجديدة"></g></g></g></g><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-grid)" class="c3-grid c3-grid-lines"><g class="c3-xgrid-lines"></g><g class="c3-ygrid-lines"></g></g><g class="c3-axis c3-axis-x" clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-xaxis)" transform="translate(0,296)" style="visibility: visible; opacity: 0;"><text class="c3-axis-x-label" transform="" style="text-anchor: end;" x="538" dx="-0.5em" dy="-0.5em"></text><g class="tick" style="opacity: 1;" transform="translate(269, 0)"><line x1="0" x2="0" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">0</tspan></text></g><path class="domain" d="M0,6V0H538V6"></path></g><g class="c3-axis c3-axis-y" clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-yaxis)" transform="translate(0,0)" style="visibility: visible; opacity: 0;"><text class="c3-axis-y-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="1.2em"></text><g class="tick" style="opacity: 1;" transform="translate(0,272)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">0</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,234)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">100</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,195)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">200</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,157)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">300</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,118)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">400</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,80)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">500</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,41)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">600</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,3)"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">700</tspan></text></g><path class="domain" d="M-6,1H0V296H-6"></path></g><g class="c3-axis c3-axis-y2" transform="translate(538,0)" style="visibility: hidden; opacity: 0;"><text class="c3-axis-y2-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="-0.5em"></text><g class="tick" style="opacity: 1;" transform="translate(0,296)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,267)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.1</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,237)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.2</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,208)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.3</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,178)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.4</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,149)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.5</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,119)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.6</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,90)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.7</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,60)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.8</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,31)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.9</tspan></text></g><g class="tick" style="opacity: 1;" transform="translate(0,1)"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">1</tspan></text></g><path class="domain" d="M6,1H0V296H6"></path></g></g><g transform="translate(0.5,320.5)" style="visibility: hidden;"><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-subchart)" class="c3-chart"><g class="c3-chart-bars"></g><g class="c3-chart-lines"></g></g><g clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip)" class="c3-brush" style="pointer-events: all; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><rect class="background" x="0" width="538" style="visibility: hidden; cursor: crosshair;"></rect><rect class="extent" x="0" width="0" style="cursor: move;"></rect><g class="resize e" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g><g class="resize w" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g></g><g class="c3-axis-x" transform="translate(0,0)" clip-path="url(http://localhost/crm/CRM_Users/index/2018-09-30@2019-09-30#c3-1569854885590-clip-xaxis)" style="visibility: hidden; opacity: 0;"><g class="tick" style="opacity: 1;" transform="translate(269, 0)"><line x1="0" x2="0" y2="6"></line><text x="0" y="9" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">0</tspan></text></g><path class="domain" d="M0,6V0H538V6"></path></g></g><g transform="translate(0,300)"><g class="c3-legend-item c3-legend-item-المتركمة" style="visibility: visible; cursor: pointer;"><text x="231.8828125" y="9" style="pointer-events: none;">المتركمة</text><rect class="c3-legend-item-event" x="217.8828125" y="-5" width="59.53125" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="215.8828125" y1="4" x2="225.8828125" y2="4" stroke-width="10" style="stroke: rgb(31, 119, 180); pointer-events: none;"></line></g><g class="c3-legend-item c3-legend-item-الجديدة" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="291.4140625" y="9" style="pointer-events: none;">الجديدة</text><rect class="c3-legend-item-event" x="277.4140625" y="-5" width="42.703125" height="18" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" x1="275.4140625" y1="4" x2="285.4140625" y2="4" stroke-width="10" style="stroke: rgb(255, 127, 14); pointer-events: none;"></line></g></g><text class="c3-title" x="269" y="0"></text></svg><div class="c3-tooltip-container" style="position: absolute; pointer-events: none; display: none; top: 253.266px; left: 245.953px;"><table class="c3-tooltip"><tbody><tr class="c3-tooltip-name--المتركمة"><td class="name"><span style="background-color:#1f77b4"></span>المتركمة</td><td class="value">100.0%</td></tr></tbody></table></div></div>
                            </div>                    </div>
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
    <script src="assets/js/d3.min.js"></script>
    <script src="assets/js/c3.js"></script>
    <script src="vendors/chart.js/dist/myChart.js" type="text/javascript"></script>

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

    chartGeneral('pie', 'myPieChart',columns);



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