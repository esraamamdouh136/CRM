<?php $this->load->view("header") ?>


<div class="m-grid__item m-grid__item--fluid m-wrapper" style="margin-left:3%; margin-bottom:13%; margin-right:10%;">

<!-- BEGIN: Subheader -->


<!-- END: Subheader -->

<div class="m-content">

    <!--Date And Time-->
    <div class="container ml-5">
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
                                id="myTable" role="grid" aria-describedby="m_table_1_info"
                                style="width: 974px;">
                                <thead>

                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 63.25px;"
                                            aria-label="Order ID: activate to sort column ascending">
                                            الاسم</th>
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 65.25px;"
                                            aria-label="Country: activate to sort column ascending">
                                            اجمالى عدد المكالمات</th>
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 100.25px;"
                                            aria-label="Ship Address: activate to sort column ascending">
                                            لم يتم الرد </th>
                                        <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 82.25px;"
                                            aria-label="Company Agent: activate to sort column ascending">
                                            متابعات </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 82.25px;"
                                            aria-label="Company Agent: activate to sort column ascending">
                                            قيد الحجز </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 82.25px;"
                                            aria-label="Company Agent: activate to sort column ascending">
                                            تم التعاقد </th>
                                            <th class="sorting" tabindex="0" aria-controls="m_table_1"
                                            rowspan="1" colspan="1" style="width: 82.25px;"
                                            aria-label="Company Agent: activate to sort column ascending">
                                            الغاء التعاقد </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($reportData)){ for($i=0;$i<count($reportData);$i++){?>
                            <tr class="clickable-row task-list-row" style="cursor: pointer;" data-priority ="<?php echo $i ?>" data-href= "<?php echo $reportData[$i]->userID?>">
                                <td data-toggle="tooltip" data-placement="top" title="<?php echo $reportData[$i]->Name?>" >
                                    <?php echo $reportData[$i]->Name?>

                                </td>

                                <td>
                                    <?php echo $reportData[$i]->TotalCalls?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->NoAnswerCalls?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->FollowCalls?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->ReservationCalls?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->contractCalls?>
                                </td>
                                <td>
                                    <?php echo $reportData[$i]->DecontractCalls?>
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





<script src=" https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?= $url ?>design/assets/js/jquery.dataTables.min (2).js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="vendors/bootstrap-datetime-picker/js/date_time.js" type="text/javascript"></script>


<script>

    jQuery(document).ready(function ($) {
        $(".clickable-row").click(function() {
            var UserID = $(this).data("href");
            window.location="<?= $url ?>reports/employeeDetails/" +UserID ;
        });

        var title ='';
        if (<?= $type ?> == 3 ) {
            title = 'تقرير الموظفين';
        }else if (<?= $type ?> == 2){
            title = 'تقرير المشرفين';
        }
        var Topmsg = "<center>";
        Topmsg += "<h1>"+title+"</h1>";
        Topmsg += "من تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date1)); ?>";
        Topmsg += " إلى تاريخ : ";
        Topmsg += "<?=  date("d-m-Y", strtotime($date2)); ?>";
        Topmsg += "<center>";
        Topmsg += "<br>";
        var BottomMsg ="<br><br>";
        BottomMsg += "إجمالى عدد المكالمات :\xa0";
        BottomMsg += "<?= $TotalCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        BottomMsg += "إجمالى لم يتم الرد :\xa0";
        BottomMsg += "<?= $NoAnswerCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        BottomMsg += "إجمالى المتابعات :\xa0";
        BottomMsg += "<?= $FollowCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        BottomMsg += "إجمالى قيد الحجز :\xa0";
        BottomMsg += "<?= $ReservationCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        BottomMsg += "إجمالى تم التعاقد :\xa0";
        BottomMsg += "<?= $contractCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        BottomMsg += "إجمالى إلغاء التعاقد :\xa0";
        BottomMsg += "<?= $DecontractCalls ?>\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0";
        $('.my_table').DataTable({
            "paging": true,
            "pagingType": "full_numbers",
            "info": false,
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
                    messageBottom:BottomMsg,
                    customize: function (win) {

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
        window.location.href = "<?= $url ?>reports/employee/<?= $type?>/" + DateRange;
    });
</script>

</body>

</html>
</div>