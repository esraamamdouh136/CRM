<?php $this->load->view("header") ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-right:9%; margin-left:3%; margin-top:1%; margin-bottom:14%;">
<div class="m-content">

    <!--Date And Time-->
    <div class="container">
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
                                <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="example" role="grid" aria-describedby="m_table_1_info" style="width: 974px;">
                                    <thead>

                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 63.25px;" aria-label="Order ID: activate to sort column ascending">
                                                الاسم</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 65.25px;" aria-label="Country: activate to sort column ascending">الرسائل النصيه</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 100.25px;" aria-label="Ship Address: activate to sort column ascending">البريد الالكترونى
</th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">التبيهات المستلمه</th>
                                                <th class="sorting" tabindex="0" aria-controls="m_table_1" rowspan="1" colspan="1" style="width: 82.25px;" aria-label="Company Agent: activate to sort column ascending">متوسط مده المكالمه</th>
                                                
                                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($reportData)){ for($i=0;$i<count($reportData);$i++){?>
                            <tr>
                                <td>
                                    <?php echo $reportData[$i]->Name?>

                                </td>

                                <td>
                                    <?php echo $reportData[$i]->SMSCount?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->EMailCount?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->notificationsCount?>
                                </td>
                                <td>
                                    <?php echo ($reportData[$i]->CallAVG/60)." دقيقة "?>
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


<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>

<script>

$(document).ready(function () {
        $('#example').DataTable({
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
        })
    });




    jQuery(document).ready(function ($) {
        var title= 'تقرير المكالمات';

        var Topmsg = "<center>";
        Topmsg += "<h1>"+title+"</h1>";
        Topmsg += "من تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date1)); ?>";
        Topmsg += " إلى تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date2)); ?>";
        Topmsg += "<center>";
        Topmsg += "<br>";

        $('.my_table').DataTable({
            "paging": true,
            "pagingType": "full_numbers",
            "info": true,
            "responsive": true,
            dom: 'Bfrtip',
            buttons: [
                {
                    className: 'buttons-print',
                    extend: 'print',
                    text: 'طباعة',
                    footer: 'true',
                    header :"true",
                    orientation: 'landscape',
                    title: "",
                    messageTop:Topmsg,

                    customize: function (win) {

                        // $(win.document.body).find('table').border('10px solid black');
                    }

                }

            ]
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#myTable:visible').each(function (e) {
                //   alert('visible ' + $(this).attr('id'));
                $(this).DataTable().columns.adjust().responsive.recalc();
            });
        });
        $('table.table input[type=checkbox]').click(function () {
            $(this).closest('tr').toggleClass("highlight", this.checked);
        });


    });
</script>

<script>
    $(document).on("click", "#searchButton", function () {
        var DateRange = $("#FromDate").val() + "@" + $("#ToDate").val();
        window.location.href = "<?= $url ?>reports/Calls/" + DateRange;
    });
</script>

</body>

</html>