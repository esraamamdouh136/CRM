<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:25 PM
 */
$this->load->view("header");
?>

<div class="contains">
    <div class="row">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <?php echo validation_errors('<div class="col-lg-12" style="align-content: center;color: red">', '</div>'); ?>

                <?php echo form_open($url.'Payment/Add'); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">طريقة الدفع</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="paymentName" class="form-control" placeholder="طريقة الدفع" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-4">
                        <input type="submit" style="margin-top: 20px;" class="btn btn-blue btn-block btn-lg" value="إضافة">
                    </div>
                </div>
            </div>
            </form>
        </div>
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
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
</body>

</html>