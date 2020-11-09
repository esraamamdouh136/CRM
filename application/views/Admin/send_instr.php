<?php  $this->load->view("header");?>

<div class="contains">




			<br />

		
			<div class="mail-env">

			
				<div class="mail-body">

				



					<div class="mail-text">
						<div>
						<div class="form-group">
						<label class="col-sm-2 control-label">الي:</label>
						
						<div class="col-sm-5">
							
						 <div class="form-group">
   
    
        <select id="dates-field2" class="multiselect-ui form-control" multiple="multiple">
            <option value="cheese">مادونا</option>
            <option value="tomatoes">مادونا</option>
            <option value="mozarella">مادونا</option>
            <option value="mushrooms">مادونا</option>
            <option value="pepperoni">مادونا</option>
            
        </select>
    
</div>
							
	</div>
         
    <div class="col-sm-5">                        
      <div class="form-group">
   
    
        <select id="dates-field3" class="multiselect-ui2 form-control" multiple="multiple">
            <option value="cheese">مادونا</option>
            <option value="tomatoes">مادونا</option>
            <option value="mozarella">مادونا</option>
            <option value="mushrooms">مادونا</option>
            <option value="pepperoni">مادونا</option>
            
        </select>
    
</div>  
</div>
					
                       
</div>
						<br><br>
						<a> <i class="fas fa-location-arrow"></i> العنوان:</a>
						<input type="text" name="fname" style=" margin-right: 8%;padding: 10px">

						<br><br>
						<a>  <i class="fas fa-envelope"></i>الرساله:</a>
						<br>
						<textarea rows="4" cols="50" name="comment" form="usrform">
Enter text here...</textarea>

						<br><br>
						<a href="#">
							<div class="send">
								<p>ارسال</p>
							</div>
						</a>
					</div>




				</div>

				<!-- Sidebar -->


			</div>


		</div>



	</div>






	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">


	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>

	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>

	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>

	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>
	<script src="assets/js/bootstrap-multiselect.js"></script>
	<script src="assets/js/jquery.multi-select.js"></script>
	
 <script type="text/javascript">
$(function() {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 3,
         nonSelectedText: 'الموظفين'
    });
});
</script>
<script type="text/javascript">
$(function() {
    $('.multiselect-ui2').multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 3,
         nonSelectedText: 'المشرفين'
    });
});
</script>

</body>
</html>