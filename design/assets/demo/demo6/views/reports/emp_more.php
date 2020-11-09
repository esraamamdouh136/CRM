<?php $this->load->view("header");  ?>

<div class="main-content">


			
			<div class="row">
			<table id="myTable" class="table table-striped display my_table">

						<thead>
							<tr  class="rowstyle">
						
								<th>الاسم</th>
								<th>التليفون</th>
								<th>حالة الحجز</th>
								<th>الشركة</th>
								<th>الوظيفة</th>
								<th>تاريخ تعين المكالمه</th>
							</tr>
						</thead>
						<tbody>
                            <?php if(isset($customer)){ for($i=0;$i<count($customer);$i++){?>
							<tr ondblclick="customer()" class="rowstyle">
							
								<td data-toggle="tooltip" data-placement="top" title="<?php echo $customer[$i]->customerCrmName?>"><?php echo $customer[$i]->customerCrmName?></td>
								<td data-toggle="tooltip" data-placement="top" title="<?php echo $customer[$i]->customerCrmPhone?>"><?php echo $customer[$i]->customerCrmPhone?></td>
								<td data-toggle="tooltip" data-placement="top" title="<?php echo $customer[$i]->statusCrmContent?>"><?php echo $customer[$i]->statusCrmContent?></td>
								<td><?php echo $customer[$i]->customerCrmCompany?></td>
								<td><?php echo $customer[$i]->customerCrmJob?></td>
								<td><?php echo $customer[$i]->customerCrmDate?></td>

							</tr>
                            <?php } }?>
						</tbody>
					</table>
			</div>




		</div>



	</div>


	<link rel="stylesheet" href="<?= $url ?>design/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">


	<!-- Bottom Scripts -->
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
	<script src="<?= $url ?>design/assets/js/toastr.js"></script>

	
	<script src="<?= $url ?>design/assets/js/neon-custom.js"></script>
	<script src="<?= $url ?>crm/design/assets/js/neon-demo.js"></script>
    
    
       <script src=" https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="http://173.212.198.28:8010/crm/design/assets/js/jquery.dataTables.min (2).js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="<?= $url ?>design/assets/fonts/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
    
    
    	jQuery(document).ready(function ($) {
	
			
		

			$('.my_table').DataTable( {
        	"paging": true,
            "pagingType": "full_numbers",
            "info": true,
            "responsive": true,
        

        dom: 'Bfrtip',
                buttons: [
                    {
                        className: 'buttons-print',
                        extend: 'excel',
                        text: 'اكسيل'

                    },
                    {
                        className: 'buttons-print',
                        extend: 'print',
                        text: 'طباعة'

                    },
                    {
                        className: 'buttons-print',
                        extend: 'pdf',
                        text: 'ملف'

                    }

                ]
    } );

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



</body>

</html>