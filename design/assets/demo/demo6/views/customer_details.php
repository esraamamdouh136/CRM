<?php $this->load->view("header");?>
<div class="contains">


    <br />

    <div class="row">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    كود العميل
                </div>
            </div>
            <div class="panel-body">
                <form role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">الاسم</label>

                        <div class="col-sm-5">
                            <input type="text" name="name" required value="<?php echo $client[0]->customerCrmName?>" class="form-control" id="field-1" placeholder="الاسم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-3" class="col-sm-3 control-label">الهاتف</label>

                        <div class="col-sm-5">
                            <input type="tel" name="phone" required value="<?php echo $client[0]->customerCrmPhone?>"  class="form-control esform-control" id="field-3" placeholder="(رقم الهاتف)">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-3" class="col-sm-3 control-label">الهاتف2</label>
                        <div class="col-sm-5">
                            <input type="tel" name="phone2" value="<?php echo $client[0]->fphone?>" class="form-control esform-control" id="field-3" placeholder="(رقم الهاتف)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1"  class="col-sm-3 control-label">البريد الالكتروني</label>

                        <div class="col-sm-5">
                            <input type="email" name="email" value="<?php echo $client[0]->customerCrmEmail?>" class="form-control esform-control" id="field-file" placeholder="البريد الالكتروني">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">الشركة</label>

                        <div class="col-sm-5">
                            <input type="text" name="company" value="<?php echo $client[0]->customerCrmCompany?>" class="form-control" id="field-ta" placeholder="الشركة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">الوظيفة</label>

                        <div class="col-sm-5">
                            <input type="text" name="job" value="<?php echo $client[0]->customerCrmJob?>" class="form-control autogrow" id="field-ta" placeholder="الوظيفة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-4"  class="col-sm-3 control-label">العنوان</label>

                        <div class="col-sm-5">
                            <input type="text" name="address" value="<?php echo $client[0]->customerCrmAddress?>" class="form-control" id="field-4" placeholder="العنوان">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-4"  class="col-sm-3 control-label">المحافظة</label>

                        <div class="col-sm-5">
                            <input type="text" name="gov" value="<?php echo $client[0]->customerCrmGov?>" class="form-control" id="field-4" placeholder="المحافظة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-4"  class="col-sm-3 control-label">السن</label>

                        <div class="col-sm-5">
                            <input type="text" name="age" value="<?php echo $client[0]->fage?>" class="form-control" id="field-4" placeholder="السن">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-4"  class="col-sm-3 control-label">النوع</label>

                        <div class="col-sm-5">
                            <input type="text" name="type" value="<?php echo $client[0]->ftype?>" class="form-control" id="field-4" placeholder="النوع">
                        </div>
                    </div>







                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="button" class="btn btn-default esbutton" onclick="customer()">تم</button>
                        </div>
                    </div>
                </form>
                <div class="modal fade" id="es-exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="es-exampleModal">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">المحتوى</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control"  ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="custid" value="<?php echo $client[0]->customerCrmId?>">
                <div class="modal fade" id="es-exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">المحتوى</label>

                                    <div class="col-sm-5">
                                        <textarea class="form-control"  ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="es-exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">المحتوى</label>

                                    <div class="col-sm-5">
                                        <textarea class="form-control"  ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
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
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
<script>
    var url=$("#base").val();
    function customer() {



        var base=$("#base").val();
        var clientid=$(".custid").val();
        var name=$('[name="name"]').val();
        var phone=$('[name="phone"]').val();
        var phone2=$('[name="phone2"]').val();
        var email=$('[name="email"]').val();
        var address=$('[name="address"]').val();
        var company=$('[name="company"]').val();
        var job=$('[name="job"]').val();


        var gov=$('[name="gov"]').val();
        var age=$('[name="age"]').val();
        var type=$('[name="type"]').val();

        $.ajax({
            type: "POST",
            url: base+"users/update_client",
            data: ({clientid:clientid,
                name:name,
                phone:phone,
                phone2:phone2,
                email:email,
                address:address,
                company:company,
                job:job,
                gov:gov,
                age:age,
                type:type

            }),
            success: function(data) {
                toastr.success("تم التعديل بنجاح");
            }
        });



    }

</script>

</body>
</html>