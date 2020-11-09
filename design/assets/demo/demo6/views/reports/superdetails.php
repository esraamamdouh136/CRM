<?php $this->load->view("header"); 
 $total=0;
 $follow=0;
 $close=0;
 $resrve=0;

?>

<div class="main-content">
    <br><br>

      <button class="btn btn-sm pull-right btn-success">طباعه هذه الصفحه</button>
<br><br>
    
			
			<div class="row">
			<table id="myTable" class="table table-striped display  ">

						<thead>
							<tr  class="rowstyle">
								<th></th>
						
								<th>الكود</th>
								<th>اسم المشرف</th>
								<th>اجمالي عدد المكالمات</th>
								<th>عدد المكالمات المتابعه</th>
								<th>عدد المكالمات قيد الحجز</th>
                                <th>عدد المكالمات الغاء متابعه</th>
							</tr>
						</thead>
						<tbody>
                            
						<?php if(isset($super)){ for($i=0;$i<count($super);$i++){?>
							<tr>
								<td></td>
								<td><a href='<?= $url ."reports/empldetails/".$super[$i]->userCrmId?>' class="bgcolor"><?php echo $super[$i]->userCrmId?></a></td>
							   
								<td><?php echo $super[$i]->userCrmName?> </td>
								
								<td><?php echo get_Call($super[$i]->userCrmId,NULL,NULL)?></td>
								<td><?php echo get_Call($super[$i]->userCrmId,NULL,1)?></td>
								<td><?php echo get_Call($super[$i]->userCrmId,NULL,2)?></td>
								<td><?php echo get_Call($super[$i]->userCrmId,NULL,3)?></td>
						
							</tr>
                                                <?php } } ?>
							
						</tbody>
					</table>    
			</div>
    <br> <br>
			<div class="row">
				<div class="col-sm-12">





					<ul class="nav nav-tabs bordered">
						<!-- available classes "bordered", "right-aligned" -->
						<li class="active">
					<a href="#home" data-toggle="tab">
					<span class="visible-xs">الموظفين التابعين له</span>
					<span class="hidden-xs">الموظفين التابعين له</span>
				   </a>
						</li>
					
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="home">

							<table id="myTable" class="table table-striped my_table">

								<thead>

							<tr>
										<th></th>
										<th>الكود</th>
                                     
										<th>الاسم</th>
                                      
                                        <th>اجمالي عدد المكالمات</th>
                                        <th>عدد المكالمات المتابعه</th>
                                        <th>عدد المكالمات قيد الحجز</th>
                                        <th>عدد المكالمات الغاء متابعه</th>
										


									</tr>
								</thead>
								<tbody>
								<?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){
									   $total+=get_Call($emps[$i]->userCrmId,NULL,NULL);
									   $follow+=get_Call($emps[$i]->userCrmId,NULL,1);
									   $resrve+=get_Call($emps[$i]->userCrmId,NULL,2);
									   $close+=get_Call($emps[$i]->userCrmId,NULL,3);
									   
									
									?>
									<tr>
										<td></td>
										<td><a href='<?= $url ."reports/empldetails/".$emps[$i]->userCrmId?>' class="bgcolor"><?php echo $emps[$i]->userCrmId?></a></td>
                                       
										<td><?php echo $emps[$i]->userCrmName?> </td>
                                        
                                        <td><?php echo get_Call($emps[$i]->userCrmId,NULL,NULL)?></td>
                                        <td><?php echo get_Call($emps[$i]->userCrmId,NULL,1)?></td>
                                        <td><?php echo get_Call($emps[$i]->userCrmId,NULL,2)?></td>
                                        <td><?php echo get_Call($emps[$i]->userCrmId,NULL,3)?></td>
								
									</tr>
                                                                <?php } } ?>
									
														
										
											
											
											
									
								</tbody>
							</table>
						</div>
                        
                        

					</div>





				</div>


			</div>

<br> <br>
    
<div class="row">
	
	<div class="col-md-6">
		
		<div class="panel panel-danger" data-collapsed="0">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title">اجمالي عدد المكالمات</div>
				
				<div class="panel-options">
					
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
					
					<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
				</div>
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				
				<p><?php echo $total ?> مكالمه</p>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="col-md-6">
		
		<div class="panel panel-info" data-collapsed="0">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title">اجمالي عدد المكالمات المتابعه</div>
				
				<div class="panel-options">
					
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
					
					<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
				</div>
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				
				<p><?php echo $follow ?> مكالمات</p>
				
			</div>
			
		</div>
		
	</div>
	
</div>
    
<div class="row">
	
	<div class="col-md-6">
		
		<div class="panel panel-success" data-collapsed="0">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title">اجمالي عدد مكالمات الغاء متابعه</div>
				
				<div class="panel-options">
					
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
					
					<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
				</div>
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				
				<p><?php echo $close ?> مكالمات</p>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="col-md-6">
		
		<div class="panel panel-warning" data-collapsed="0">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title">اجمالي عدد مكالمات قيد الحجز</div>
				
				<div class="panel-options">
					
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				
					<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
				</div>
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				
				<p><?php echo $resrve ?> مكالمات</p>
				
			</div>
			
		</div>
		
	</div>
	
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
<script src="<?= $url ?>design/assets/js/dataTables.buttons.min.js"></script>
<script src="<?= $url ?>design/assets/js/buttons.flash.min.js"></script>
<script src="<?= $url ?>design/assets/js/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="<?= $url ?>design/assets/fonts/vfs_fonts.js"></script>
<script src="<?= $url ?>design/assets/js/buttons.html5.min.js"></script>
<script src="<?= $url ?>design/assets/js/buttons.print.min.js"></script>
    
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

<script>
$(".btn-success").click(function () {
    print();
});
</script>


</body>

</html>