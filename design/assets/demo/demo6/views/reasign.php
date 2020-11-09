<?php $this->load->view("header"); ?>
<form method="post" action="<?php echo $url."users/reasgin_user"?>">

<div class="contains">


			<div class="row bordes" >
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading">
                        <div class="panel-title">
                        اعادة تعيين المهام
                        </div>

                        <div class="panel-options">

                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>

                        </div>
                    </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="es-radio1">
                                            <div class="col-md-2 edites">
                                            <p>اعادة التعيين الى:</p>
                                            </div>
                                        <div  class="col-md-3 edites">
                                            <input type="radio" name="optradio"  id="radio1">
                                            <select id="sel1" class="esradio" name="newsuper" disabled>
                                                <option value="" selected >المشرفين</option>
                                                <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                                                        <option value="<?php echo $supers[$i]->userCrmId?>"><?php echo $supers[$i]->userCrmName?></option>
                                                <?php } }?>

                                            </select>
                                        </div>
                                    <div class="col-md-3 edites">
                                            <input type="radio" name="optradio" id="radio2">
                                            <select id="sel2" name="newemp" disabled>
                                                <option value="" selected >الموظفين</option>

                                                <?php if(isset($emps)){  for($i=0;$i<count($emps);$i++){?>
                                                    <option value="<?php echo $emps[$i]->userCrmId?>"><?php echo $emps[$i]->userCrmName?></option>
                                                <?php } } ?>
                                            </select>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="">
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label for="message-text" class="col-form-label" >ملاحظات:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea class="form-control etextar comment" name="note" rows="4" cols="50" id="message-text"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2 esend">
                                    <INPUT type="button" value="ارسال" class="btn btn-black btn-lg" id="button11" />
                                </div>
                            </div>
                        </div>
						
						

				</div>
				</div>
			</div>
			<div class="row">
				<div class="escharge">
					<div class="row">
						<div class="col-sm-4">
							<img src="assets/images/calls.png" class="esrotate" />
							<p>المكالمات</p>
							<p><?php echo countCall($userid,0)?></p>
						</div>
						<div class="col-sm-4">
							<img src="assets/images/done.png" class="esrotate" />
							<p>تمت</p>
							<p><?php echo countCall($userid,0)-countCall($userid,1)?></p>
						</div>
						<div class="col-sm-4">
							<img src="assets/images/rest.png" class="esrotate" />
							<p>المتبقية</p>
							<p><?php echo countCall($userid,1)?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
               <input type="hidden" id="resestcount" name="resetcount" value="<?php echo count($reset)?>">
               <input type="hidden" id="userid" name="userid" value="<?php echo $userid?>">
				<table id="myTable" class="table table-striped display data-table">

					<thead>
						<tr>
							<th><input type="checkbox" value="" id="checkAll" class="chk"></th>

							<th>الاسم</th>
							<th>التليفون</th>
							<th>الشركة</th>
							<th>الوظيفة</th>
						</tr>
					</thead>
					<tbody>
                        <?php for ($i=0; $i < count($reset); $i++) { 
                        ?>
						<tr>
                            <td><input type="checkbox"   class="<?php echo 'chk elem'.$i?>">
                            <input type="hidden" class="<?php echo 'custid'.$i?>" value="<?php echo $reset[$i]->customerCrmId?>">
                            
                        </td>
							<td data-toggle="tooltip" data-placement="top" title="<?php echo $reset[$i]->customerCrmName?>"><?php echo $reset[$i]->customerCrmName?></td>
							<td><?php echo $reset[$i]->customerCrmPhone?></td>
							<td><?php echo $reset[$i]->customerCrmCompany?></td>
							<td><?php echo $reset[$i]->customerCrmJob?></td>
						</tr>
                        <?php }?>
					</tbody>
				</table>
			</div>




		</div>


	</div>

    </div>
 </form>


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
<script src="assets/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>

	<script src="assets/js/jquery.dataTables.min (2).js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>
    <script>
 $('.elem').change(function() {
    if($(this).is(":checked")) { 
        $(this).siblings(".custom").val(1);   
    }
    else
    {
        $(this).siblings(".custom").val(0);   

    }

});
$("#button11").click(function(){
    debugger;
    var base=$("#base").val();
   var resetcount=$("#resestcount").val();
   var comment=$(".comment").val();
   var newuser;
   if($("#sel1").val()!=null)
    {
      newuser=$("#sel1").val();
    }
    else if($("#sel2").val()!=null)
    {
        newuser=$("#sel2").val();   
    }
    var olduser=$("#userid").val();
    for(var i=0;i<resetcount;i++)
    {
        if($('.elem'+i).is(":checked")){
            var customerid=$('.custid'+i).val(); 
            $.ajax({
                type: "POST",
                url: base + "users/reasgin_user",
                data: ({
                    customerid:customerid,
                    newuser:newuser,
					olduser:olduser,
					comment:comment
                }),
                success: function (data) {
                    window.location=base+"users/reasign/"+olduser;
                }
            });
     }
   }

});
        </script>

</body>

</html>