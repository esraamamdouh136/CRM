<?php $this->load->view("header");?>

		
       	 <div class="contains">



            <br />

            <!--mail-body       -->


            <div class="tab-content">

                <div class="mail-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="بحث " title="Type for a group">
                        </div>
                        <div class="col-md-4">
                 <button id="add-group" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">اضافه مجموعة
                  </button>
  
                        </div>

                    </div> <br><br>
                    <div class="row">
                        <div class="col-md-11">
                            <ul id="myUL" class="list-group list-group-hover list-group-striped">
                                <li data-toggle="modal" data-target="#exampleModal2" class="item list-group-item"><a class="item" href="#"> المجموعة 1</a>
                                </li>
                                <li data-toggle="modal" data-target="#exampleModal2" class="item list-group-item"><a class="item" href="#">المجموعة 2</a></li>
                                <li data-toggle="modal" data-target="#exampleModal2" class="item list-group-item"><a class="item" href="#">المجموعة 3</a></li>
                                <li data-toggle="modal" data-target="#exampleModal2" class="item list-group-item"><a class="item" href="#">المجموعة 4</a></li>
                                <li data-toggle="modal" data-target="#exampleModal2" class="item list-group-item"><a class="item" href="#">المجموعة 5</a></li>
                            </ul>
                        </div>
<!--
                            <div class="col-md-3">
                             <ul id="myUL" class="list-group list-group-hover list-group-striped">
                                <li ><input type="button" value="مسح" class="btn btn-red mands">
                                </li>
                                <li ><input type="button" value="مسح" class="btn btn-red mands">
                                </li>
                                  <li ><input type="button" value="مسح" class="btn btn-red mands">
                                </li>
                                  <li ><input type="button" value="مسح" class="btn btn-red mands">
                                </li>
                                  <li ><input type="button" value="مسح" class="btn btn-red mands">
                                </li>
                            </ul>
                        </div>
-->
                        
                         
                    </div>
         
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">تفاصيل المجموعة</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container1">
                                        <form action="/action_page.php">
                                            <div class="row">
                                                <div class="col-75">
                                                    <input type="text" id="name-text" name="name">
                                                </div>
                                                <div class="col-25">
                                                    <label for="name">اسم المجموعه</label>
                                                </div>
                                            </div> <br> <br>
                                            <div class="row">
                                                <div class="col-75">
                                                    <input type="checkbox" name="customer" value="add"> اضافه عملاء<br>
                                                    <input type="checkbox" name="customer" value="delete"> مسح عملاء<br>
                                                    <input type="checkbox" name="customer" value="edit"> تعديل عملاء<br>
                                                </div>
                                                <div class="col-25">
                                                    <label for="name">الصلاحيات:</label>
                                                </div>
                                            </div> <br> <br>
                                            <div class="row">
                                                <div class="col-md-12" style="text-align:center">
                                                    <input type="button" data-dismiss="modal" aria-label="Close" value="اضافه" id="addgroup">

                                                </div>

                                            </div>
                                            <br>
                                        </form>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                  
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">تفاصيل المجموعة</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container1">
                                        <form action="/action_page.php">
                                            <div class="row">
                                                <div class="col-75">
                                                    <input type="text" id="name-text1" name="name">
                                                </div>
                                                <div class="col-25">
                                                    <label for="name">اسم المجموعه</label>
                                                </div>
                                            </div> <br> <br>
                                            <div class="row">
                                                <div class="col-75">
                                                    <input type="checkbox" name="customer" value="add" checked> اضافه عملاء<br>
                                                    <input type="checkbox" name="customer" value="delete"> مسح عملاء<br>
                                                    <input type="checkbox" name="customer" value="edit"> تعديل عملاء<br>
                                                </div>
                                                <div class="col-25">
                                                    <label for="name">الصلاحيات:</label>
                                                </div>
                                            </div> <br> <br>
                                            <div class="row">
                                                <div class="col-md-12" style="text-align:center">
                                                    <input type="button" data-dismiss="modal" aria-label="Close" value="حفظ" id="savegroup">

                                                </div>

                                            </div>
                                            <br>
                                        </form>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>




                </div>


            </div>


          
            <br />


        </div>


    </div>



  		<link rel="stylesheet" href="http://173.212.198.28:8010/crm/design/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">

		<link rel="stylesheet" href="http://173.212.198.28:8010/crm/design/assets/js/select2/select2-bootstrap.css">
		<link rel="stylesheet" href="http://173.212.198.28:8010/crm/design/assets/js/select2/select2.css">
		<link rel="stylesheet" href="http://173.212.198.28:8010/crm/design/assets/js/selectboxit/jquery.selectBoxIt.css">

		<!-- Bottom Scripts -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/gsap/main-gsap.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/bootstrap.js"></script>

		<script src="http://173.212.198.28:8010/crm/design/assets/js/joinable.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/resizeable.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/neon-api.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/bootstrap-datepicker.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/raphael-min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/morris.min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/select2/select2.min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/jquery.multi-select.js"></script>
		<script src="http://173.212.198.28:8010/crm/design/assets/js/toastr.js"></script>
		
		<script src="http://173.212.198.28:8010/crm/design/assets/js/neon-custom.js"></script>
    <script src="http://173.212.198.28:8010/crm/design/assets/js/neon-demo.js"></script>
    <script>
    
          var item;
            
                    $('.item').click( function(){
                        item=$(this).find("a");
                        
            document.getElementById('name-text1').value = item.text();
                        
       
  }); 
        
         $('#savegroup').click( function(){
             item.html($('#name-text1').val());
         });
        
      
    
</script>

    
</body>
</html>