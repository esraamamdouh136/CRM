
<?php $this->load->view("header");?>

	<div class="main-content">
		


<div class="row">
	<div class="col-sm-12">

	
	<br>
		
			<table id="myTable" class="table table-striped data-table">

            <thead>
            
                                                <tr>
                                                    <th><a class="btn btn-success" href="<?php echo $url.'users/adduser'?>">+ اضافة</a></th>
                                                    <th>الكود</th>
                                                    <th>الاسم</th>
                                                    <th>المشرف</th>
                                                    <th>العمليات</th>
            
            
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){?>
                                                <tr>
                                                    <td> </td>
                                                    <td><?php echo $emps[$i]->userCrmId?></td>
                                                    <td data-toggle="tooltip" data-placement="top" title="<?php echo $emps[$i]->userCrmName?>"><?php echo $emps[$i]->userCrmName?></td>
                                                     <td><?php echo get_name($emps[$i]->userCrmSuper,1)?></td>
                                                    <td>
                         
                         <a class="btn btn-danger btn-sm icon-left activeuser" status="<?php echo $emps[$i]->active?>" userid="<?php echo $emps[$i]->userCrmId?>"><?php $status="تعطيل"; if($emps[$i]->active!=1){ $status="تفعيل";} echo $status;?> </a>
                                                        <a href="<?php echo $url.'users/edit_user/'.$emps[$i]->userCrmId?>" class="btn btn-blue btn-sm icon-left" id="t3del">
                          <i class="entypo-pencil"></i>
                          تعديل</a>
                                                    </td>
                                                   
                                                </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
	
				
			</div>
	
					
		
		
		
		
		
		
	


</div>


</div>


<br />


</div>
	

	
		<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
			<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
		<link rel="stylesheet" href="assets/js/select2/select2.css">
		<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
		<script src="assets/js/gsap/main-gsap.js"></script>
		<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
		<script src="assets/js/bootstrap.js"></script>
		<script src="assets/js/joinable.js"></script>
		<script src="assets/js/resizeable.js"></script>
		<script src="assets/js/neon-api.js"></script>
		<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
		<script src="assets/js/bootstrap-datepicker.js"></script>
		<script src="assets/js/raphael-min.js"></script>
		<script src="assets/js/morris.min.js"></script>
		<script src="assets/js/select2/select2.min.js"></script>
		<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
		<script src="assets/js/jquery.multi-select.js"></script>
		<script src="assets/js/toastr.js"></script>

		<script src="assets/js/jquery.dataTables.min (2).js"></script>
		<script src="assets/js/neon-custom.js"></script>
		<script src="assets/js/neon-demo.js"></script>
</body>
</html>