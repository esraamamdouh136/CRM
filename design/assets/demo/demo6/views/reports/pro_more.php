<?php $this->load->view("header") ?>

<div class="main-content">


			
			<div class="row">
			<table id="myTable" class="table table-striped display my_table ">

						<thead>
							<tr  class="rowstyle">
								<th></th>
								<th>الاسم</th>
								<th>التليفون</th>
								<th>حالة الحجز</th>
								<th>الشركة</th>
								<th>الوظيفة</th>
							</tr>
						</thead>
						<tbody>
                            
							<tr ondblclick="customer()" class="rowstyle">
								<td><input type="checkbox" value=""></td>
								<td>مادونا</td>
								<td>12345678</td>
								<td>Doe</td>
								<td>Doe</td>
								<td>Doe</td>
							</tr>
							
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
	<script src="<?= $url ?>design/assets/js/neon-demo.js"></script>
    
      <script src=" https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    
	<script src="<?= $url ?>design/assets/js/jquery.dataTables.min (2).js"></script>
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
								$(this).().columns.adjust().responsive.recalc();
							});
						});
								$('table.table input[type=checkbox]').click(function () {
    $(this).closest('tr').toggleClass("highlight", this.checked);
});	


		});
    </script>

</body>

</html>