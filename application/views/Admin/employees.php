<?php $this->load->view("header");?>
<div class="contains">
   <div class="row">
      <div class="col-sm-12">
         <ul class="nav nav-tabs bordered">
            <!-- available classes "bordered", "right-aligned" -->
            <?php $per=get_pre($_SESSION["userid"],5);
               $per1=get_pre($_SESSION["userid"],6);
                       if($_SESSION["usertype"]==1 || $per1==1  )
                       {?>
            <li class="active">
               <a href="#home" data-toggle="tab">
               <span class="visible-xs">مشرفين</span>
               <span class="hidden-xs">مشرفين</span>
               </a>
            </li>
            <?php }  if($_SESSION["usertype"]==1 || $per==1  ){?>
            <li>
               <a href="#profile" data-toggle="tab">
               <span class="visible-xs">موظفين</span>
               <span class="hidden-xs">موظفين</span>
               </a>
            </li>
            <?php }?>
         </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
               <table id="myTable" class="table table-striped data-table">
                  <thead>
                     <tr>
                        <th><a  class="btn btn-success" href="<?php echo $url.'users/addsuper'?>">+ اضافة</a></th>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>  تاريخ انشاء الحساب </th>
                        <th>العمليات</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(isset($supers)){ for($i=0;$i<count($supers);$i++){?>
                     <tr>
                        <td> </td>
                        <td><?php echo $supers[$i]->userCrmId?></td>
                        <td>
                           <a href="<?php echo $url.'users/list_users/'.$supers[$i]->userCrmId?>" class="bgcolor"><?php echo $supers[$i]->userCrmName?>
                           <a>
                        </td>
                        <td><?= date("Y-m-d", strtotime($emps[$i]->userCrmCreateDate)) ?></td>
                        <td>
                        <a class="btn btn-danger btn-sm icon-left activeuser" status="<?php echo $supers[$i]->active?>" userid="<?php echo $supers[$i]->userCrmId?>"><?php $status="تعطيل"; if($supers[$i]->active==0){ $status="تفعيل";} echo $status;?> </a>
                        <a href="<?php echo $url.'users/edit_user/'.$supers[$i]->userCrmId?>" class="btn btn-blue btn-sm icon-left" id="t3del">
                        <i class="entypo-pencil"></i>
                        تعديل</a>
                        </td>
                     </tr>
                     <?php } }?>
                  </tbody>
               </table>
            </div>
            <div class="tab-pane" id="profile">
               <table  class="table table-striped data-table">
                  <thead>
                     <tr>
                        <th><a class="btn btn-success" href="<?php echo $url.'users/adduser'?>">+ اضافة</a></th>
                        <th>الكود</th>
                        <th>الاسم</th>
                        <th>المشرف</th>
                        <th>  تاريخ انشاء الحساب </th>
                        <th>العمليات</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(isset($emps)){ for($i=0;$i<count($emps);$i++){?>
                     <tr> 
                        <td> </td>
                        <td><?php echo $emps[$i]->userCrmId?></td>
                        <td><?php echo $emps[$i]->userCrmName?></td>
                        <td><?php echo get_name($emps[$i]->userCrmSuper,1)?></td>
                        <td><?= date("Y-m-d", strtotime($emps[$i]->userCrmCreateDate)) ?></td>
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
   </div>
   <br />
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
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/jquery.dataTables.min (2).js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
<script>
   $(".activeuser").click(function(){
   
         var userid=$(this).attr("userid");
         var status=$(this).attr("status");
         var base=$("#base").val();
         var element=$(this);
         $.ajax({
             type: "POST",
             url: base+"users/delete",
             data: ({userid:userid,
                     status:status
             }),
             success: function(data) {
                 if(status==1)
                 {
                   element.attr("status",0);
                   element.text("تفعيل");
                   toastr.success("تم تعطيل المستخدم بنجاح"); 
                 }else
                 {
                   element.attr("status",1);
                   element.text("تعطيل");
                   toastr.success("تم تفعيل المستخدم بنجاح");
                 }                
              }
         });
   
   });
</script>
</body>
</html>