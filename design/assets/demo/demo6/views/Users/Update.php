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

                <?php echo form_open($url.'/Transfer/updateData'); ?>
                <input type="hidden" name="transID" value="<?=$Transfer->transfer_ID?>">
                <div class="form-group">
                    <label class="col-sm-3 control-label">طريقة الشحن</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" name="transferName" class="form-control" placeholder="طريقة الشحن" value="<?=$Transfer->transfer_Name ?>" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"> تكلفة الشحن</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="number" min="0" value="<?=$Transfer->Price ?>" name="transferPrice" placeholder=" تكلفة الشحن" >
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label">الوصف</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <textarea  name="transferDescription" class="form-control" placeholder="الوصف" cols="30" rows="5" ><?=$Transfer->Description ?></textarea>
                        </div>
                    </div>
                </div>



                <div class="form-group">

                    <input type="submit" style="margin-top: 20px;" class="btn btn-blue esbutton" value="حفظ">

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>