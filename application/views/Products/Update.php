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

                <?php echo form_open($url.'Products/updateData'); ?>
                <input type="hidden" name="productID" value="<?=$Product->Product_ID?>">
                <div class="form-group">
                  <label class="col-sm-3 control-label">المنتج / الخدمه</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" name="ProductName" class="form-control" placeholder="إسم المنتج / الخدمه" value="<?=$Product->Product_Name?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">النوع</label>
                    <div class="col-sm-3">
                        <div class="input-group"  style="width: 87%;">
                            <select name="ProductType" class="form-control">
                                <option value="1" <?=($Product->Product_Type==1)?'selected':'' ?>>منتج</option>
                                <option value="2" <?=($Product->Product_Type==2)?'selected':'' ?>>خدمة</option>
                            </select>
                        </div>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-3 control-label">السعر</label>
                    <div class="col-sm-2">
                        <div class="input-group" >
                            <input type="number" class="form-control" min="0"  name="ProductPrice" placeholder="السعر" value="<?=$Product->Price?>">
                        </div>
                    </div>
                    <label class="col-sm-1 control-label">ج.م</label>

                </div>

              
                <div class="form-group" >
                    <label class="col-sm-3 control-label">إلغاء الحجز خلال(بالايام)</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="number" class="form-control" min="0"  name="CancelIn" placeholder="إلغاء الحجز خلال" value="<?=$Product->Cancel_IN?>">
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                    <label class="col-sm-3 control-label">الوصف</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <textarea  name="ProductDescription" class="form-control" placeholder="الوصف" cols="30" rows="5" ><?=$Product->Description?></textarea>
                        </div>
                    </div>
                </div>


                <div class="form-group">

                    <input type="submit" style="margin-top: 20px;" class="btn btn-blue esbutton" value="إضافة">

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